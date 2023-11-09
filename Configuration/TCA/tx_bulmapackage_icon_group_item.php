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
        'label' => 'bodytext',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item',
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
            'default' => 'content-bulmapackage-icon-group-item'
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.icon,--palette--;;icon,--div--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.text,bodytext,link,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--palette--;;hiddenLanguagePalette'
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => ''
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel
            '
        ],
        'general' => [
            'showitem' => '
                tt_content
            '
        ],
        'icon' => [
            'showitem' => '
                icon_set,icon_size, icon_color,--linebreak--,
                icon,--linebreak--,
                icon_file
            '
        ],
        'visibility' => [
            'showitem' => '
                hidden;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item
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
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.tt_content',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.CType="icon_group"',
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
                'default' => 0
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
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
            'l10n_display' => 'defaultAsReadonly'
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
                'foreign_table' => 'tx_bulmapackage_icon_group_item',
                'foreign_table_where' => 'AND tx_bulmapackage_icon_group_item.pid=###CURRENT_PID### AND tx_bulmapackage_icon_group_item.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'bodytext' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'link' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => [
                    'browserTitle' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.link'
                ],
            ],
            'l10n_mode' => 'exclude',
        ],
        'icon_set' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_set',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', 'value' => ''],
                    ['label' => 'Ionicons', 'value' => 'EXT:bulma_package/Resources/Public/Icons/Ionicons/'],
                    ['label' => 'Font Awesome Regular', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/regular/'],
                    ['label' => 'Font Awesome Solid', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/'],
                    ['label' => 'Font Awesome Brands', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/'],
                ],
            ],
        ],
        'icon' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon',
            'displayCond' => 'FIELD:icon_set:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', 'value' => 0, 'icon' => 'EXT:bulma_package/Resources/Public/Icons/none.jpg'],
                ],
                'itemsProcFunc' => 'AgrosupDijon\BulmaPackage\Utility\TextIconUtility->addIconItems',
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'icon_file' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_file',
            'displayCond' => 'FIELD:icon_set:REQ:false',
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
                                --palette--;;basicImageoverlayPalette,
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
                'allowed' => ['gif','png','svg'],
            ],
            'l10n_mode' => 'exclude',
        ],
        'icon_size' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_size',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'value' => ''],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.medium', 'value' => 'is-medium'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.large', 'value' => 'is-large'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.xl', 'value' => 'is-xl'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.xxl', 'value' => 'is-xxl'],
                ],
            ],
        ],
        'icon_color' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_color',
            'displayCond' => 'FIELD:icon_set:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', 'value' => 0],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.primary', 'value' => 'has-text-primary'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.success', 'value' => 'has-text-success'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.info', 'value' => 'has-text-info'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.warning', 'value' => 'has-text-warning'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.danger', 'value' => 'has-text-danger'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.light', 'value' => 'has-text-light'],
                    ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.dark', 'value' => 'has-text-dark']
                ],
            ],
        ]
    ],
];
