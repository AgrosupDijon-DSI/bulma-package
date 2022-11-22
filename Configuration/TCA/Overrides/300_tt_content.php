<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.none', 'none'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.primary', 'primary'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.info', 'info'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.success', 'success'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.warning', 'warning'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.danger', 'danger'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.light', 'light'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_color_class.dark', 'dark']
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
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'limited'],
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.background_frame.expanded', 'expanded'],
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
                ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', ''],
                ['80%', '80'],
                ['60%', '60'],
                ['40%', '40'],
                ['20%', '20']
            ]
        ],
        'l10n_mode' => 'exclude',
    ],
    'file_folder' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.file_folder',
        'config' => [
            'type' => 'group',
            'internal_type' => 'folder',
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
            'items' => [
                [
                    0 => '',
                    1 => ''
                ]
            ],
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
        'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.imageorient.125',
        (string) 125,
        'content-bulmapackage-beside-text-img-centered-right'
    ],
    (string) 125,
    'after'
);
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'imageorient',
    [
        'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.imageorient.126',
        (string) 126,
        'content-bulmapackage-beside-text-img-centered-left'
    ],
    (string) 126,
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
    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', ''],
    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_none', 'no-space'],
];
$GLOBALS['TCA']['tt_content']['columns']['space_after_class']['config']['items'] = [
    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', ''],
    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_class_none', 'no-space'],
];

// Override table_class
$GLOBALS['TCA']['tt_content']['columns']['table_class']['config']['renderType'] = 'selectCheckBox';
$GLOBALS['TCA']['tt_content']['columns']['table_class']['config']['items'][0] = [
    'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tablelayout.fullwidth',
    'fullwidth'
];
