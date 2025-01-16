<?php

use AgrosupDijon\BulmaPackage\Form\FormDataProvider\TcaCTypeItem;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaMetaTagHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaPageTitleHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\PreProcessHook;
use AgrosupDijon\BulmaPackage\Parser\ScssParser;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

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
 * Require autoload for dependencies when not using composer
 */
if (!Environment::isComposerMode()) {
    require ExtensionManagementUtility::extPath('bulma_package') . '/Resources/Private/Contrib/Php/vendor/autoload.php';
}

/***************
 * Register new backend stylesheet to override rte_ckeditor css
 */
$GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['bulma_package'] = 'EXT:bulma_package/Resources/Public/Css/Skin/';
