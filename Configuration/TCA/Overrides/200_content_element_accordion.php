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
        'label' => 'bulma_package.backend:content_element.accordion',
        'value' => 'accordion',
        'icon' => 'content-bulmapackage-accordion',
        'group' => 'special',
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
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                tx_bulmapackage_accordion_item,
                tx_bulmapackage_accordion_item_active,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;frontend.ttc:palette.appearanceLinks;appearanceLinks,
            --div--;core.form.tabs:language,
                --palette--;;language,
            --div--;core.form.tabs:access,
                --palette--;;hidden,
                --palette--;frontend.ttc:palette.access;access,
            --div--;core.form.tabs:categories,
                categories,
            --div--;core.form.tabs:notes,
                rowDescription,
            --div--;core.form.tabs:extended,
        ',
    ]
);

$additionalColumns = [
    'tx_bulmapackage_accordion_item' => [
        'label' => 'bulma_package.backend:accordion_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_accordion_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkTitle' => 'bulma_package.backend:accordion_item.add',
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
        'label' => 'bulma_package.backend:field.tx_bulmapackage_accordion_item_active',
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
