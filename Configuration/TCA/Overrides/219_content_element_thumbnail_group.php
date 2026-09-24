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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['thumbnail_group'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['thumbnail_group'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'bulma_package.backend:content_element.thumbnail_group',
        'value' => 'thumbnail_group',
        'icon' => 'content-menu-thumbnail',
        'group' => 'special',
    ],
    'audio',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['thumbnail_group'] = 'content-menu-thumbnail';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['thumbnail_group'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['thumbnail_group'],
    [
        'showitem' => '
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                tx_bulmapackage_thumbnail_group_item,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;bulma_package.backend:palette.thumbnaillayout;thumbnaillayout,
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
    'tx_bulmapackage_thumbnail_group_item' => [
        'label' => 'bulma_package.backend:thumbnail_group_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_thumbnail_group_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkTitle' => 'bulma_package.backend:thumbnail_group_item.add',
                'useSortable' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'showPossibleLocalizationRecords' => true,
                'expandSingle' => true,
                'enabledControls' => [
                    'localize' => true,
                ],
            ],
            'behaviour' => [
                'mode' => 'select',
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
