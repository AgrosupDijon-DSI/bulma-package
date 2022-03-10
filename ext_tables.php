<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

(function (){
    // Register new backend skin to override rte_ckeditor css
    $GLOBALS['TBE_STYLES']['skins']['bulma_package'] = [
        'name' => 'Override RTE',
        'stylesheetDirectories' => [
            'css' => 'EXT:bulma_package/Resources/Public/Css/Skin/'
        ]
    ];

    $typo3Branch = class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)
        ? (new \TYPO3\CMS\Core\Information\Typo3Version())->getBranch()
        : TYPO3_branch;
    if (version_compare($typo3Branch, '10.4', '<')) {
        $extensionName = 'AgrosupDijon.BulmaPackage';
        $controller = 'WebsiteModule';
    } else {
        $extensionName = 'BulmaPackage';
        $controller = \AgrosupDijon\BulmaPackage\Controller\WebsiteModuleController::class;
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $extensionName,
        'system',
        'WebsiteSettings',
        'top',
        [
            $controller => 'overview, customColors, metaTags'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:bulma_package/Resources/Public/Icons/module-dashboard.svg',
            'labels' => 'LLL:EXT:bulma_package/Resources/Private/Language/locallang_mod.xlf',
            'navigationComponentId' => '',
            'inheritNavigationComponentFromMainModule' => false
        ]
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bulmapackage_settings', 'EXT:bulma_package/Resources/Private/Language/locallang_csh_tx_bulmapackage_settings.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_settings');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_tab_item');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_accordion_item');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_card_group_item');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_carousel_item');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_icon_group_item');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bulmapackage_settings_link_item');

})();
