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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['accordion'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['accordion'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.accordion',
        'value' => 'accordion',
        'icon' => 'content-bulmapackage-accordion',
    ],
    'html',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['accordion'] = 'content-bulmapackage-accordion';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['accordion'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['accordion'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                tx_bulmapackage_accordion_item,
                tx_bulmapackage_accordion_item_active,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
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
        ',
    ]
);

$additionalColumns = [
    'tx_bulmapackage_accordion_item' => [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:accordion_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_accordion_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:accordion_item.add',
                'useSortable' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'showPossibleLocalizationRecords' => true,
                'expandSingle' => true,
                'enabledControls' => [
                    'localize' => true,
                ],
                'levelLinksPosition' => 'both',
            ],
            'behaviour' => [
                'mode' => 'select',
            ],
        ],
    ],
    'tx_bulmapackage_accordion_item_active' => [
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => '-', 'value' => 0],
            ],
            'foreign_table' => 'tx_bulmapackage_accordion_item',
            'foreign_table_where' => 'AND tx_bulmapackage_accordion_item.tt_content = ###THIS_UID###',
            'default' => 0,
        ],
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.tx_bulmapackage_accordion_item_active',
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
