<?php

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use AgrosupDijon\BulmaPackage\Form\FormDataProvider\TcaColPosItem;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowDefaultValues;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use AgrosupDijon\BulmaPackage\Form\FormDataProvider\TcaCTypeItem;
use AgrosupDijon\BulmaPackage\Hooks\Backend\PageLayoutViewHook;
use AgrosupDijon\BulmaPackage\Parser\ScssParser;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\PreProcessHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaPageTitleHook;
use AgrosupDijon\BulmaPackage\Hooks\PageRenderer\BulmaMetaTagHook;
use AgrosupDijon\BulmaPackage\Updates\CardImageToMediaUpdate;
use AgrosupDijon\BulmaPackage\Updates\BackgroundFrameUpdate;
use AgrosupDijon\BulmaPackage\Updates\MediaToVideoContentElementUpdate;
use AgrosupDijon\BulmaPackage\Updates\BootstrapToBulmaRteUpdate;
use AgrosupDijon\BulmaPackage\Updates\BootstrapToBulmaAccordionUpdate;
use AgrosupDijon\BulmaPackage\Updates\BootstrapToBulmaTabUpdate;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

(function () {
    // https://usetypo3.com/application-context.html)
    if (Environment::getContext()->isDevelopment()) {
        // No cache in development
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = NullBackend::class;
        }
    }

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
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/ContentElement/All.tsconfig">');
    }

    // BackendLayouts
    if (!(bool)$bulmaPackageConfiguration['disablePageTsBackendLayouts']) {
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Mod/WebLayout/BackendLayouts.tsconfig"');
    }

    // TCEFORM
    if (!(bool)$bulmaPackageConfiguration['disablePageTsTCEFORM']) {
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/TCEFORM.tsconfig">');
    }

    // TCEMAIN
    if (!(bool)$bulmaPackageConfiguration['disablePageTsTCEMAIN']) {
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/TCEMAIN.tsconfig">');
    }

    // RTE
    if (!(bool)$bulmaPackageConfiguration['disablePageTsRTE']) {
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/RTE.tsconfig">');
    }

    // MOD
    ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Mod/Mod.tsconfig"');


    // Register icons for usage in backend
    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    $icons = [
        'content-bulmapackage-beside-text-img-centered-left' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/beside-text-img-centered-left.svg',
        'content-bulmapackage-beside-text-img-centered-right' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/beside-text-img-centered-right.svg',
        'content-bulmapackage-menu-card' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/menu-card.svg',
        'content-bulmapackage-tab' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/tab.svg',
        'content-bulmapackage-tab-item' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/tab-item.svg',
        'content-bulmapackage-accordion' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/accordion.svg',
        'content-bulmapackage-accordion-item' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/accordion-item.svg',
        'content-bulmapackage-card-group' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/card-group.svg',
        'content-bulmapackage-card-group-item' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/card-group-item.svg',
        'content-bulmapackage-carousel' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/carousel-item.svg',
        'content-bulmapackage-carousel-item' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/carousel-item.svg',
        'content-bulmapackage-icon-group' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/icon-group.svg',
        'content-bulmapackage-icon-group-item' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/icon-group-item.svg',
        'content-bulmapackage-iframe' => 'EXT:bulma_package/Resources/Public/Icons/ContentElements/iframe.svg',
        'settings-bulmapackage-link' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/link.svg',
        'settings-bulmapackage-facebook' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/facebook-f.svg',
        'settings-bulmapackage-twitter' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/twitter.svg',
        'settings-bulmapackage-youtube' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/youtube.svg',
        'settings-bulmapackage-instagram' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/instagram.svg',
        'settings-bulmapackage-vimeo' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/vimeo-v.svg',
        'settings-bulmapackage-viadeo' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/viadeo.svg',
        'settings-bulmapackage-linkedin' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/linkedin-in.svg',
        'settings-bulmapackage-tumblr' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/tumblr.svg',
        'settings-bulmapackage-discord' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/discord.svg',
        'settings-bulmapackage-snapchat-ghost' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/snapchat-ghost.svg',
        'settings-bulmapackage-book-open' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/book-open.svg',
        'settings-bulmapackage-user-graduate' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/user-graduate.svg',
        'settings-bulmapackage-user' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/user.svg',
        'settings-bulmapackage-lock' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/lock.svg',
        'content-bulmapackage-color' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/palette.svg'
    ];
    foreach ($icons as $identifier => $source) {
        $iconRegistry->registerIcon(
            $identifier,
            SvgIconProvider::class,
            ['source' => $source]
        );
    }

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][TcaColPosItem::class] = [
        'depends' => [
            DatabaseRowDefaultValues::class,
        ],
        'before' => [
            TcaSelectItems::class,
        ],
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][TcaCTypeItem::class] = [
        'depends' => [
            TcaSelectItems::class,
        ],
    ];

    // Hook to override colpos check for unused tt_content elements
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['record_is_used']['bulma_package'] = PageLayoutViewHook::class . '->contentIsUsed';

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
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:bulma_package/Configuration/TsConfig/Page/Extension/News.tsconfig">');
    }

    /***************
     * Register Upgrade Wizards
     */
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['cardImageToMediaUpdate'] = CardImageToMediaUpdate::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['backgroundFrameUpdate'] = BackgroundFrameUpdate::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['mediaToVideoContentElementUpdate'] = MediaToVideoContentElementUpdate::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['bootstrapToBulmaRteUpdate'] = BootstrapToBulmaRteUpdate::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['BootstrapToBulmaAccordionUpdate'] = BootstrapToBulmaAccordionUpdate::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['BootstrapToBulmaTabUpdate'] = BootstrapToBulmaTabUpdate::class;

    /***************
     * Require autoload for dependencies when not using composer
     */
    if (!Environment::isComposerMode()) {
        require ExtensionManagementUtility::extPath('bulma_package') . '/Resources/Private/Contrib/Php/vendor/autoload.php';
    }

})();
