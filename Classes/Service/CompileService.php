<?php declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Service;

use AgrosupDijon\BulmaPackage\Parser\ParserInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Doctrine\DBAL\Driver\Exception;

/**
 * This service handles the parsing of scss files for the frontend.
 */
class CompileService
{
    /**
     * @var string
     */
    protected $tempDirectory = 'typo3temp/assets/bulmapackage/css/';

    /**
     * @var string
     */
    protected $tempDirectoryRelativeToRoot = '../../../../';

    /**
     * @param string $file
     * @return string|null
     * @throws \Exception
     */
    public function getCompiledFile(string $file): ?string
    {
        $absoluteFile = GeneralUtility::getFileAbsFileName($file);
        $configuration = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_bulmapackage.']['settings.'] ?? [];

        // Ensure cache directory exists
        if (!file_exists($this->tempDirectory)) {
            GeneralUtility::mkdir_deep($this->tempDirectory);
        }

        // Settings
        $settings = [
            'file' => [
                'absolute' => $absoluteFile,
                'relative' => $file,
                'info' => pathinfo($absoluteFile)
            ],
            'cache' => [
                'tempDirectory' => $this->tempDirectory,
                'tempDirectoryRelativeToRoot' => $this->tempDirectoryRelativeToRoot,
            ],
            'options' => [
                'override' => $configuration['overrideParserVariables'] ? true : false,
                'sourceMap' => $configuration['cssSourceMapping'] ? true : false,
                'compress' => true
            ],
            'variables' => []
        ];

        // Parser
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'])
            && is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'])
        ) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'] as $className) {
                /** @var class-string $className */
                $parser = GeneralUtility::makeInstance($className);
                if ($parser instanceof ParserInterface
                    && isset($settings['file']['info']['extension'])
                    && $parser->supports($settings['file']['info']['extension'])
                ) {
                    if ($configuration['overrideParserVariables']) {
                        $defaultOverridedVariables = $this->getVariablesFromConstants('plugin.bulma_package.settings.' . strtolower($settings['file']['info']['extension']) . '.');
                        $pageLayoutOverridedVariables = $this->getVariablesFromPageLayout();
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
     *
     * @return void
     */
    protected function clearCompilerCaches(): void
    {
        GeneralUtility::rmdir(Environment::getPublicPath() . '/' . $this->tempDirectory, true);
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getVariablesFromPageLayout(): array
    {
        $variables = $layoutOverride = [];
        $layoutUid = $this->getCurrentPageLayout();

        if (!empty($layoutUid)) {
            if ($layoutUid < 100) {
                // Fetch overrides from typoscript constants
                $layoutOverride = $this->getVariablesFromConstants('plugin.bulma_package.layout.' . $layoutUid . '.');
            } else {
                // Fetch overrides from database
                $layoutOverride = $this->getLayoutFromDatabase((int)($layoutUid / 100));
            }
            // Fetch text_dark variables from typoscript constants
            $textDarkVariables = $this->getVariablesFromConstants('plugin.bulma_package.layout.text_dark.');
        }

        // Check "special" key
        // If text_dark = 1 in the layout, and layout with a matching key exists, merge both layouts.
        if(isset($layoutOverride['text_dark']) && $layoutOverride['text_dark'] == '1' && isset($textDarkVariables)){
            $layoutOverride = array_merge($layoutOverride, $textDarkVariables);
            unset($layoutOverride['text_dark']);
        }

        foreach ($layoutOverride as $variable => $value){
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
            foreach ($result as $key => $value){
                if (strpos($key, $prefix) === 0 && !empty($value)) {
                    $variableName = substr($key, strlen($prefix));
                    $layout[$variableName] = $value;
                }
            }
        }

        return $layout;
    }

    /**
     * @param string $prefix
     * @return array
     */
    protected function getVariablesFromConstants(string $prefix): array
    {
        $constants = $this->getConstants();
        $variables = [];
        
        foreach ($constants as $constant => $value) {
            if (strpos($constant, $prefix) === 0) {
                $variables[substr($constant, strlen($prefix))] = $value;
            }
        }
        
        return $variables;
    }

    /**
     * @return int
     */
    protected function getCurrentPageLayout(): int
    {
        $rootLine = $this->getRootLine($GLOBALS['TSFE']->id);
        foreach ($rootLine as $rootLinePage) {
            if (!empty($rootLinePage['layout'])) {
                return $rootLinePage['layout'];
            }
        }
        return 0;
    }

    /**
     * Gets the page root-line.
     *
     * @param int $pageId
     * @return array
     */
    protected function getRootLine(int $pageId): array
    {
        return BackendUtility::BEgetRootLine($pageId, '', true, ['layout']);
    }

    /**
     * @return array
     */
    protected function getConstants(): array
    {
        if ($GLOBALS['TSFE']->tmpl->flatSetup === null
            || !is_array($GLOBALS['TSFE']->tmpl->flatSetup)
            || count($GLOBALS['TSFE']->tmpl->flatSetup) === 0) {
            $GLOBALS['TSFE']->tmpl->generateConfig();
        }
        return $GLOBALS['TSFE']->tmpl->flatSetup;
    }
}
