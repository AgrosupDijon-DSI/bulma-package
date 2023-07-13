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
#[UpgradeWizard('backgroundFrameUpdate')]
class BackgroundFrameUpdate implements UpgradeWizardInterface
{
    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate Background Frame';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Replace old default value (empty) by "expanded" to keep the same frontend visual, as default value is now "limited"';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        return !empty($this->getContentsWithEmptyBackgroundFrame());
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
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter(""))
            )
            ->andWhere(
                $queryBuilder->expr()->neq('background_color_class',
                    $queryBuilder->createNamedParameter("none"))
            )
            ->set('background_frame', 'expanded')
            ->executeStatement();

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter(""))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('background_color_class',
                    $queryBuilder->createNamedParameter("none"))
            )
            ->set('background_frame', 'limited')
            ->executeStatement();

        return true;
    }

    /**
     * @return array[]
     * @throws Exception
     */
    private function getContentsWithEmptyBackgroundFrame(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter(""))
            )
            ->executeQuery();

        return $result->fetchAllAssociative();
    }
}
