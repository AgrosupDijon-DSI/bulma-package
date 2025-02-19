<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

/***************
 * Enable Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:menu.thumbnail_list',
        'value' => 'menu_thumbnail_list',
        'icon' => 'content-menu-thumbnail',
    ],
    'menu_card_dir',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['menu_thumbnail_list'] = 'content-menu-thumbnail';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.menu_formlabel,
                image;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.default_thumbnail,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.thumbnaillayout;thumbnaillayout,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.accessibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.menu_accessibility;menu_accessibility,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
    ]
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'thumbnaillayout',
    'cols,table_class'
);

$GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list']['columnsOverrides']['image']['config']['maxitems'] = 1;
