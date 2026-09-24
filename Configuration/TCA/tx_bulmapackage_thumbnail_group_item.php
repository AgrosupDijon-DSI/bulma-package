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
        'label_alt' => 'subheader',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'bulma_package.backend:thumbnail_group_item',
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
            'default' => 'content-menu-thumbnail',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;frontend.ttc:palette.general;general,--palette--;bulma_package.backend:card_group_item.header;header,media,link,--div--;frontend.ttc:tabs.access,--palette--;frontend.ttc:palette.visibility;visibility,--palette--;frontend.ttc:palette.access;access,--palette--;;hiddenLanguagePalette',
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
                subheader,
            ',
        ],
        'general' => [
            'showitem' => '
                tt_content
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;bulma_package.backend:card_group_item
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
            'label' => 'bulma_package.backend:card_group_item.tt_content',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.{#CType}="thumbnail_group"',
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
                'foreign_table' => 'tx_bulmapackage_card_group_item',
                'foreign_table_where' => 'AND tx_bulmapackage_card_group_item.pid=###CURRENT_PID### AND tx_bulmapackage_card_group_item.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'header' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:card_group_item.header',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'subheader' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:card_group_item.subheader',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:card_group_item.media',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'frontend.ttc:asset_references.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        FileType::UNKNOWN->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::TEXT->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        // imageoverlayPalette without link
                        FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::AUDIO->value => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::VIDEO->value => [
                            'showitem' => '
                                --palette--;;videoOverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        FileType::APPLICATION->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                    ],
                ],
                'maxitems' => 1,
                'allowed' => ['gif', 'jpg', 'jpeg', 'bmp', 'png', 'pdf', 'svg', 'youtube', 'vimeo'],
            ],
        ],
        'link' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:card_group_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => [
                    'browserTitle' => 'bulma_package.backend:card_group_item.link',
                ],
            ],
        ],
    ],
];
