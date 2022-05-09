<?php

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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.carousel',
        'carousel',
        'content-bulmapackage-carousel'
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
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                tx_bulmapackage_carousel_item,
            --div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:carousel.options,
                pi_flexform;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:advanced,
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
        '
    ]
);

$additionalColumns = [
    'tx_bulmapackage_carousel_item' => [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:carousel_item',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_bulmapackage_carousel_item',
            'foreign_field' => 'tt_content',
            'appearance' => [
                'newRecordLinkTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:carousel_item.add',
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);

/***************
 * Add flexForms for content element configuration
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:bulma_package/Configuration/FlexForms/Carousel.xml',
    'carousel'
);
