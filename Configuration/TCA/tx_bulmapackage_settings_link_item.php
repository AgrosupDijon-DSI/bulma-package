<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Resource\File;
/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
return [
    'ctrl' => [
        'label' => 'label',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item',
        'delete' => 'deleted',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'hideTable' => true,
        'hideAtCopy' => true,
        'prependAtCopy' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.prependAtCopy',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_column' => 'icon',
        'typeicon_classes' => [
            'default' => 'settings-bulmapackage-link',
            'fas fa-link' => 'settings-bulmapackage-link',
            'fas fa-envelope' => 'settings-bulmapackage-envelope',
            'fas fa-map' => 'settings-bulmapackage-map',
            'fas fa-map-marker-alt' => 'settings-bulmapackage-map-marker',
            'fab fa-facebook-f' => 'settings-bulmapackage-facebook',
            'fab fa-twitter' => 'settings-bulmapackage-twitter',
            'fab fa-youtube' => 'settings-bulmapackage-youtube',
            'fab fa-instagram' => 'settings-bulmapackage-instagram',
            'fab fa-vimeo-v' => 'settings-bulmapackage-vimeo',
            'fab fa-viadeo' => 'settings-bulmapackage-viadeo',
            'fab fa-linkedin-in' => 'settings-bulmapackage-linkedin',
            'fab fa-tumblr' => 'settings-bulmapackage-tumblr',
            'fas fa-book-open' => 'settings-bulmapackage-book-open',
            'fas fa-user-graduate' => 'settings-bulmapackage-user-graduate',
            'fas fa-user' => 'settings-bulmapackage-user',
            'fas fa-lock' => 'settings-bulmapackage-lock',
            'fas fa-user-lock' => 'settings-bulmapackage-user-lock',
            'fab fa-discord' => 'settings-bulmapackage-discord',
            'fab fa-snapchat-ghost' => 'settings-bulmapackage-snapchat-ghost',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;;link,--palette--;;hiddenLanguagePalette'
        ],
    ],
    'palettes' => [
        'link' => [
            'showitem' => '
                label, force_label,--linebreak--,
                link,--linebreak--,
                icon_custom,--linebreak--,
                icon, icon_file, standalone
            '
        ],
        // hidden but needs to be included all the time, so sys_language_uid is set correctly
        'hiddenLanguagePalette' => [
            'showitem' => 'sys_language_uid, l10n_parent',
            'isHiddenPalette' => true,
        ],
    ],
    'columns' => [
        'tx_bulmapackage_settings' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bulmapackage_settings',
                'foreign_table_where' => 'AND tx_bulmapackage_settings.pid=###CURRENT_PID###',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ]
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language']
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'tx_bulmapackage_settings_link_item',
                'foreign_table_where' => 'AND tx_bulmapackage_settings_link_item.pid=###CURRENT_PID### AND tx_bulmapackage_settings_link_item.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.label',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'link' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'allowedTypes' => ['page', 'file', 'email', 'url', 'telephone'],
                'appearance' => [
                    'allowedOptions' => ['target', 'body', 'cc', 'bcc', 'subject'],
                ],
            ],
            'l10n_mode' => 'exclude',
        ],
        'force_label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.force_label',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'icon' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon',
            'displayCond' => 'FIELD:icon_custom:REQ:false',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'value' => 'fas fa-link', 'icon' => 'settings-bulmapackage-link'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.envelope', 'value' => 'fas fa-envelope', 'icon' => 'settings-bulmapackage-envelope'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.map', 'value' => 'fas fa-map', 'icon' => 'settings-bulmapackage-map'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.map_marker', 'value' => 'fas fa-map-marker-alt', 'icon' => 'settings-bulmapackage-map-marker'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.book', 'value' => 'fas fa-book-open', 'icon' => 'settings-bulmapackage-book-open'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.student', 'value' => 'fas fa-user-graduate', 'icon' => 'settings-bulmapackage-user-graduate'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.user', 'value' => 'fas fa-user','icon' =>  'settings-bulmapackage-user'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.user-lock', 'value' => 'fas fa-user-lock', 'icon' => 'settings-bulmapackage-user-lock'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.lock', 'value' => 'fas fa-lock', 'icon' => 'settings-bulmapackage-lock'],
                    ['label' => 'Facebook', 'value' => 'fab fa-facebook-f', 'icon' => 'settings-bulmapackage-facebook'],
                    ['label' => 'Twitter', 'value' => 'fab fa-twitter', 'icon' => 'settings-bulmapackage-twitter'],
                    ['label' => 'Youtube', 'value' => 'fab fa-youtube', 'icon' => 'settings-bulmapackage-youtube'],
                    ['label' => 'Instagram', 'value' => 'fab fa-instagram', 'icon' => 'settings-bulmapackage-instagram'],
                    ['label' => 'Vimeo', 'value' => 'fab fa-vimeo-v', 'icon' => 'settings-bulmapackage-vimeo'],
                    ['label' => 'Viadeo', 'value' => 'fab fa-viadeo', 'icon' => 'settings-bulmapackage-viadeo'],
                    ['label' => 'LinkedIn', 'value' => 'fab fa-linkedin-in', 'icon' => 'settings-bulmapackage-linkedin'],
                    ['label' => 'Tumblr', 'value' => 'fab fa-tumblr', 'icon' => 'settings-bulmapackage-tumblr'],
                    ['label' => 'Discord', 'value' => 'fab fa-discord', 'icon' => 'settings-bulmapackage-discord'],
                    ['label' => 'Snapchat', 'value' => 'fab fa-snapchat-ghost', 'icon' => 'settings-bulmapackage-snapchat-ghost'],
                ],
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'icon_file' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_file',
            'displayCond' => 'FIELD:icon_custom:REQ:true',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'overrideChildTca' => [
                    'types' => [
                        File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                    --palette--;;filePalette
                                '
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                                    --palette--;;filePalette
                                '
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;basicImageoverlayPaletteWithoutCrop,
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;filePalette
                            '
                        ],
                    ],
                ],
                'minitems' => 1,
                'maxitems' => 1,
                'allowed' => ['svg'],
            ],
            'l10n_mode' => 'exclude',
        ],
        'icon_custom' => [
            'exclude' => true,
            'onChange' => 'reload',
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon_custom',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'standalone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.standalone',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
    ],
];
