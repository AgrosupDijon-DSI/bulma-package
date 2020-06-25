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
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --palette--;;link,
            '
        ],
    ],
    'palettes' => [
        'link' => [
            'showitem' => '
                label, force_label,--linebreak--,
                link,--linebreak--,
                icon
            '
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
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1
                    ],
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value',
                        0
                    ]
                ],
                'allowNonIdValues' => true,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0
                    ]
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
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Default', 'fas fa-link', 'settings-bulmapackage-link'],
                    ['Facebook', 'fab fa-facebook-f', 'settings-bulmapackage-facebook'],
                    ['Twitter', 'fab fa-twitter', 'settings-bulmapackage-twitter'],
                    ['Youtube', 'fab fa-youtube', 'settings-bulmapackage-youtube'],
                    ['Instagram', 'fab fa-instagram', 'settings-bulmapackage-instagram'],
                    ['Vimeo', 'fab fa-vimeo-v', 'settings-bulmapackage-vimeo'],
                    ['Viadeo', 'fab fa-viadeo', 'settings-bulmapackage-viadeo'],
                    ['LinkedIn', 'fab fa-linkedin-in', 'settings-bulmapackage-linkedin'],
                    ['Tumblr','fab fa-tumblr', 'settings-bulmapackage-tumblr'],
                ],
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ]
    ],
];
