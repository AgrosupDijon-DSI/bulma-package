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
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate the list_type 'media' to 'video'
 */
#[UpgradeWizard('mediaToVideoContentElementUpdate')]
class MediaToVideoContentElementUpdate implements UpgradeWizardInterface
{
    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Change content element "Media" to "Video"';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrate the bootstrap_package "Media" content element to bulma_package "Video"';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        return !empty($this->getMediaContentElement());
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
     * Performs the database update
     *
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType',
                    $queryBuilder->createNamedParameter("media"))
            )
            ->set('CType', 'video')
            ->executeStatement();

        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getMediaContentElement()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType',
                    $queryBuilder->createNamedParameter("media"))
            )
            ->executeQuery();

        return $result->fetchAllAssociative();
    }
}
