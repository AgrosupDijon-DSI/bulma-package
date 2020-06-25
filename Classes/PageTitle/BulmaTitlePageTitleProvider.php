<?php
declare(strict_types = 1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\PageTitle;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BulmaTitlePageTitleProvider extends AbstractPageTitleProvider
{

    private $titles = [
        'seo_title',
        'title'
    ];

    public function __construct()
    {
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

                $pageTitle = '';
                foreach ($this->titles as $title){
                    if(isset($GLOBALS['TSFE']->page[$title]) && !empty($GLOBALS['TSFE']->page[$title])){
                        $pageTitle = $GLOBALS['TSFE']->page[$title];
                        break;
                    }
                }

                if((bool)($GLOBALS['TSFE']->config['config']['pageTitleFirst'] ?? false)){
                    $this->title = $pageTitle . $pageTitleSeparator . $bulmaSettings['title_seo'];
                } else {
                    $this->title = $bulmaSettings['title_seo'] . $pageTitleSeparator . $pageTitle;
                }

                break;
            }
        }
    }
}
