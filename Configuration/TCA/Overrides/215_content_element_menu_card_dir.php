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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['menu_card_dir'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['menu_card_dir'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'bulma_package.backend:menu.card_dir',
        'value' => 'menu_card_dir',
        'icon' => 'content-bulmapackage-menu-card',
        'group' => 'menu',
    ],
    'menu_card_list',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['menu_card_dir'] = 'content-bulmapackage-menu-card';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['menu_card_dir'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['menu_card_dir'],
    [
        'showitem' => '
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
                pages;frontend.ttc:pages.ALT.menu_formlabel,
                --palette--;;menu_dir_settings,
                readmore_label,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;bulma_package.backend:palette.cardlayout;cardlayout,
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
