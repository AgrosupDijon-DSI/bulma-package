<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'bulma_package.backend:tx_bulmapackage_meta_tags',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'content-bulmapackage-meta',
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
                name,
                content
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
        'name' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_meta_tags.name',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'searchable' => false,
            ],
        ],
        'content' => [
            'exclude' => true,
            'label' => 'bulma_package.backend:tx_bulmapackage_meta_tags.content',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'searchable' => false,
            ],
        ],
    ],
];
