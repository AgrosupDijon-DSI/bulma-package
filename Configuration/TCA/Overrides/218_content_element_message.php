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
        'label' => 'bulma_package.backend:content_element.message',
        'value' => 'message',
        'icon' => 'content-panel',
        'group' => 'special',
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
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                header,
                bodytext,
                message_class,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;frontend.ttc:palette.appearanceLinks;appearanceLinks,
            --div--;core.form.tabs:language,
                --palette--;;language,
            --div--;core.form.tabs:access,
                --palette--;;hidden,
                --palette--;frontend.ttc:palette.access;access,
            --div--;core.form.tabs:categories,
                categories,
            --div--;core.form.tabs:notes,
                rowDescription,
            --div--;core.form.tabs:extended,
        ',
        'columnsOverrides' => [
            'bodytext' => [
                'label' => 'frontend.ttc:bodytext_formlabel',
                'config' => [
                    'enableRichtext' => true,
                ],
            ],
        ],
    ]
);

$additionalColumns = [
    'message_class' => [
        'label' => 'bulma_package.backend:field.message_class',
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
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);
