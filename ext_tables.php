<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use AgrosupDijon\BulmaPackage\Controller\WebsiteModuleController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

(function (){
    // Register new backend skin to override rte_ckeditor css
    $GLOBALS['TBE_STYLES']['skins']['bulma_package'] = [
        'name' => 'Override RTE',
        'stylesheetDirectories' => [
            'css' => 'EXT:bulma_package/Resources/Public/Css/Skin/'
        ]
    ];

    ExtensionUtility::registerModule(
        'BulmaPackage',
        'system',
        'WebsiteSettings',
        'top',
        [
            WebsiteModuleController::class => 'overview, customColors, metaTags'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:bulma_package/Resources/Public/Icons/module-dashboard.svg',
            'labels' => 'LLL:EXT:bulma_package/Resources/Private/Language/locallang_mod.xlf',
            'navigationComponentId' => '',
            'inheritNavigationComponentFromMainModule' => false
        ]
    );

    ExtensionManagementUtility::addLLrefForTCAdescr('tx_bulmapackage_settings', 'EXT:bulma_package/Resources/Private/Language/locallang_csh_tx_bulmapackage_settings.xlf');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_settings');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_tab_item');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_accordion_item');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_card_group_item');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_carousel_item');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_icon_group_item');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_settings_link_item');

})();
