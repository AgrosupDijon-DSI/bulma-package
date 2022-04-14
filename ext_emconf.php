<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Bulma Package',
    'description' => 'Bulma Package delivers a full configured frontend theme for TYPO3, based on the Bulma CSS Framework.',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'rte_ckeditor' => '11.5.0-11.5.99',
            'seo' => '11.5.0-11.5.99'
        ],
        'conflicts' => [
            'css_styled_content' => '*',
            'fluid_styled_content' => '*',
            'themes' => '*',
            'fluidpages' => '*',
            'dyncss' => '*',
        ],
        'suggests' => [
            'image_autoresize' => '*',
            'news' => '9.0.0-9.99.99'
        ]
    ],
    'autoload' => [
        'psr-4' => [
            'AgrosupDijon\\BulmaPackage\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Sébastien Convers',
    'author_email' => 'sebastien.convers@agrosupdijon.fr',
    'author_company' => 'AgroSup Dijon',
    'version' => '2.0.0',
];
