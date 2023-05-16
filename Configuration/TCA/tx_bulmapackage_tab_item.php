<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item',
        'label' => 'title',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'record,title',
        'dynamicConfigFile' => '',
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-tab-item',
        ],
        'hideTable' => true,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,--palette--;;tab,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--palette--;;hiddenLanguagePalette',
        ],
    ],
    'palettes' => [
        1 => [
            'showitem' => '',
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel
            ',
            'canNotCollapse' => 1
        ],
        'general' => [
            'showitem' => '
                tt_content,
                item_type;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType_formlabel,
            '
        ],
        'tab' => [
            'showitem' => '
                title,--linebreak--,
                record
            '
        ],
        'visibility' => [
            'showitem' => '
                hidden;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item
            ',
            'isHiddenPalette' => true,
        ],
        // hidden but needs to be included all the time, so sys_language_uid is set correctly
        'hiddenLanguagePalette' => [
            'showitem' => 'sys_language_uid, l10n_parent',
            'isHiddenPalette' => true,
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
                    0 => [
                        0 => '',
                        1 => 0,
                    ],
                ],
                'foreign_table' => 'tx_bulmapackage_tab_item',
                'foreign_table_where' => 'AND tx_bulmapackage_tab_item.pid=###CURRENT_PID### AND tx_bulmapackage_tab_item.sys_language_uid IN (-1,0)',
                'default' => 0,
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
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'renderType' => 'inputDateTime',
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'renderType' => 'inputDateTime',
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'tt_content' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    0 => [
                        0 => '',
                        1 => 0,
                    ],
                ],
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.sys_language_uid IN (-1,###REC_FIELD_sys_language_uid###)',
            ],
        ],
        'sorting' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'record' => [
            'config' => [
                'appearance' => [
                    'newRecordLinkTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item.record.add',
                    'collapseAll' => '1',
                    'enabledControls' => [
                        'dragdrop' => '1',
                    ],
                    'expandSingle' => '1',
                    'levelLinksPosition' => 'top',
                    'showAllLocalizationLink' => '1',
                    'showPossibleLocalizationRecords' => '1',
                    'showSynchronizationLink' => '1',
                    'useSortable' => '1',
                ],
                'foreign_sortby' => 'sorting',
                'foreign_table' => 'tt_content',
                'overrideChildTca' => [
                    'columns' => [
                        'colPos' => [
                            'config' => [
                                'default' => 999,
                            ],
                        ],
                        'CType' => [
                            'config' => [
                                'default' => 'text',
                            ],
                        ],
                    ],
                ],
                'type' => 'inline',
                'foreign_field' => 'tx_bulmapackage_tab_item_parent',
                'foreign_match_fields' => [
                    'tx_mask_content_role' => 'record'
                ]
            ],
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item.record',
        ],
        'title' => [
            'config' => [
                'type' => 'input',
            ],
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tab_item.title',
        ],
    ],
];
