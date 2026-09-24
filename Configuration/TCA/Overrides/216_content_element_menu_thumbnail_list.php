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
 * Enable Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'bulma_package.backend:menu.thumbnail_list',
        'value' => 'menu_thumbnail_list',
        'icon' => 'content-menu-thumbnail',
        'group' => 'menu',
    ],
    'menu_card_dir',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['menu_thumbnail_list'] = 'content-menu-thumbnail';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list'],
    [
        'showitem' => '
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                pages;frontend.ttc:pages.ALT.menu_formlabel,
                image;bulma_package.backend:field.default_thumbnail,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;bulma_package.backend:palette.thumbnaillayout;thumbnaillayout,
                --palette--;frontend.ttc:palette.appearanceLinks;appearanceLinks,
            --div--;frontend.ttc:tabs.accessibility,
                --palette--;frontend.ttc:palette.menu_accessibility;menu_accessibility,
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

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'thumbnaillayout',
    'cols,table_class'
);

$GLOBALS['TCA']['tt_content']['types']['menu_thumbnail_list']['columnsOverrides']['image']['config']['maxitems'] = 1;
