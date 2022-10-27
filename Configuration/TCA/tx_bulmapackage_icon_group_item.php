<?php

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
        'cruser_id' => 'cruser_id',
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
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
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
                        '',
                        0
                    ]
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
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.link',
                        ],
                    ],
                ],
                'softref' => 'typolink'
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
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', ''],
                    ['Ionicons', 'EXT:bulma_package/Resources/Public/Icons/Ionicons/'],
                    ['Font Awesome Regular', 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/regular/'],
                    ['Font Awesome Solid', 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/'],
                    ['Font Awesome Brands', 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/'],
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
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', 0, 'EXT:bulma_package/Resources/Public/Icons/none.jpg'],
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
                    'minitems' => 1,
                    'maxitems' => 1,
                ],
                'gif,png,svg'
            ),
            'l10n_mode' => 'exclude',
        ],
        'icon_size' => [
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:icon_group_item.icon_size',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', ''],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.medium', 'is-medium'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.large', 'is-large'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.xl', 'is-xl'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.xxl', 'is-xxl'],
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
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.none', 0],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.primary', 'has-text-primary'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.success', 'has-text-success'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.info', 'has-text-info'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.warning', 'has-text-warning'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.danger', 'has-text-danger'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.light', 'has-text-light'],
                    ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.dark', 'has-text-dark']
                ],
            ],
        ]
    ],
];
