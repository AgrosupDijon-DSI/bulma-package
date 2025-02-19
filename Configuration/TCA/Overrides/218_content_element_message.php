<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

/***************
 * Add Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['message'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['message'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.message',
        'value' => 'message',
        'icon' => 'content-panel',
    ],
    'tab',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['message'] = 'content-message';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['message'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['message'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                header,
                bodytext,
                message_class,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
        'columnsOverrides' => [
            'bodytext' => [
                'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel',
                'config' => [
                    'enableRichtext' => true,
                ],
            ],
        ],
    ]
);

$additionalColumns = [
    'message_class' => [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:field.message_class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.default', 'value' => ''],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.primary', 'value' => 'is-primary'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.success', 'value' => 'is-success'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.info', 'value' => 'is-info'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.warning', 'value' => 'is-warning'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.danger', 'value' => 'is-danger'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.light', 'value' => 'is-light'],
                ['label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:option.dark', 'value' => 'is-dark'],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
