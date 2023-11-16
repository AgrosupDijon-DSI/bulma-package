<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;

/**
 * Create search page and indexed_search plugin
 */
#[UpgradeWizard('accordionAndTabsUpdate')]
class AccordionAndTabsUpdate implements UpgradeWizardInterface
{
    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate Accordion and Tabs nested content elements';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Add "record" in "tx_mask_content_role" field to properly display contents inside accordion / tabs.';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        return !empty($this->getContentsWithEmptyContentRole());
    }

    /**
     * @return string[] All new fields and tables must exist
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('tx_mask_content_role',
                    $queryBuilder->createNamedParameter(""))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('colPos',
                    $queryBuilder->createNamedParameter(999))
            )
            ->andWhere(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->neq('tx_bulmapackage_tab_item_parent',
                        $queryBuilder->createNamedParameter(0)),
                    $queryBuilder->expr()->neq('tx_bulmapackage_accordion_item_parent',
                        $queryBuilder->createNamedParameter(0))
                )
            )
            ->set('tx_mask_content_role', 'record')
            ->executeStatement();

        return true;
    }

    /**
     * @return array[]
     * @throws Exception
     */
    private function getContentsWithEmptyContentRole(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('tx_mask_content_role',
                    $queryBuilder->createNamedParameter(""))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('colPos',
                    $queryBuilder->createNamedParameter(999))
            )
            ->andWhere(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->neq('tx_bulmapackage_tab_item_parent',
                        $queryBuilder->createNamedParameter(0)),
                    $queryBuilder->expr()->neq('tx_bulmapackage_accordion_item_parent',
                        $queryBuilder->createNamedParameter(0))
                )
            )
            ->executeQuery();

        return $result->fetchAllAssociative();
    }
}
