<?php

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
        'cruser_id' => 'cruser_id',
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
            'fab fa-discord' => 'settings-bulmapackage-discord',
            'fab fa-snapchat-ghost' => 'settings-bulmapackage-snapchat-ghost',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --palette--;;link,
                --palette--;;hiddenLanguagePalette,
            '
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
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:hidden.I.0'
                    ]
                ]
            ]
        ],
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    0 => [
                        0 => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        1 => -1,
                        2 => 'flags-multiple',
                    ],
                ],
                'special' => 'languages',
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    0 => [
                        0 => '',
                        1 => 0,
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
                'eval' => 'trim,required'
            ],
        ],
        'link' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'folder',
                            'blindLinkFields' => 'class, params, title'
                        ],
                    ],
                ],
                'softref' => 'typolink'
            ],
            'l10n_mode' => 'exclude',
        ],
        'force_label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.force_label',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
        'icon' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon',
            'displayCond' => 'FIELD:icon_custom:REQ:false',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'fas fa-link', 'settings-bulmapackage-link'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.book','fas fa-book-open', 'settings-bulmapackage-book-open'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.student','fas fa-user-graduate', 'settings-bulmapackage-user-graduate'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.user','fas fa-user', 'settings-bulmapackage-user'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon.lock','fas fa-lock', 'settings-bulmapackage-lock'],
                    ['Facebook', 'fab fa-facebook-f', 'settings-bulmapackage-facebook'],
                    ['Twitter', 'fab fa-twitter', 'settings-bulmapackage-twitter'],
                    ['Youtube', 'fab fa-youtube', 'settings-bulmapackage-youtube'],
                    ['Instagram', 'fab fa-instagram', 'settings-bulmapackage-instagram'],
                    ['Vimeo', 'fab fa-vimeo-v', 'settings-bulmapackage-vimeo'],
                    ['Viadeo', 'fab fa-viadeo', 'settings-bulmapackage-viadeo'],
                    ['LinkedIn', 'fab fa-linkedin-in', 'settings-bulmapackage-linkedin'],
                    ['Tumblr','fab fa-tumblr', 'settings-bulmapackage-tumblr'],
                    ['Discord','fab fa-discord', 'settings-bulmapackage-discord'],
                    ['Snapchat','fab fa-snapchat-ghost', 'settings-bulmapackage-snapchat-ghost'],
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
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'icon_file',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_UNKNOWN => [
                                'showitem' => '
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    title,
                                    alternative,
                                    crop,
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                    --palette--;;filePalette
                                '
                            ],
                        ],
                    ],
                    'minitems' => 0,
                    'maxitems' => 1,
                ],
                'svg'
            ),
            'l10n_mode' => 'exclude',
        ],
        'icon_custom' => [
            'exclude' => true,
            'onChange' => 'reload',
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.icon_custom',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
        'standalone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings_link_item.standalone',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
    ],
];
