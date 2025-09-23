<?php


use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'media',
    'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_group.media',
    'after:default',
);
