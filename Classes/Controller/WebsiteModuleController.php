<?php
declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Controller;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 */
class WebsiteModuleController extends ActionController
{

    /**
     * @var SiteFinder
     */
    protected $siteFinder;

    /**
     * Default constructor
     */
    public function __construct()
    {
        $this->siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
    }

    /**
     * Display administration interface
     */
    protected function overviewAction(): void
    {
        $allSites = $this->siteFinder->getAllSites();
        $languages = [];
        foreach ($allSites as $identifier => $site) {
            foreach ($site->getAllLanguages() as $language){
                $languages[$language->getLanguageId()] = $language;
            }
        }
        $pages = $this->getAllSitePages($languages);

        $this->getBulmaPackageSettings($pages);

        $returnUrl = rawurlencode(GeneralUtility::getIndpEnv('REQUEST_URI'));

        $extensionConfiguration = GeneralUtility::makeInstance(
            ExtensionConfiguration::class
        );
        $bulmaPackageConfiguration = $extensionConfiguration->get('bulma_package');

        $this->view->assignMultiple([
            'pages' => $pages,
            'languages' => $languages,
            'returnUrl' => $returnUrl,
            'disableCustomColorsAction' => $bulmaPackageConfiguration['disableCustomColorsAction'],
            'disableMetaTagsAction' => $bulmaPackageConfiguration['disableMetaTagsAction']
        ]);
    }

    /**
     * Display tx_bulmapackage_custom_color
     */
    protected function customColorsAction(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_custom_color');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $customColors = $queryBuilder
            ->select('*')
            ->from('tx_bulmapackage_custom_color')
            ->execute()->fetchAll();

        $this->view->assign('customColors', $customColors);
    }

    /**
     * Display tx_bulmapackage_meta_tags
     */
    protected function metaTagsAction(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_meta_tags');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $metaTags = $queryBuilder
            ->select('*')
            ->from('tx_bulmapackage_meta_tags')
            ->execute()->fetchAllAssociative();

        $this->view->assign('metaTags', $metaTags);
    }


    /**
     * Returns a list of tx_bulmapackage_settings entries
     */
    protected function getBulmaPackageSettings(&$pages): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_settings');
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(BackendWorkspaceRestriction::class, 0, false));
        $statement = $queryBuilder
            ->select('uid', 'pid', 'sys_language_uid')
            ->from('tx_bulmapackage_settings')
            ->execute();

        while($row = $statement->fetch()){
            $pages[$row['pid']]['bulmaSettings'][$row['sys_language_uid']] = $row;
        }
    }

    /**
     * Returns a list of pages that have 'is_siteroot' set, or 'module' LIKE "tx_bulmapackage_settings"
     *
     * @param array $languages
     * @return array
     */
    protected function getAllSitePages(array $languages): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(BackendWorkspaceRestriction::class, 0, false));
        $statement = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('is_siteroot', 1)
            )
            ->orWhere(
                $queryBuilder->expr()->eq('module', $queryBuilder->createNamedParameter('tx_bulmapackage_settings', \PDO::PARAM_STR))
            )
            ->orderBy('pid')
            ->addOrderBy('sorting')
            ->execute();

        $pages = [];
        while ($row = $statement->fetch()) {
            $row['rootline'] = BackendUtility::BEgetRootLine((int)$row['uid']);
            array_pop($row['rootline']);
            $row['rootline'] = array_reverse($row['rootline']);
            $i = 0;
            foreach ($row['rootline'] as &$record) {
                $record['margin'] = $i++ * 20;
            }
            if($row['sys_language_uid'] == 0){
                $row['bulmaSettings'][0] = false;
                $pages[(int)$row['uid']] = $row;
            } elseif(isset($languages[$row['sys_language_uid']])){
                $pages[(int)$row['l10n_parent']]['bulmaSettings'][$row['sys_language_uid']] = false;
            }
        }

        return $pages;
    }

}
