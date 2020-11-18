<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

/***************
 * Add crop variants
 */
$defaultCropSettings = [
    'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default',
    'allowedAspectRatios' => [
        '16:9' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.16_9',
            'value' => 16 / 9
        ],
        '3:2' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.3_2',
            'value' => 3 / 2
        ],
        '3:1' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.3_1',
            'value' => 3.0
        ],
        '4:1' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.4_1',
            'value' => 4.0
        ],
        '6:1' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.6_1',
            'value' => 6.0
        ],
        '4:3' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.4_3',
            'value' => 4 / 3
        ],
        '1:1' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.1_1',
            'value' => 1.0
        ],
        '2:3' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.2_3',
            'value' => 2 / 3
        ],
        '1:2' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.1_2',
            'value' => 1 / 2
        ],
        '4:5' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.4_5',
            'value' => 4 / 5
        ],
        'NaN' => [
            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:ratio.free',
            'value' => 0.0
        ],
    ],
    'selectedRatio' => 'NaN',
    'cropArea' => [
        'x' => 0.0,
        'y' => 0.0,
        'width' => 1.0,
        'height' => 1.0,
    ]
];

/***************
 * Image content element
 */
$GLOBALS['TCA']['tt_content']['types']['image']['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Textpic content element
 */
$GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Video content element
 */
$GLOBALS['TCA']['tt_content']['types']['video']['columnsOverrides']['assets']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Textmedia content element
 */
$GLOBALS['TCA']['tt_content']['types']['textmedia']['columnsOverrides']['assets']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Card Group
 */
$GLOBALS['TCA']['tx_bulmapackage_card_group_item']['types']['1']['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Icon Group
 */
$GLOBALS['TCA']['tx_bulmapackage_icon_group_item']['types']['1']['columnsOverrides']['icon_file']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Carousel
 */
$GLOBALS['TCA']['tx_bulmapackage_carousel_item']['types']['1']['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;

/***************
 * Pages
 */
foreach ([1, 3, 4] as $type) {
    $GLOBALS['TCA']['pages']['types'][$type]['columnsOverrides']['thumbnail']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;
}
