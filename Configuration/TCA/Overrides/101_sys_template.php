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
 * TypoScript: Full Package
 * This includes the full setup including all configurations
 */
ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript',
    'Bulma Package: Full Package'
);

ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript/Extension/News',
    'Bulma Package: News Styles Bulma'
);

ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript/Extension/News/Rss',
    'Bulma Package: Rss for News'
);
