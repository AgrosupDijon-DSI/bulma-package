<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate the field 'image' for all cards elements to 'media'
 */
class CardImageToMediaUpdate implements UpgradeWizardInterface
{
    /**
     * @return string Unique identifier of this updater
     */
    public function getIdentifier(): string
    {
        return 'cardImageToMediaUpdate';
    }

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
     */
    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_bulmapackage_card_group_item');
        $tableColumns = $connection->getSchemaManager()->listTableColumns('tx_bulmapackage_card_group_item');
        // Only proceed if section_frame field still exists
        if (!isset($tableColumns['image'])) {
            return false;
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_card_group_item');
        $queryBuilder->getRestrictions()->removeAll();
        $elementCount = $queryBuilder->count('uid')
            ->from('tx_bulmapackage_card_group_item')
            ->where(
                $queryBuilder->expr()->gt('image', 0)
            )
            ->execute()
            ->fetchColumn(0);
        return (bool)$elementCount;
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
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_bulmapackage_card_group_item');
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $statement = $queryBuilder->select('uid', 'image')
            ->from('tx_bulmapackage_card_group_item')
            ->where(
                $queryBuilder->expr()->gt('image', 0)
            )
            ->execute();
        while ($record = $statement->fetch()) {
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('tx_bulmapackage_card_group_item')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('image', 0, false)
                ->set('media', $record['image']);
            $queryBuilder->execute();

            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('sys_file_reference')
                ->where(
                    $queryBuilder->expr()->like(
                        'tablenames',
                        $queryBuilder->createNamedParameter('tx_bulmapackage_card_group_item', \PDO::PARAM_STR)
                    )
                )
                ->andWhere(
                    $queryBuilder->expr()->like(
                        'fieldname',
                        $queryBuilder->createNamedParameter('image', \PDO::PARAM_STR)
                    )
                )
                ->andWhere(
                    $queryBuilder->expr()->eq(
                        'uid_foreign',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('fieldname', 'media', true);
            $queryBuilder->execute();
        }
        return true;
    }
}
