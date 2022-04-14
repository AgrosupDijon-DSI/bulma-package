<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

// Adds new "module" type
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:bulma-website',
    1 => 'tx_bulmapackage_settings',
    2 => 'mimetypes-x-content-page-language-overlay'
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-tx_bulmapackage_settings'] = 'mimetypes-x-content-page-language-overlay';

$additionalColumns = [
    'thumbnail' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:pages.thumbnail',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'thumbnail',
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
                'minitems' => 0,
                'maxitems' => 1,
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
        'l10n_mode' => 'exclude',
    ],
    'exclude_slug_for_subpages' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:pages.exclude_slug_for_subpages',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                ]
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ]
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $additionalColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', 'thumbnail', '1,3,4', 'after:backend_layout_next_level');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'title', 'exclude_slug_for_subpages', 'after:slug');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'titleonly', 'exclude_slug_for_subpages', 'after:slug');

// Hook for "exclude_slug_for_subpages"
$GLOBALS['TCA']['pages']['columns']['slug']['config']['generatorOptions']['postModifiers'][] = \AgrosupDijon\BulmaPackage\Hooks\SlugModifier::class . '->modifyGeneratedSlugForPage';

$GLOBALS['TCA']['pages']['columns']['layout']['config']['itemsProcFunc'] = \AgrosupDijon\BulmaPackage\Utility\PageLayoutUtility::class . '->addLayoutItems';
