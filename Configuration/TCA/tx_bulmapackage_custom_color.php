<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'bulma_package.backend:tx_bulmapackage_custom_color',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-color',
        ],
        'rootLevel' => 1,
        'security' => [
            'ignoreWebMountRestriction' => true,
            'ignoreRootLevelRestriction' => true,
        ],
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
            ',
        ],
    ],
    'columns' => [
        't3ver_label' => [
            'label' => 'core.general:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'searchable' => false,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'core.general:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'label' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.label',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
            ],
        ],
        'var_primary' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_primary',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_link' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_link',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_success' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_success',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_info' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_info',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_warning' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_warning',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_danger' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_danger',
            'config' => [
                'type' => 'color',
                'size' => 10,
                'searchable' => false,
            ],
        ],
        'var_text_dark' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_custom_color.var_text_dark',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
    ],
];
