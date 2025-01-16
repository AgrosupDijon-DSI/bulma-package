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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['sharing_buttons'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['sharing_buttons'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.sharing_buttons',
        'value' => 'sharing_buttons',
        'icon' => 'actions-share-alt',
    ],
    'thumbnail_group',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['sharing_buttons'] = 'actions-share-alt';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['sharing_buttons'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['sharing_buttons'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                tx_bulmapackage_sharing_services,
                tx_bulmapackage_sharing_services_label,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.sharingbuttonslayout;sharingbuttonslayout,
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
        'columnsOverrides' => [
            'tx_bulmapackage_sharing_services' => [
                'description' => '',
                'config' => [
                    'minitems' => 1,
                ],
            ],
        ],
    ]
);

$additionalColumns = [
    'tx_bulmapackage_sharing_services' => $GLOBALS['TCA']['tx_bulmapackage_settings']['columns']['sharing_services'],
    'tx_bulmapackage_sharing_services_label' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.tx_bulmapackage_sharing_services_label',
        'config' => [
            'type' => 'input',
            'nullable' => true,
            'default' => null,
            'eval' => 'trim',
            'size' => 50,
            'max' => 255,
            'placeholder' => 'LLL:EXT:bulma_package/Resources/Private/Language/locallang.xlf:social_media_buttons.shareon.share',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'sharingbuttonslayout',
    'table_header_position'
);
