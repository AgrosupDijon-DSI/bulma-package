<?php

declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Service;

use AgrosupDijon\BulmaPackage\Parser\ParserInterface;
use AgrosupDijon\BulmaPackage\Utility\TypoScriptUtility;
use Doctrine\DBAL\Driver\Exception;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This service handles the parsing of scss files for the frontend.
 */
class CompileService
{
    /**
     * @var string
     */
    protected string $tempDirectory = 'typo3temp/assets/bulmapackage/css/';

    /**
     * @var string
     */
    protected string $tempDirectoryRelativeToRoot = '../../../../';

    /**
     * @param ServerRequestInterface $request
     * @param string $file
     * @return string|null
     * @throws Exception
     */
    public function getCompiledFile(ServerRequestInterface $request, string $file): ?string
    {
        $absoluteFile = GeneralUtility::getFileAbsFileName($file);
        $configuration = TypoScriptUtility::getSetup($request)['plugin.']['tx_bulmapackage.']['settings.'] ?? [];

        // Ensure cache directory exists
        if (!file_exists(Environment::getPublicPath() . '/' . $this->tempDirectory)) {
            GeneralUtility::mkdir_deep(Environment::getPublicPath() . '/' . $this->tempDirectory);
        }

        // Settings
        $settings = [
            'file' => [
                'absolute' => $absoluteFile,
                'relative' => $file,
                'info' => pathinfo($absoluteFile),
            ],
            'cache' => [
                'tempDirectory' => $this->tempDirectory,
                'tempDirectoryRelativeToRoot' => $this->tempDirectoryRelativeToRoot,
            ],
            'options' => [
                'override' => (bool)($configuration['overrideParserVariables'] ?? false),
                'sourceMap' => (bool)($configuration['cssSourceMapping'] ?? false),
                'compress' => true,
            ],
            'variables' => [],
        ];

        // Parser
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'])
            && is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'])
        ) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'] as $className) {
                /** @var class-string<ParserInterface> $className */
                $parser = GeneralUtility::makeInstance($className);
                if ($parser instanceof ParserInterface
                    && isset($settings['file']['info']['extension'])
                    && $parser->supports($settings['file']['info']['extension'])
                ) {
                    if ($configuration['overrideParserVariables'] ?? false) {
                        $defaultOverridedVariables = $this->getVariablesFromConstants($request, 'settings.' . $settings['file']['info']['extension']);
                        $pageLayoutOverridedVariables = $this->getVariablesFromPageLayout($request);
                        $settings['variables'] = array_merge($defaultOverridedVariables, $pageLayoutOverridedVariables);
                    }
                    try {
                        return $parser->compile($file, $settings);
                    } catch (\Exception $e) {
                        $this->clearCompilerCaches();
                        throw $e;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Clear all caches for the compiler.
     */
    protected function clearCompilerCaches(): void
    {
        GeneralUtility::rmdir(Environment::getPublicPath() . '/' . $this->tempDirectory, true);
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     * @throws Exception
     */
    protected function getVariablesFromPageLayout(ServerRequestInterface $request): array
    {
        $variables = $layoutOverride = [];
        $layoutUid = $this->getCurrentPageLayout($request);

        if (!empty($layoutUid)) {
            if ($layoutUid < 100) {
                // Fetch overrides from typoscript constants
                $layoutOverride = $this->getVariablesFromConstants($request, 'layout.' . $layoutUid);
            } else {
                // Fetch overrides from database
                $layoutOverride = $this->getLayoutFromDatabase((int)($layoutUid / 100));
            }
            // Fetch text_dark variables from typoscript constants
            $textDarkVariables = $this->getVariablesFromConstants($request, 'layout.text_dark');
        }

        // Check "special" key
        // If text_dark = 1 in the layout, and layout with a matching key exists, merge both layouts.
        if (isset($layoutOverride['text_dark']) && $layoutOverride['text_dark'] == '1' && isset($textDarkVariables)) {
            $layoutOverride = array_merge($layoutOverride, $textDarkVariables);
            unset($layoutOverride['text_dark']);
        }

        foreach ($layoutOverride as $variable => $value) {
            $variables[$variable] = $value;
        }

        return $variables;
    }

    /**
     * @param int $layoutUid
     * @return array
     * @throws Exception
     */
    protected function getLayoutFromDatabase(int $layoutUid): array
    {
        $layout = [];
        $result = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_bulmapackage_custom_color')
            ->select(
                ['*'],
                'tx_bulmapackage_custom_color',
                ['uid' => $layoutUid]
            )
            ->fetchAssociative();
        if (!empty($result)) {
            $prefix = 'var_';
            // Get rid of fields that aren't variables
            foreach ($result as $key => $value) {
                if (str_starts_with($key, $prefix)   && !empty($value)) {
                    $variableName = substr($key, strlen($prefix));
                    $layout[$variableName] = $value;
                }
            }
        }

        return $layout;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string $key
     * @return array
     */
    protected function getVariablesFromConstants(ServerRequestInterface $request, string $key): array
    {
        $constants = TypoScriptUtility::getConstants($request);
        $key = strtolower($key);
        $variables = [];

        // Fetch constants
        $prefix = 'plugin.bulma_package.' . $key . '.';
        foreach ($constants as $constant => $value) {
            if (str_starts_with($constant, $prefix)) {
                $variables[substr($constant, strlen($prefix))] = $value;
            }
        }

        return $variables;
    }

    /**
     * @param ServerRequestInterface $request
     * @return int
     */
    protected function getCurrentPageLayout(ServerRequestInterface $request): int
    {
        $rootLine = $request->getAttribute('frontend.page.information')?->getRootLine() ?? [];
        foreach ($rootLine as $rootLinePage) {
            if (!empty($rootLinePage['layout'])) {
                return (int)$rootLinePage['layout'];
            }
        }
        return 0;
    }
}
