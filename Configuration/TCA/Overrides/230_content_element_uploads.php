<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['uploads'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['uploads'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
                --palette--;;headers,
                --palette--;;uploads,
                --palette--;;uploadslayout,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;;frames,
                --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.cardlayout;cardlayout,
                --palette--;;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
    ]
);

$displayCondLayoutCard = [
    'OR' => [
        'FIELD:CType:!=:uploads',
        'AND' => [
            'FIELD:CType:=:uploads',
            'FIELD:layout:=:3',
        ],
    ],
];

$GLOBALS['TCA']['tt_content']['columns']['table_class']['displayCond'] = $displayCondLayoutCard;
$GLOBALS['TCA']['tt_content']['columns']['cols']['displayCond'] = $displayCondLayoutCard;
$GLOBALS['TCA']['tt_content']['columns']['table_header_position']['displayCond'] = $displayCondLayoutCard;
