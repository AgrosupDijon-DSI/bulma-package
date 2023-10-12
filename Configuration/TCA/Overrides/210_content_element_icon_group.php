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
 * Add Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['icon_group'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['icon_group'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.icon_group',
        'value' => 'icon_group',
        'icon' => 'content-bulmapackage-icon-group'
    ],
    'external_media',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['icon_group'] = 'content-bulmapackage-icon-group';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['icon_group'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['icon_group'],
    [
        'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
            tx_bulmapackage_icon_group_item,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.icongrouplayout;icongrouplayout,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
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
    '
    ]
);

$additionalColumns = [
    'tx_bulmapackage_icon_group_item' => [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_icon_group_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkAddTitle' => true,
                'useSortable' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'showPossibleLocalizationRecords' => true,
                'expandSingle' => true,
                'enabledControls' => [
                    'localize' => true,
                ]
            ],
            'behaviour' => [
                'mode' => 'select'
            ]
        ]
    ]
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'icongrouplayout',
    'cols,table_header_position,table_class'
);
