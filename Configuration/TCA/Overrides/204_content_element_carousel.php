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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['carousel'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['carousel'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'bulma_package.backend:content_element.carousel',
        'value' => 'carousel',
        'icon' => 'content-bulmapackage-carousel',
        'group' => 'special',
    ],
    'card_group',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['carousel'] = 'content-bulmapackage-carousel';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['carousel'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['carousel'],
    [
        'showitem' => '
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                tx_bulmapackage_carousel_item,
            --div--;bulma_package.backend:carousel.options,
                pi_flexform;bulma_package.backend:advanced,
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
    'tx_bulmapackage_carousel_item' => [
        'label' => 'bulma_package.backend:carousel_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_carousel_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkTitle' => 'bulma_package.backend:carousel_item.add',
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

/***************
 * Add flexForms for content element configuration
 */
$GLOBALS['TCA']['tt_content']['types']['carousel']['columnsOverrides']['pi_flexform']['config']['ds'] = 'FILE:EXT:bulma_package/Configuration/FlexForms/Carousel.xml';
