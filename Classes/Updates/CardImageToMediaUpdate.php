<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate the field 'image' for all cards elements to 'media'
 */
#[UpgradeWizard('cardImageToMediaUpdate')]
class CardImageToMediaUpdate implements UpgradeWizardInterface
{
    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate the field "image" for all cards elements to "media"';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Rename image field to media as we are now allowing to use images & videos';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_bulmapackage_card_group_item');
        $tableColumns = $connection->createSchemaManager()->listTableColumns('tx_bulmapackage_card_group_item');
        // Only proceed if image field still exists
        if (!isset($tableColumns['image'])) {
            return false;
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_card_group_item');
        $queryBuilder->getRestrictions()->removeAll();
        $result = $queryBuilder->count('uid')
            ->from('tx_bulmapackage_card_group_item')
            ->where(
                $queryBuilder->expr()->gt('image', 0)
            )
            ->executeQuery();
        return (bool)$result->fetchOne();
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
     * @throws Exception
     */
    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_bulmapackage_card_group_item');
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $statement = $queryBuilder->select('uid', 'image')
            ->from('tx_bulmapackage_card_group_item')
            ->where(
                $queryBuilder->expr()->gt('image', 0)
            )
            ->executeQuery();
        while ($record = $statement->fetchAssociative()) {
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('tx_bulmapackage_card_group_item')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], Connection::PARAM_INT)
                    )
                )
                ->set('image', 0, false)
                ->set('media', $record['image']);
            $queryBuilder->executeStatement();

            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('sys_file_reference')
                ->where(
                    $queryBuilder->expr()->like(
                        'tablenames',
                        $queryBuilder->createNamedParameter('tx_bulmapackage_card_group_item')
                    )
                )
                ->andWhere(
                    $queryBuilder->expr()->like(
                        'fieldname',
                        $queryBuilder->createNamedParameter('image')
                    )
                )
                ->andWhere(
                    $queryBuilder->expr()->eq(
                        'uid_foreign',
                        $queryBuilder->createNamedParameter($record['uid'], Connection::PARAM_INT)
                    )
                )
                ->set('fieldname', 'media', true);
            $queryBuilder->executeStatement();
        }
        return true;
    }
}
