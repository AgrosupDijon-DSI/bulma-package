<?php

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
     * @return bool|string
     * @throws \Exception
     */
    public function getCompiledFile($file)
    {
        $absoluteFile = GeneralUtility::getFileAbsFileName($file);
        $configuration = ($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_bulmapackage.']['settings.'] ?: []);

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
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'] as $className) {
                /** @var ParserInterface $parser */
                $parser = GeneralUtility::makeInstance($className);
                if ($parser->supports($settings['file']['info']['extension'])) {
                    if ($configuration['overrideParserVariables']) {
                        $settings['variables'] = $this->getVariablesFromPageLayout();
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

        return false;
    }

    /**
     * Clear all caches for the compiler.
     */
    protected function clearCompilerCaches()
    {
        GeneralUtility::rmdir(Environment::getPublicPath() . '/' . $this->tempDirectory, true);
    }

    protected function getVariablesFromPageLayout()
    {
        $variables = $layoutOverride = [];
        $layoutUid = $this->getCurrentPageLayout();
        $constants = $this->getConstants();

        $layouts = $this->getLayoutsFromConstants($constants);

        if (!empty($layoutUid)) {
            // Fetch overrides from typoscript constants
            if ($layoutUid < 100 && isset($layouts[$layoutUid])) {
                $layoutOverride = $layouts[$layoutUid];
            } elseif ($layoutUid >= 100) {
                // Fetch overrides from database
                $layoutOverride = $this->getLayoutFromDatabase($layoutUid / 100);
            }
        }

        // Check "special" key
        if($layoutOverride['text_dark'] == '1'){
            $layoutOverride = array_merge($layoutOverride, $layouts['text_dark']);
            unset($layoutOverride['text_dark']);
        }

        foreach ($layoutOverride as $variable => $value){
            $variables[$variable] = $value;
        }

        return $variables;
    }

    protected function getLayoutFromDatabase($layoutUid)
    {
        $layout = [];
        $result = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_bulmapackage_custom_color')
            ->select(
                ['*'],
                'tx_bulmapackage_custom_color',
                ['uid' => $layoutUid]
            )
            ->fetch();
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

    protected function getLayoutsFromConstants($constants)
    {
        $prefix = 'plugin.bulma_package.layout.';
        $layouts = [];
        foreach ($constants as $constant => $value) {
            if (strpos($constant, $prefix) === 0) {
                $key = substr($constant, strlen($prefix));
                $keyParts = explode('.', $key);

                $layouts[$keyParts[0]][$keyParts[1]] = $value;
            }
        }
        return $layouts;
    }

    protected function getCurrentPageLayout()
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
    protected function getRootLine($pageId)
    {
        return BackendUtility::BEgetRootLine($pageId, '', true, ['layout']);
    }

    /**
     * @return array
     */
    protected function getConstants()
    {
        if ($GLOBALS['TSFE']->tmpl->flatSetup === null
            || !is_array($GLOBALS['TSFE']->tmpl->flatSetup)
            || count($GLOBALS['TSFE']->tmpl->flatSetup) === 0) {
            $GLOBALS['TSFE']->tmpl->generateConfig();
        }
        return $GLOBALS['TSFE']->tmpl->flatSetup;
    }
}
