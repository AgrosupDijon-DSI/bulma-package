<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

// Replace textmedia itemgroup from default to media
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType.textmedia',
        'description' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType.textmedia.description',
        'value' => 'textmedia',
        'icon' => 'mimetypes-x-content-text-media',
        'group' => 'media',
    ],
    'textmedia',
    'replace',
);
