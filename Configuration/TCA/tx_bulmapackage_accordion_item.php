<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'bulma_package.backend:accordion_item',
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
        'dynamicConfigFile' => '',
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-accordion-item',
        ],
        'hideTable' => true,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;frontend.ttc:palette.general;general,--palette--;;tab,--div--;frontend.ttc:tabs.access,--palette--;frontend.ttc:palette.visibility;visibility,--palette--;frontend.ttc:palette.access;access,--palette--;;hiddenLanguagePalette',
        ],
    ],
    'palettes' => [
        1 => [
            'showitem' => '',
        ],
        'access' => [
            'showitem' => '
                starttime;core.db.general:starttime,
                endtime;core.db.general:endtime
            ',
            'canNotCollapse' => 1,
        ],
        'general' => [
            'showitem' => '
                tt_content,
            ',
        ],
        'tab' => [
            'showitem' => '
                title,--linebreak--,
                record
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;bulma_package.backend:accordion_item
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
            'label' => 'core.general:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'core.general:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'tx_bulmapackage_accordion_item',
                'foreign_table_where' => 'AND tx_bulmapackage_accordion_item.pid=###CURRENT_PID### AND tx_bulmapackage_accordion_item.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'core.general:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'searchable' => false,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'core.general:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'core.general:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'searchable' => false,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'core.general:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'searchable' => false,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'tt_content' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
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
                    'newRecordLinkTitle' => 'bulma_package.backend:accordion_item.record.add',
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
                'foreign_field' => 'tx_bulmapackage_accordion_item_parent',
                'foreign_match_fields' => [
                    'tx_mask_content_role' => 'record',
                ],
            ],
            'exclude' => true,
            'label' => 'bulma_package.backend:accordion_item.record',
        ],
        'title' => [
            'config' => [
                'type' => 'input',
            ],
            'exclude' => true,
            'label' => 'bulma_package.backend:accordion_item.title',
        ],
    ],
];
