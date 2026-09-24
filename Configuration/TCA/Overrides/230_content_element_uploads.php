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
            --div--;core.form.tabs:general,
                --palette--;;general,
                --palette--;;headers,
                --palette--;;uploads,
                --palette--;;uploadslayout,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;;frames,
                --palette--;bulma_package.backend:palette.cardlayout;cardlayout,
                --palette--;;appearanceLinks,
            --div--;core.form.tabs:language,
                --palette--;;language,
            --div--;core.form.tabs:access,
                --palette--;;hidden,
                --palette--;;access,
            --div--;core.form.tabs:categories,
                categories,
            --div--;core.form.tabs:notes,
                rowDescription,
            --div--;core.form.tabs:extended,
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
