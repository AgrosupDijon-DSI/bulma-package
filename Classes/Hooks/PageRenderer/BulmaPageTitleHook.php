<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\PageRenderer;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ApplicationType;
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
     * @param array $params
     * @return void
     * @throws Exception
     */
    public function execute(array &$params): void
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend() === false) {
            return;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_settings');

        $bulmaSettingsTitleSeo = '';
        $settingsPid = 0;

        foreach ($GLOBALS['TSFE']->rootLine as $page) {

            $result = $queryBuilder
                ->select('title_seo')
                ->from('tx_bulmapackage_settings')
                ->where(
                    $queryBuilder->expr()->in('pid', $page['uid'])
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $GLOBALS['TSFE']->page['sys_language_uid'])
                )
                ->executeQuery();

            $bulmaSettingsTitleSeo = $result->fetchOne();
            if (!empty($bulmaSettingsTitleSeo)) {
                $settingsPid = $page['uid'];
                break;
            }
        }

        if (!empty($bulmaSettingsTitleSeo)) {
            // see generatePageTitle() & printTitle() in TYPO3\CMS\Frontend\Controller\TyposcriptFrontendController
            if (isset($GLOBALS['TSFE']->config['config']['pageTitleSeparator']) && $GLOBALS['TSFE']->config['config']['pageTitleSeparator'] !== '') {
                $pageTitleSeparator = $GLOBALS['TSFE']->config['config']['pageTitleSeparator'];

                if (isset($GLOBALS['TSFE']->config['config']['pageTitleSeparator.']) && is_array($GLOBALS['TSFE']->config['config']['pageTitleSeparator.'])) {
                    /** @var object $GLOBALS['TSFE'] */
                    $pageTitleSeparator = $GLOBALS['TSFE']->cObj->stdWrap($pageTitleSeparator,
                        $GLOBALS['TSFE']->config['config']['pageTitleSeparator.']);
                } else {
                    $pageTitleSeparator .= ' ';
                }
            } else {
                $pageTitleSeparator = ': ';
            }

            // If pageTitleFirst is false, or if we are on a page where a tx_bulmapackage_settings record exists,
            // current page is considered as homepage, and $bulmaSettingsTitleSeo comes first for SEO considerations
            if ((bool)($GLOBALS['TSFE']->config['config']['pageTitleFirst'] ?? false) && $settingsPid !== $GLOBALS['TSFE']->id) {
                $params['title'] = $params['title'] . $pageTitleSeparator . $bulmaSettingsTitleSeo;
            } else {
                $params['title'] = $bulmaSettingsTitleSeo . $pageTitleSeparator . $params['title'];
            }
        }
    }
}
