<?php
declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Controller;

use Psr\Http\Message\ResponseInterface;
use Doctrine\DBAL\Exception;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 */
class WebsiteModuleController extends ActionController
{
    protected ModuleTemplate $moduleTemplate;

    /**
     * Default constructor
     */
    public function __construct(
        protected readonly SiteFinder $siteFinder,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected UriBuilder $backendUriBuilder,
        protected IconFactory $iconFactory
    ) {
    }

    public function initializeAction(): void
    {
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $this->moduleTemplate->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_mod.xlf:mlang_labels_tablabel'));
    }

    /**
     * Display administration interface
     * @throws Exception
     */
    protected function overviewAction(): ResponseInterface
    {
        $allSites = $this->siteFinder->getAllSites(false);

        $languages = [];
        foreach ($allSites as $identifier => $site) {
            foreach ($site->getAllLanguages() as $language) {
                $languages[$language->getLanguageId()] = $language;
            }
        }
        $pages = $this->getAllSitePages($languages);

        $this->getBulmaPackageSettings($pages);

        $this->moduleTemplate->assignMultiple([
            'pages' => $pages,
            'languages' => $languages
        ]);

        $this->addMainMenu('overview');
        $this->configureCommonDocHeader('overview', $this->getLanguageService()->sL('LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_module.xlf:mlang_labels_tablabel'));


        return $this->moduleTemplate->renderResponse();
    }

    public function addMainMenu(string $currentAction): void
    {
        $this->uriBuilder->setRequest($this->request);
        $menu = $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('BulmaPackageWebsiteModuleMenu');
        $menu->addMenuItem(
            $menu->makeMenuItem()
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:overview.title'))
                ->setHref($this->uriBuilder->uriFor('overview'))
                ->setActive($currentAction === 'overview')
        );

        $extensionConfiguration = GeneralUtility::makeInstance(
            ExtensionConfiguration::class
        );

        try {
            $bulmaPackageConfiguration = $extensionConfiguration->get('bulma_package');
        } catch (\Exception $e) {
            $bulmaPackageConfiguration = [
                'disableCustomColorsAction' => false,
                'disableMetaTagsAction' => false
            ];
        }

        if(!$bulmaPackageConfiguration['disableCustomColorsAction']){
            $menu->addMenuItem(
                $menu->makeMenuItem()
                    ->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:customColors.title'))
                    ->setHref($this->uriBuilder->uriFor('customColors'))
                    ->setActive($currentAction === 'customColors')
            );
        }

        if(!$bulmaPackageConfiguration['disableMetaTagsAction']){
            $menu->addMenuItem(
                $menu->makeMenuItem()
                    ->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:metaTags.title'))
                    ->setHref($this->uriBuilder->uriFor('metaTags'))
                    ->setActive($currentAction === 'metaTags')
            );
        }

        $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
    }

    protected function configureCommonDocHeader(string $currentAction, string $shortcutDisplayName): void
    {
        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $reloadButton = $buttonBar->makeLinkButton()
            ->setHref((string)$this->request->getAttribute('normalizedParams')?->getRequestUri())
            ->setTitle($this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.reload'))
            ->setIcon($this->iconFactory->getIcon('actions-refresh', Icon::SIZE_SMALL));
        $buttonBar->addButton($reloadButton, ButtonBar::BUTTON_POSITION_RIGHT);
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setRouteIdentifier('system_BulmaPackageWebsitesettings')
            ->setArguments(['action' => $currentAction])
            ->setDisplayName($shortcutDisplayName);
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT);
    }

    /**
     * Display tx_bulmapackage_custom_color
     * @throws Exception
     */
    protected function customColorsAction(): ResponseInterface
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_custom_color');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $result = $queryBuilder
            ->select('*')
            ->from('tx_bulmapackage_custom_color')
            ->executeQuery();

        $this->moduleTemplate->assign('customColors', $result->fetchAllAssociative());

        $this->addMainMenu('customColors');
        $this->configureCommonDocHeader('customColors', $this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:customColors.title'));
        $this->configureCustomColorsDocHeader();

        return $this->moduleTemplate->renderResponse();
    }

    protected function configureCustomColorsDocHeader(): void
    {
        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $addCustomColorButton = $buttonBar->makeLinkButton()
            ->setIcon($this->iconFactory->getIcon('actions-plus', Icon::SIZE_SMALL))
            ->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:customColors.color.create'))
            ->setShowLabelText(true)
            ->setHref((string)$this->backendUriBuilder->buildUriFromRoute('record_edit', [
                'edit' => ['tx_bulmapackage_custom_color' => [0 => 'new']],
                'returnUrl' => $this->request->getAttribute('normalizedParams')?->getRequestUri(),
            ]));
        $buttonBar->addButton($addCustomColorButton);
    }

    /**
     * Display tx_bulmapackage_meta_tags
     * @throws Exception
     */
    protected function metaTagsAction(): ResponseInterface
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_meta_tags');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $result = $queryBuilder
            ->select('*')
            ->from('tx_bulmapackage_meta_tags')
            ->executeQuery();

        $this->moduleTemplate->assign('metaTags', $result->fetchAllAssociative());

        $this->addMainMenu('metaTags');
        $this->configureCommonDocHeader('metaTags', $this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:metaTags.title'));
        $this->configureMetaTagsDocHeader();

        return $this->moduleTemplate->renderResponse();
    }

    protected function configureMetaTagsDocHeader(): void
    {
        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $addMetaTagsButton = $buttonBar->makeLinkButton()
            ->setIcon($this->iconFactory->getIcon('actions-plus', Icon::SIZE_SMALL))
            ->setTitle($this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/locallang_websitemodule.xlf:metaTags.meta.create'))
            ->setShowLabelText(true)
            ->setHref((string)$this->backendUriBuilder->buildUriFromRoute('record_edit', [
                'edit' => ['tx_bulmapackage_meta_tags' => [0 => 'new']],
                'returnUrl' => $this->request->getAttribute('normalizedParams')?->getRequestUri(),
            ]));
        $buttonBar->addButton($addMetaTagsButton);
    }

    /**
     * Returns a list of tx_bulmapackage_settings entries
     * @throws Exception
     */
    protected function getBulmaPackageSettings(array &$pages): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_settings');
        $result = $queryBuilder
            ->select('uid', 'pid', 'sys_language_uid')
            ->from('tx_bulmapackage_settings')
            ->executeQuery();

        while ($row = $result->fetchAssociative()) {
            $pages[$row['pid']]['bulmaSettings'][$row['sys_language_uid']] = $row;
        }
    }

    /**
     * Returns a list of pages that have 'is_siteroot' set, or 'module' LIKE "tx_bulmapackage_settings"
     *
     * @param array $languages
     * @return array
     * @throws Exception
     */
    protected function getAllSitePages(array $languages): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(WorkspaceRestriction::class, 0));
        $statement = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('is_siteroot', 1)
            )
            ->orWhere(
                $queryBuilder->expr()->eq('module',
                    $queryBuilder->createNamedParameter('tx_bulmapackage_settings'))
            )
            ->orderBy('pid')
            ->addOrderBy('sorting')
            ->executeQuery();

        $pages = [];
        while ($row = $statement->fetchAssociative()) {
            $row['rootline'] = BackendUtility::BEgetRootLine((int)$row['uid']);
            array_pop($row['rootline']);
            $row['rootline'] = array_reverse($row['rootline']);
            $i = 0;
            foreach ($row['rootline'] as &$record) {
                $record['margin'] = $i++ * 20;
            }
            if ($row['sys_language_uid'] == 0) {
                $row['bulmaSettings'][0] = false;
                $pages[(int)$row['uid']] = $row;
            } elseif (isset($languages[$row['sys_language_uid']])) {
                $pages[(int)$row['l10n_parent']]['bulmaSettings'][$row['sys_language_uid']] = false;
            }
        }

        return $pages;
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

}
