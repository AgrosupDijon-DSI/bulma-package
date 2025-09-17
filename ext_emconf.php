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
            'typo3' => '13.4.0-13.4.99',
            'rte_ckeditor' => '13.4.0-13.4.99',
            'seo' => '13.4.0-13.4.99',
        ],
        'conflicts' => [
            'css_styled_content' => '*',
            'fluid_styled_content' => '*',
            'themes' => '*',
            'fluidpages' => '*',
            'dyncss' => '*',
        ],
        'suggests' => [
            'image_autoresize' => '',
            'news' => '12.0.0-12.99.99',
            'gridelements' => '',
            'container' => '',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'AgrosupDijon\\BulmaPackage\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'author' => 'Sébastien Convers',
    'author_email' => 'sebastien.convers@agrosupdijon.fr',
    'author_company' => 'AgroSup Dijon',
    'version' => '4.1.2',
];
