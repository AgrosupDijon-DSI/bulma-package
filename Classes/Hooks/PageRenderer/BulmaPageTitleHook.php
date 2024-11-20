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
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Page\PageInformation;

/**
 * BulmaPageTitleHook
 *
 * Override the page title by adding value from field tx_bulmapackage_settings:title_seo
 * (Similar behaviour as using websiteTitle in Site Configuration, but we can give permissions to "non admin" users)
 * Can't be done with the PageTitle API, else it will be used in indexed_search
 */
class BulmaPageTitleHook
{
    /**
     * @param array $params
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

        /** @var PageInformation $pageInformation */
        $pageInformation = $this->getRequest()?->getAttribute('frontend.page.information');

        foreach ($pageInformation->getRootLine() as $page) {

            $result = $queryBuilder
                ->select('title_seo')
                ->from('tx_bulmapackage_settings')
                ->where(
                    $queryBuilder->expr()->in('pid', $page['uid'])
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $pageInformation->getPageRecord()['sys_language_uid'])
                )
                ->executeQuery();

            $bulmaSettingsTitleSeo = $result->fetchOne();
            if (!empty($bulmaSettingsTitleSeo)) {
                $settingsPid = $page['uid'];
                break;
            }
        }

        if (!empty($bulmaSettingsTitleSeo)) {
            /** @var FrontendTypoScript $frontendTyposcript */
            $frontendTyposcript = $this->getRequest()?->getAttribute('frontend.typoscript');
            $typoScriptConfigArray = $frontendTyposcript->getConfigArray();

            // see generatePageTitle() & printTitle() in TYPO3\CMS\Frontend\Controller\TyposcriptFrontendController
            if ($typoScriptConfigArray['pageTitleSeparator'] ?? null) {
                $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                $pageTitleSeparator = (string)$cObj->stdWrapValue('pageTitleSeparator', $typoScriptConfigArray);
                if ($pageTitleSeparator !== '' && $pageTitleSeparator === $typoScriptConfigArray['pageTitleSeparator']) {
                    $pageTitleSeparator .= ' ';
                }
            } else {
                $pageTitleSeparator = ': ';
            }

            // If pageTitleFirst is false, or if we are on a page where a tx_bulmapackage_settings record exists,
            // current page is considered as a homepage, so pageTitleFirst is ignored and $bulmaSettingsTitleSeo comes first for SEO considerations
            if (($typoScriptConfigArray['pageTitleFirst'] ?? false) && $settingsPid !== $pageInformation->getId()) {
                $params['title'] = $params['title'] . $pageTitleSeparator . $bulmaSettingsTitleSeo;
            } else {
                $params['title'] = $bulmaSettingsTitleSeo . $pageTitleSeparator . $params['title'];
            }
        }
    }

    private function getRequest(): ServerRequest|null
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
