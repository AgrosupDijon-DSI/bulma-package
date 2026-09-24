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
        'label' => 'bodytext',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'bulma_package.backend:icon_group_item',
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
            'default' => 'content-bulmapackage-icon-group-item',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--div--;bulma_package.backend:palette.icon,--palette--;;icon,--div--;bulma_package.backend:palette.text,bodytext,link,--div--;frontend.ttc:tabs.access,--palette--;frontend.ttc:palette.visibility;visibility,--palette--;frontend.ttc:palette.access;access,--palette--;;hiddenLanguagePalette',
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
        'general' => [
            'showitem' => '
                tt_content
            ',
        ],
        'icon' => [
            'showitem' => '
                icon_set,icon_size, icon_color,--linebreak--,
                icon,--linebreak--,
                icon_file
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;bulma_package.backend:icon_group_item
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
            'label' => 'bulma_package.backend:icon_group_item.tt_content',
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
                'foreign_table' => 'tx_bulmapackage_icon_group_item',
                'foreign_table_where' => 'AND tx_bulmapackage_icon_group_item.pid=###CURRENT_PID### AND tx_bulmapackage_icon_group_item.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'bodytext' => [
            'label' => 'frontend.db.tt_content:bodytext',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'link' => [
            'label' => 'bulma_package.backend:icon_group_item.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => [
                    'browserTitle' => 'bulma_package.backend:icon_group_item.link',
                ],
            ],
            'l10n_mode' => 'exclude',
        ],
        'icon_set' => [
            'label' => 'bulma_package.backend:icon_group_item.icon_set',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.none', 'value' => ''],
                    ['label' => 'Ionicons', 'value' => 'EXT:bulma_package/Resources/Public/Icons/Ionicons/'],
                    ['label' => 'Font Awesome Regular', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/regular/'],
                    ['label' => 'Font Awesome Solid', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/solid/'],
                    ['label' => 'Font Awesome Brands', 'value' => 'EXT:bulma_package/Resources/Public/Icons/FontAwesome/brands/'],
                ],
            ],
        ],
        'icon' => [
            'label' => 'bulma_package.backend:icon_group_item.icon',
            'displayCond' => 'FIELD:icon_set:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.none', 'value' => 0, 'icon' => 'EXT:bulma_package/Resources/Public/Icons/none.jpg'],
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
            'label' => 'bulma_package.backend:icon_group_item.icon_file',
            'displayCond' => 'FIELD:icon_set:REQ:false',
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
                                --palette--;;basicImageoverlayPalette,
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
                'minitems' => 1,
                'maxitems' => 1,
                'allowed' => ['gif', 'png', 'svg'],
            ],
            'l10n_mode' => 'exclude',
        ],
        'icon_size' => [
            'label' => 'bulma_package.backend:icon_group_item.icon_size',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.default', 'value' => ''],
                    ['label' => 'bulma_package.backend:option.medium', 'value' => 'is-medium'],
                    ['label' => 'bulma_package.backend:option.large', 'value' => 'is-large'],
                    ['label' => 'bulma_package.backend:option.xl', 'value' => 'is-xl'],
                    ['label' => 'bulma_package.backend:option.xxl', 'value' => 'is-xxl'],
                ],
            ],
        ],
        'icon_color' => [
            'label' => 'bulma_package.backend:icon_group_item.icon_color',
            'displayCond' => 'FIELD:icon_set:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'bulma_package.backend:option.none', 'value' => 0],
                    ['label' => 'bulma_package.backend:option.primary', 'value' => 'has-text-primary'],
                    ['label' => 'bulma_package.backend:option.success', 'value' => 'has-text-success'],
                    ['label' => 'bulma_package.backend:option.info', 'value' => 'has-text-info'],
                    ['label' => 'bulma_package.backend:option.warning', 'value' => 'has-text-warning'],
                    ['label' => 'bulma_package.backend:option.danger', 'value' => 'has-text-danger'],
                    ['label' => 'bulma_package.backend:option.light', 'value' => 'has-text-light'],
                    ['label' => 'bulma_package.backend:option.dark', 'value' => 'has-text-dark'],
                ],
            ],
        ],
    ],
];
