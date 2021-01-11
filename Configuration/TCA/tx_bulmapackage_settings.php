<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings',
        'label' => 'title_seo',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'title_seo,logo_main,logo_partner,logos_partners,code_analytics,address_title,address,zip,city,country,phone,fax,email',
        'typeicon_classes' => [
            'default' => 'actions-system-extension-configure',
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --palette--;;bulmapackage_sitetitle,
                --div--;Logos,
                logo_main,
                logos_partners,
                favicon,
                --div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tabs.bulmapackage_menu,
                menu_layout,
                --div--;Google Analytics,
                code_analytics,
                --div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.bulmapackage_address,
                --palette--;;bulmapackage_address,
                --div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tabs.bulmapackage_social,
                tx_bulmapackage_settings_link_item,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
            '
        ],
    ],
    'palettes' => [
        'bulmapackage_sitetitle' => [
            'showitem' => '
                title_seo
            ',
        ],
        'bulmapackage_address' => [
            'showitem' => '
                address_title,
                --linebreak--,
                address,
                --linebreak--,
                zip,
                city,
                --linebreak--,
                country,
                --linebreak--,
                phone,
                fax,
                --linebreak--,
                email
            ',
        ],
        'language' => [
            'showitem' => '
                sys_language_uid;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:sys_language_uid_formlabel,l18n_parent
            ',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_bulmapackage_settings',
                'foreign_table_where' => 'AND tx_bulmapackage_settings.pid=###CURRENT_PID### AND tx_bulmapackage_settings.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'title_seo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.title_seo',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255
            ]
        ],
        'logo_main' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.logo_main',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logo_main',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    crop,
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    crop,
                                    --palette--;;filePalette
                                '
                            ]
                        ]
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'logo_partner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.logo_partner',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logo_partner',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    link,--linebreak--,crop,
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    link,--linebreak--,crop,
                                    --palette--;;filePalette
                                '
                            ]
                        ]
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'logos_partners' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.logos_partners',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logos_partners',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette
                                '
                            ]
                        ]
                    ],
                    'maxitems' => 12
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'favicon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.favicon',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'favicon',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    crop,
                                    --palette--;;filePalette
                                '
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    crop,
                                    --palette--;;filePalette
                                '
                            ]
                        ]
                    ],
                    'maxitems' => 1
                ],
            "gif,jpg,jpeg,png,ico"
            ),
        ],
        'code_analytics' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.code_analytics',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 20,
                'placeholder' => 'UA-12345678-9'
            ],
        ],
        'address_title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.address_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.address',
            'config' => [
                'type' => 'text',
                'cols' => 20,
                'rows' => 3,
                'eval' => 'trim',
            ]
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.zip',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 20
            ]
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 128
            ]
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => 20,
                'max' => 30
            ]
        ],
        'fax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.fax',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 30
            ]
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 255,
                'softref' => 'email'
            ]
        ],
        'tx_bulmapackage_settings_link_item' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.tx_bulmapackage_settings_link_item',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bulmapackage_settings_link_item',
                'foreign_field' => 'tx_bulmapackage_settings',
                'appearance' => [
                    'newRecordLinkTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.tx_bulmapackage_settings_link_item.add',
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => false,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ]
                ],
                'behaviour' => [
                    'mode' => 'select'
                ]
            ]
        ],
        'menu_layout' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.menu_layout',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value',
                        ''
                    ],
                    [
                        'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.menu_layout.megamenu',
                        'megamenu'
                    ]
                ]
            ]
        ],
    ],
];
