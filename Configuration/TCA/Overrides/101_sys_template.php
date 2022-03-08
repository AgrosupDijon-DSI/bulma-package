<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

/***************
 * TypoScript: Full Package
 * This includes the full setup including all configurations
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript',
    'Bulma Package: Full Package'
);

/***************
 * TypoScript: Website Module Override
 * This allow to override the Website Module View
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript/WebsiteModule',
    'Bulma Package: Override Website Module View'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript/Extension/News',
    'Bulma Package: News Styles Bulma'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bulma_package',
    'Configuration/TypoScript/Extension/News/Rss',
    'Bulma Package: Rss for News'
);