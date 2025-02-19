<?php

declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Parser;

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;
use ScssPhp\ScssPhp\Type;
use ScssPhp\ScssPhp\Version;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * ScssParser
 */
class ScssParser extends AbstractParser
{
    /**
     * @param string $extension
     * @return bool
     */
    public function supports(string $extension): bool
    {
        return $extension === 'scss';
    }

    /**
     * @param string $file
     * @param array $settings
     * @return string
     */
    public function compile(string $file, array $settings): string
    {
        $cacheIdentifier = $this->getCacheIdentifier($file, $settings);
        $cacheFile = $this->getCacheFile($cacheIdentifier, $settings['cache']['tempDirectory']);
        $cacheFileMeta = $this->getCacheFileMeta($cacheFile);
        $cacheFileMap = $this->getCacheFileMap($cacheFile);
        $compile = false;

        if (!$this->isCached($file, $settings)
            || $this->needsCompile($cacheFile, $cacheFileMeta, $settings)) {
            $compile = true;
        }

        if ($compile) {
            $result = $this->parseFile($file, $settings);
            if ($settings['options']['sourceMap']) {
                // Write css file and append reference to source map file
                GeneralUtility::writeFile(
                    GeneralUtility::getFileAbsFileName($cacheFile),
                    sprintf('%s /*# sourceMappingURL=%s */', $result['css'], basename($cacheFileMap))
                );
                // Write map file
                GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($cacheFileMap), $result['sourceMap']);
            } else {
                // Write css file
                GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($cacheFile), $result['css']);
            }
            GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($cacheFileMeta), serialize($result['cache']));
            $this->clearPageCaches();
        }

        return $cacheFile;
    }

    /**
     * @param string $file
     * @param array $settings
     * @return array
     */
    protected function parseFile(string $file, array $settings): array
    {
        $scss = new Compiler();
        $scss->setOutputStyle(OutputStyle::COMPRESSED);
        $scss->addVariables($settings['variables']);
        if ($settings['options']['sourceMap']) {
            $scss->setSourceMap(Compiler::SOURCE_MAP_FILE);
            $scss->setSourceMapOptions([
                'sourceMapRootpath' => $settings['cache']['tempDirectoryRelativeToRoot'],
                'sourceMapBasepath' => Environment::getProjectPath(),
                'outputSourceFiles' => true,
            ]);
        }
        $absoluteFilename = $settings['file']['absolute'];
        // Adds visual directory path of the initial file as import path
        // This scenarios happens, when e.g. developing packages using the `path`
        // repository feature of Composer - having one package in `public/typo3conf/ext/`
        // and the other one symlinked in e.g. `packages/`.
        // Since the PHP SCSS parser works on resolved real paths, the symlinked context is lost.
        $visualImportPath = dirname($absoluteFilename);
        $scss->addImportPath(function ($url) use ($visualImportPath): ?string {
            // Resolve potential back paths manually using PathUtility::getCanonicalPath,
            // but make sure we do not break out of TYPO3 application path using GeneralUtility::getFileAbsFileName
            // Also resolve EXT: paths if given
            $isTypo3Absolute = str_starts_with($url, 'EXT:') || PathUtility::isAbsolutePath($url);
            $fileName = $isTypo3Absolute ? $url : $visualImportPath . '/' . $url;
            $full = GeneralUtility::getFileAbsFileName(PathUtility::getCanonicalPath($fileName));
            // The API forces us to check the existence of files paths, with or without url.
            // We must only return a string if the file to be imported actually exists.
            $hasExtension = (bool)preg_match('/[.]s?css$/', $url);
            if (
                is_file($file = $full . '.scss') ||
                ($hasExtension && is_file($file = $full))
            ) {
                // We could trigger a deprecation message here at some point
                return $file;
            }

            return null;
        });
        // Add extensions path to import paths, so that we can use paths relative to this directory to resolve imports
        $scss->addImportPath(Environment::getExtensionsPath());

        // Make paths in url() statements relative to site root
        $absoluteFilePath = dirname($absoluteFilename);
        $relativeFilePath = PathUtility::getAbsoluteWebPath($absoluteFilePath);
        $absoluteBulmaPackageThemePath =
            ExtensionManagementUtility::extPath('bulma_package') . 'Resources/Public/Scss/Theme';
        $relativeBulmaPackageThemePath = PathUtility::getAbsoluteWebPath($absoluteBulmaPackageThemePath);
        $scss->registerFunction(
            'url',
            function ($args) use (
                $scss,
                $absoluteFilePath,
                $relativeFilePath,
                $absoluteBulmaPackageThemePath,
                $relativeBulmaPackageThemePath
            ): array {
                $marker = $args[0][1];
                $args[0][1] = '';
                $result = $scss->compileValue($args[0]);
                if (substr_compare($result, 'data:', 0, 5, true) !== 0) {
                    if (is_file(PathUtility::getCanonicalPath($absoluteFilePath . '/' . $result))) {
                        $result = PathUtility::getCanonicalPath($relativeFilePath . '/' . $result);
                    } elseif (is_file(PathUtility::getCanonicalPath($absoluteBulmaPackageThemePath . '/' . $result))) {
                        $result = PathUtility::getCanonicalPath($relativeBulmaPackageThemePath . '/' . $result);
                    } elseif (is_file(GeneralUtility::getFileAbsFileName(PathUtility::getCanonicalPath($result)))) {
                        $result = PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName(PathUtility::getCanonicalPath($result)));
                    }
                    $result = str_starts_with($result, '/') ? substr($result, 1) : $result;
                }
                return [Type::T_STRING, '', ['url(', $result, ')']];
            },
            ['args']
        );

        // Compile file. Second parameter is needed for source mapping
        $compilationResult = $scss->compileString('@import "' . $absoluteFilename . '"', $absoluteFilename);
        $css = $compilationResult->getCss();

        // Fix paths in url() statements to be relative to temp directory
        $relativeTempPath = $settings['cache']['tempDirectoryRelativeToRoot'];
        $search = '%url\s*\(\s*[\\\'"]?(?!(((?:https?:)?\/\/)|(?:data:?:)))([^\\\'")]+)[\\\'"]?\s*\)%';
        $replace = 'url("' . $relativeTempPath . '$3")';
        $css = (string)preg_replace($search, $replace, $css);

        return [
            'css' => $css,
            'sourceMap' => $compilationResult->getSourceMap(),
            'cache' => [
                'version' => Version::VERSION,
                'date' => date('r'),
                'css' => $css,
                'etag' => md5($css),
                'files' => $compilationResult->getIncludedFiles(),
                'variables' => $settings['variables'],
                'sourceMap' => $settings['options']['sourceMap'],
            ],
        ];
    }
}
