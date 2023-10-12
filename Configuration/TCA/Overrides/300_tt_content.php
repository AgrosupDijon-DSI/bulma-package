<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use AgrosupDijon\BulmaPackage\ItemsProcFuncs\ColPosList;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

$additionalColumns = [
    'background_color_class' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.none', 'value' => 'none'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.primary', 'value' => 'primary'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.info', 'value' => 'info'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.success', 'value' => 'success'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.warning', 'value' => 'warning'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.danger', 'value' => 'danger'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.light', 'value' => 'light'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.dark', 'value' => 'dark']
            ]
        ],
        'l10n_mode' => 'exclude',
    ],
    'background_frame' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_frame',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'value' => 'limited'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_frame.expanded', 'value' => 'expanded'],
            ]
        ],
    ],
    'gallery_size' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.gallery_size',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'value' => ''],
                ['label' => '80%', 'value' => '80'],
                ['label' => '60%', 'value' => '60'],
                ['label' => '40%', 'value' => '40'],
                ['label' => '20%', 'value' => '20']
            ]
        ],
        'l10n_mode' => 'exclude',
    ],
    'file_folder' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.file_folder',
        'config' => [
            'type' => 'folder',
        ]
    ],
    'readmore_label' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.readmore_label',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'size' => 50,
            'max' => 255
        ]
    ],
    'ignore_nav_hide' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.ignore_nav_hide',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
        ]
    ],
    'max_items' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.max_items',
        'config' => [
            'type' => 'input',
            'eval' => 'num',
            'size' => 5
        ]
    ]
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'frames',
    '--linebreak--,background_color_class,background_frame'
);
ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'menu_dir_settings',
    'ignore_nav_hide,max_items'
);

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'imageorient',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.imageorient.125',
        'value' => '125',
        'icon' => 'content-bulmapackage-beside-text-img-centered-right'
    ],
    '125',
    'after'
);
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'imageorient',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.imageorient.126',
        'value' => '126',
        'icon' => 'content-bulmapackage-beside-text-img-centered-left'
    ],
    '126',
    'after'
);

// field "ignore_nav_hide"
$menuTypes = [
    'menu_abstract',
    'menu_subpages',
    'menu_section_pages',
    'menu_sitemap_pages'
];
ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'ignore_nav_hide', implode(',', $menuTypes), 'after:pages');
ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'ignore_nav_hide', 'menu_sitemap', 'after:subheader');
ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'ignore_nav_hide', 'menu_categorized_pages', 'after:category_field');

// Override imagecols default value
$GLOBALS['TCA']['tt_content']['columns']['imagecols']['config']['default'] = 1;

// override space_before_class / space_after_class
$GLOBALS['TCA']['tt_content']['columns']['space_before_class']['config']['items'] = [
    ['label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 'value' => ''],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_none', 'value' => 'no-space'],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_large', 'value' => 'large'],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_extra_large', 'value' => 'xl'],
    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:space_class_negative_large', 'value' => 'negative-large'],
    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:space_class_negative_extra_large', 'value' => 'negative-xl'],
];
$GLOBALS['TCA']['tt_content']['columns']['space_after_class']['config']['items'] = [
    ['label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 'value' => ''],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_none', 'value' => 'no-space'],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_large', 'value' => 'large'],
    ['label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_extra_large', 'value' => 'xl'],
    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:space_class_negative_large', 'value' => 'negative-large'],
    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:space_class_negative_extra_large', 'value' => 'negative-xl'],
];

// Override table_class
$GLOBALS['TCA']['tt_content']['columns']['table_class']['config']['renderType'] = 'selectCheckBox';
$GLOBALS['TCA']['tt_content']['columns']['table_class']['config']['items'][0] = [
    'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tablelayout.fullwidth',
    'value' => 'fullwidth'
];

// if there is already a itemsProcFunc in the tt_content colPos tca, save it to another key for later usage
if (!empty($GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['itemsProcFunc'])) {
    $GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['bulma_package_itemsProcFunc'] = $GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['itemsProcFunc'];
}
// and set bulma_package itemsProcFuncs
$GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['itemsProcFunc'] = ColPosList::class . '->itemsProcFunc';