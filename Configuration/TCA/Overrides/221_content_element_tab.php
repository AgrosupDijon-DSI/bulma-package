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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['tab'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['tab'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.tab',
        'value' => 'tab',
        'icon' => 'content-bulmapackage-tab'
    ],
    'html',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['tab'] = 'content-bulmapackage-tab';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['tab'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['tab'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                tx_bulmapackage_tab_item,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.tablayout;tablayout,
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
    'tx_bulmapackage_tab_item' => [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_tab_item',
            'foreign_field' => 'tt_content',
            'minitems' => '1',
            'appearance' => [
                'newRecordLinkTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item.add',
                'useSortable' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'showPossibleLocalizationRecords' => true,
                'expandSingle' => true,
                'enabledControls' => [
                    'localize' => true,
                ],
                'levelLinksPosition' => 'both'
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
    'tablayout',
    'table_class,table_header_position'
);
