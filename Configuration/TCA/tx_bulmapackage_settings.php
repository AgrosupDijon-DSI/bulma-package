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
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings',
        'label' => 'title_seo',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'title_seo,wsd_name,wsd_alternate_name,logo_main,logos_partners,code_analytics,address_title,address,zip,city,country,phone,fax,email',
        'typeicon_classes' => [
            'default' => 'actions-system-extension-configure',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;;bulmapackage_sitetitle,--div--;Logos,logo_main,logos_partners,favicon,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tabs.bulmapackage_menu,menu_layout,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.google_settings,code_analytics,--palette--;;bulmapackage_wsd,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.bulmapackage_address,--palette--;;bulmapackage_address,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tabs.bulmapackage_links,tx_bulmapackage_settings_link_item,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tabs.bulmapackage_sharing,sharing_services,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language'
        ],
    ],
    'palettes' => [
        'bulmapackage_sitetitle' => [
            'showitem' => '
                title_seo
            ',
        ],
        'bulmapackage_wsd' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.bulmapackage_wsd.title',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.bulmapackage_wsd.description',
            'showitem' => '
                wsd_name, --linebreak--, wsd_alternate_name
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
                email,
                --linebreak--,
                latitude,
                longitude
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
                'type' => 'language',
            ],
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
                'default' => 0,
            ],
        ],
        'title_seo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.title_seo',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.title_seo.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim'
            ]
        ],
        'wsd_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.wsd_name',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.wsd_name.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim'
            ]
        ],
        'wsd_alternate_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.wsd_alternate_name',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.wsd_alternate_name.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
            'displayCond' => 'FIELD:wsd_name:REQ:true',
        ],
        'logo_main' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.logo_main',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'overrideChildTca' => [
                    'types' => [
                        File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                crop,
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                crop,
                                --palette--;;filePalette
                            '
                        ]
                    ]
                ],
                'maxitems' => 1,
                'allowed' => 'common-image-types',
            ],
        ],
        'logos_partners' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.logos_partners',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'overrideChildTca' => [
                    'types' => [
                        File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette
                            '
                        ]
                    ]
                ],
                'maxitems' => 12,
                'allowed' => 'common-image-types',
            ]
        ],
        'favicon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.favicon',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'overrideChildTca' => [
                    'types' => [
                        File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                crop,
                                --palette--;;filePalette
                            '
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                crop,
                                --palette--;;filePalette
                            '
                        ]
                    ]
                ],
                'maxitems' => 1,
                'allowed' => ['gif','jpg','jpeg','png','ico'],
            ]
        ],
        'code_analytics' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.code_analytics',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.code_analytics.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'max' => 255,
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
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.latitude',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 30
            ]
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.longitude',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 30
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
                        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value',
                        'value' => ''
                    ],
                    [
                        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.menu_layout.megamenu',
                        'value' => 'megamenu'
                    ],
                    [
                        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.menu_layout.megamenu_clickable',
                        'value' => 'megamenu_clickable'
                    ]
                ]
            ]
        ],
        'sharing_services' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services',
            'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.facebook', 'value' => 'facebook'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.twitter', 'value' => 'twitter'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.linkedin', 'value' => 'linkedin'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.email', 'value' => 'email'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.print', 'value' => 'print'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.sharing_services.copy-url', 'value' => 'copy-url'],
                ]
            ]
        ]
    ],
];
