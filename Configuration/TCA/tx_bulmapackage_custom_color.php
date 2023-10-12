<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'label',
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-color',
        ],
        'rootLevel' => 1,
        'security' => [
            'ignoreWebMountRestriction' => true,
            'ignoreRootLevelRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '
                label,
                var_primary,
                var_link,
                var_success,
                var_info,
                var_warning,
                var_danger
            '
        ],
    ],
    'columns' => [
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.label',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255
            ]
        ],
        'var_primary' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_primary',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_link',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_success' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_success',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_info' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_info',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_warning' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_warning',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_danger' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_danger',
            'config' => [
                'type' => 'color',
                'size' => 10,
            ]
        ],
        'var_text_dark' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.var_text_dark',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ]
        ]
    ],
];
