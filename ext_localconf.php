<?php

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use AgrosupDijon\BulmaPackage\Form\FormDataProvider\TcaCTypeItem;
use AgrosupDijon\BulmaPackage\Parser\ScssParser;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\PreProcessHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaPageTitleHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaMetaTagHook;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

// https://usetypo3.com/application-context.html)
//if (Environment::getContext()->isDevelopment()) {
//    // No cache in development
//    foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
//        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = NullBackend::class;
//    }
//}

/***************
 * Define TypoScript as content rendering template
 */
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'bulmapackage/Configuration/TypoScript/';
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'bulmapackage/Configuration/TypoScript/ContentElement/';

/***************
 * Make the extension configuration accessible
 */
$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
$bulmaPackageConfiguration = $extensionConfiguration->get('bulma_package');

/***************
 * UserTS
 */
ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.tx_bulmapackage_settings = 0');

/***************
 * PageTS
 */
// Add Content Elements
if (!(bool)$bulmaPackageConfiguration['disablePageTsContentElements']) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/ContentElement/All.tsconfig"');
}

// BackendLayouts
if (!(bool)$bulmaPackageConfiguration['disablePageTsBackendLayouts']) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Mod/WebLayout/BackendLayouts.tsconfig"');
}

// TCEFORM
if (!(bool)$bulmaPackageConfiguration['disablePageTsTCEFORM']) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/TCEFORM.tsconfig"');
}

// TCEMAIN
if (!(bool)$bulmaPackageConfiguration['disablePageTsTCEMAIN']) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/TCEMAIN.tsconfig"');
}

// RTE
if (!(bool)$bulmaPackageConfiguration['disablePageTsRTE']) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/RTE.tsconfig"');
}

// MOD
ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Mod/Mod.tsconfig"');

// CType filter for content in accordions/tabs
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][TcaCTypeItem::class] = [
    'depends' => [
        TcaSelectItems::class,
    ],
];

/***************
 * Register "asd" as global fluid namespace
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['asd'][] = 'AgrosupDijon\\BulmaPackage\\ViewHelpers';

/***************
 * Add default RTE configuration for Bulma package
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['bulma'] = 'EXT:bulma_package/Configuration/RTE/Default.yaml';

/***************
 * Register css processing parser
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/bulma-package/css']['parser'][ScssParser::class] = ScssParser::class;

/***************
 * Register css processing hooks
 */
if (!(bool)$bulmaPackageConfiguration['disableScssProcessing']) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][PreProcessHook::class] = PreProcessHook::class . '->execute';
}

/***************
 * Register title processing hooks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][BulmaPageTitleHook::class] = BulmaPageTitleHook::class . '->execute';

/***************
 * Register Meta tags hooks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][BulmaMetaTagHook::class] = BulmaMetaTagHook::class . '->execute';

/***************
 * Register news extra templateLayouts
 */
if (ExtensionManagementUtility::isLoaded('news')) {
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Extension/News.tsconfig"');
}

/***************
 * Require autoload for dependencies when not using composer
 */
if (!Environment::isComposerMode()) {
    require ExtensionManagementUtility::extPath('bulma_package') . '/Resources/Private/Contrib/Php/vendor/autoload.php';
}
