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
        'label' => 'bulma_package.backend:content_element.sharing_buttons',
        'value' => 'sharing_buttons',
        'icon' => 'actions-share-alt',
        'group' => 'special',
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
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                tx_bulmapackage_sharing_services,
                tx_bulmapackage_sharing_services_label,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;bulma_package.backend:palette.sharingbuttonslayout;sharingbuttonslayout,
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
        'label' => 'bulma_package.backend:field.tx_bulmapackage_sharing_services_label',
        'config' => [
            'type' => 'input',
            'nullable' => true,
            'default' => null,
            'eval' => 'trim',
            'size' => 50,
            'max' => 255,
            'placeholder' => 'bulma_package.messages:social_media_buttons.shareon.share',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'sharingbuttonslayout',
    'table_header_position'
);
