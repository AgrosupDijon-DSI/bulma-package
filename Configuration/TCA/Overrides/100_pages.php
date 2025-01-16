<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use AgrosupDijon\BulmaPackage\Hooks\SlugModifier;
use AgrosupDijon\BulmaPackage\Utility\PageLayoutUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Resource\FileType;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Adds new "module" type
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:bulma-website',
    'value' => 'tx_bulmapackage_settings',
    'icon' => 'mimetypes-x-content-page-language-overlay',
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-tx_bulmapackage_settings'] = 'mimetypes-x-content-page-language-overlay';

$additionalColumns = [
    'thumbnail' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:pages.thumbnail',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'common-image-types',
            'appearance' => [
                'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
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
        ],
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
    ],
    'exclude_slug_for_subpages' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:pages.exclude_slug_for_subpages',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ],
    'hide_breadcrumb' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:pages.hide_breadcrumb',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('pages', $additionalColumns);
ExtensionManagementUtility::addToAllTCAtypes('pages', 'thumbnail', '1,3,4', 'after:backend_layout_next_level');
ExtensionManagementUtility::addToAllTCAtypes('pages', 'hide_breadcrumb', (string)PageRepository::DOKTYPE_DEFAULT, 'after:thumbnail');
ExtensionManagementUtility::addFieldsToPalette('pages', 'title', 'exclude_slug_for_subpages', 'after:slug');
ExtensionManagementUtility::addFieldsToPalette('pages', 'titleonly', 'exclude_slug_for_subpages', 'after:slug');

// Hook for "exclude_slug_for_subpages"
$GLOBALS['TCA']['pages']['columns']['slug']['config']['generatorOptions']['postModifiers'][] = SlugModifier::class . '->modifyGeneratedSlugForPage';

$GLOBALS['TCA']['pages']['columns']['layout']['config']['itemsProcFunc'] = PageLayoutUtility::class . '->addLayoutItems';
