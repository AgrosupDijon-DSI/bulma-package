<?php

use TYPO3\CMS\Core\Resource\File;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
return [
    'ctrl' => [
        'label' => 'header',
        'label_alt' => 'subheader,bodytext',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item',
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
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-card-group-item',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,--palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.header;header,media,bodytext,--palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.link;link,icon_file,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--palette--;;hiddenLanguagePalette',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => '',
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel
            ',
        ],
        'header' => [
            'showitem' => '
                header,
                --linebreak--,
                subheader,
            ',
        ],
        'link' => [
            'showitem' => '
                link,
                link_title
            ',
        ],
        'general' => [
            'showitem' => '
                tt_content
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item
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
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.tt_content',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.{#CType}="card_group"',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
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
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
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
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
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
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.header',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'subheader' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.subheader',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.media',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        // imageoverlayPalette without link
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette
                            ',
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPaletteWithoutLink,
                                --palette--;;filePalette
                            ',
                        ],
                        File::FILETYPE_APPLICATION => [
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
        'bodytext' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.bodytext',
            'exclude' => true,
            'config' => [
                'type' => 'text',
                'cols' => 80,
                'rows' => 15,
                'softref' => 'typolink_tag,email[subst],url',
                'enableRichtext' => true,
            ],
        ],
        'link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => [
                    'browserTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.link',
                ],
            ],
        ],
        'link_title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:card_group_item.link_title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
    ],
];
