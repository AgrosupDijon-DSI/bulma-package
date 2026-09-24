<?php

use TYPO3\CMS\Core\Resource\FileType;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
return [
    'ctrl' => [
        'label' => 'header',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'bulma_package.backend:carousel_item',
        'delete' => 'deleted',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'hideTable' => true,
        'hideAtCopy' => true,
        'prependAtCopy' => 'core.general:LGL.prependAtCopy',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-carousel-item',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;frontend.ttc:palette.general;general,image,--palette--;bulma_package.backend:palette.text;header,--palette--;bulma_package.backend:palette.call_to_action;call_to_action,--div--;bulma_package.backend:tabs.colors,text_color,background_color,--div--;frontend.ttc:tabs.access,--palette--;frontend.ttc:palette.visibility;visibility,--palette--;frontend.ttc:palette.access;access,--palette--;;hiddenLanguagePalette',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => '',
        ],
        'access' => [
            'showitem' => '
                starttime;core.db.general:starttime,
                endtime;core.db.general:endtime
            ',
        ],
        'header' => [
            'showitem' => '
                header,
                --linebreak--,
                header_layout,
                --linebreak--,
                subheader
            ',
        ],
        'general' => [
            'showitem' => '
                tt_content,
            ',
        ],
        'call_to_action' => [
            'showitem' => '
                button_text,
                link,
                button_class
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;bulma_package.backend:carousel_item
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
        'tt_content' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.tt_content',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.CType IN ("carousel")',
                'maxitems' => 1,
                'default' => 0,
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
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'core.general:LGL.language',
            'config' => ['type' => 'language'],
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
                'foreign_table' => 'tx_bulmapackage_carousel_item',
                'foreign_table_where' => 'AND tx_bulmapackage_carousel_item.pid=###CURRENT_PID### AND tx_bulmapackage_carousel_item.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'link' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => [
                    'browserTitle' => 'bulma_package.backend:carousel_item.link',
                ],
            ],
        ],
        'header' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.header',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'header_layout' => [
            'exclude' => true,
            'label' => 'core.general:LGL.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => 'core.general:LGL.default_value',
                        'value' => '0',
                    ],
                    [
                        'label' => 'frontend.ttc:header_layout.I.6',
                        'value' => '100',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'text_color' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.text_color',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.has-background-transparent-dark', 'value' => 'has-background-transparent-dark'],
                    ['label' => 'bulma_package.backend:option.has-background-transparent-light', 'value' => 'has-background-transparent-light'],
                    ['label' => 'bulma_package.backend:option.dark', 'value' => 'has-text-dark'],
                    ['label' => 'bulma_package.backend:option.light', 'value' => 'has-text-light'],
                ],
            ],
            'l10n_mode' => 'exclude',
        ],
        'subheader' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.subheader',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'button_text' => [
            'label' => 'bulma_package.backend:carousel_item.button_text',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 255,
            ],
        ],
        'button_class' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.button_class',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.default', 'value' => ''],
                    ['label' => 'bulma_package.backend:option.primary', 'value' => 'is-primary'],
                    ['label' => 'bulma_package.backend:option.success', 'value' => 'is-success'],
                    ['label' => 'bulma_package.backend:option.info', 'value' => 'is-info'],
                    ['label' => 'bulma_package.backend:option.warning', 'value' => 'is-warning'],
                    ['label' => 'bulma_package.backend:option.danger', 'value' => 'is-danger'],
                    ['label' => 'bulma_package.backend:option.light', 'value' => 'is-light'],
                    ['label' => 'bulma_package.backend:option.dark', 'value' => 'is-dark'],
                ],
            ],
            'l10n_mode' => 'exclude',
        ],
        'background_color' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.background_color',
            'config' => [
                'type' => 'color',
            ],
            'l10n_mode' => 'exclude',
        ],
        'image' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:carousel_item.image',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'frontend.ttc:images.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        FileType::UNKNOWN->value => [
                            'showitem' => '
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::TEXT->value => [
                            'showitem' => '
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::AUDIO->value => [
                            'showitem' => '
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::VIDEO->value => [
                            'showitem' => '
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::APPLICATION->value => [
                            'showitem' => '
                                --palette--;;filePalette
                            ',
                        ],
                    ],
                ],
                'maxitems' => 1,
                'allowed' => 'common-image-types',
            ],
            'l10n_mode' => 'exclude',
        ],
    ],
];
