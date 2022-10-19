<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\PageRenderer;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BulmaPageTitleHook
 *
 * Override the page title by adding value from field tx_bulmapackage_settings:title_seo
 * (Similar behaviour as using websiteTitle in Site Configuration, but we can give permissions to "non admin" users)
 * Can't be done with the PageTitle API, else it will be used in indexed_search
 *
 */
class BulmaPageTitleHook
{

    /**
     * @param $params
     */
    public function execute(&$params)
    {
        if (TYPO3_MODE !== 'FE') {
            return;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_settings');

        foreach ($GLOBALS['TSFE']->rootLine as $page) {

            $bulmaSettings = $queryBuilder
                ->select('title_seo')
                ->from('tx_bulmapackage_settings')
                ->where(
                    $queryBuilder->expr()->in('pid', $page['uid'])
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $GLOBALS['TSFE']->page['sys_language_uid'])
                )
                ->execute()->fetch();

            if (isset($bulmaSettings['title_seo']) && !empty($bulmaSettings['title_seo'])) {

                // see generatePageTitle() & printTitle() in TYPO3\CMS\Frontend\Controller\TyposcriptFrontendController
                if (isset($GLOBALS['TSFE']->config['config']['pageTitleSeparator']) && $GLOBALS['TSFE']->config['config']['pageTitleSeparator'] !== '') {
                    $pageTitleSeparator = $GLOBALS['TSFE']->config['config']['pageTitleSeparator'];

                    if (isset($GLOBALS['TSFE']->config['config']['pageTitleSeparator.']) && is_array($GLOBALS['TSFE']->config['config']['pageTitleSeparator.'])) {
                        $pageTitleSeparator = $GLOBALS['TSFE']->cObj->stdWrap($pageTitleSeparator, $GLOBALS['TSFE']->config['config']['pageTitleSeparator.']);
                    } else {
                        $pageTitleSeparator .= ' ';
                    }
                } else{
                    $pageTitleSeparator = ': ';
                }

                if((bool)($GLOBALS['TSFE']->config['config']['pageTitleFirst'] ?? false)){
                    $params['title'] = $params['title'] . $pageTitleSeparator . $bulmaSettings['title_seo'];
                } else {
                    $params['title'] = $bulmaSettings['title_seo'] . $pageTitleSeparator . $params['title'];
                }

                break;
            }
        }
    }
}
