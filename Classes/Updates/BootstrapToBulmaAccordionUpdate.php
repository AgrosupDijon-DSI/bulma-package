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
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate Accordions Content Element from Bootstrap to Bulma
 */
class BootstrapToBulmaAccordionUpdate implements UpgradeWizardInterface, RepeatableInterface
{
    /**
     * @var array
     */
    private $imageOrient = [
        'left' => 26,
        'top' => 0,
        'right' => 25,
        'bottom' => 8,
    ];

    /**
     * @return string Unique identifier of this updater
     */
    public function getIdentifier(): string
    {
        return 'BootstrapToBulmaAccordionUpdate';
    }

    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate Accordions Content Element from Bootstrap to Bulma';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrate accordions items';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
        $tableColumns = $connection->createSchemaManager()->listTableColumns('tt_content');
        // Only proceed if tx_bootstrappackage_accordion_item field still exists
        if (!isset($tableColumns['tx_bootstrappackage_accordion_item'])) {
            return false;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $result = $queryBuilder->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter("accordion"))
            )
            ->andWhere(
                $queryBuilder->expr()->gt('tx_bootstrappackage_accordion_item', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('tx_bulmapackage_accordion_item', 0)
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
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $result = $queryBuilder->select('uid', 'tx_bootstrappackage_accordion_item')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter("accordion"))
            )
            ->andWhere(
                $queryBuilder->expr()->gt('tx_bootstrappackage_accordion_item', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('tx_bulmapackage_accordion_item', 0)
            )
            ->executeQuery();

        foreach ($result->fetchAllAssociative() as $accordionContent){
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bootstrappackage_accordion_item');
            $result = $queryBuilder->select('*')
                ->from('tx_bootstrappackage_accordion_item')
                ->where(
                    $queryBuilder->expr()->eq('tt_content', $accordionContent['uid'])
                )
                ->executeQuery();

            foreach ($result->fetchAllAssociative() as $bootstrapAccordionItem){
                $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
                $connection = $connectionPool->getConnectionForTable('tx_bulmapackage_accordion_item');
                $connection->insert(
                    'tx_bulmapackage_accordion_item',
                    [
                        'pid' => $bootstrapAccordionItem['pid'],
                        'title' => $bootstrapAccordionItem['header'],
                        'sorting' => $bootstrapAccordionItem['sorting'],
                        'tt_content' => $bootstrapAccordionItem['tt_content'],
                        'record' => 1
                    ]
                );
                $uidBulmaAccordionItemUid = (int)$connection->lastInsertId('tx_bulmapackage_accordion_item');

                $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
                $connection = $connectionPool->getConnectionForTable('tt_content');
                $connection->insert(
                    'tt_content',
                    [
                        'pid' => $bootstrapAccordionItem['pid'],
                        'colpos' => 999,
                        'bodytext' => $bootstrapAccordionItem['bodytext'],
                        'CType' => $bootstrapAccordionItem['media'] ? 'textmedia' : 'text',
                        'media' => $bootstrapAccordionItem['media'],
                        'imageorient' => $this->imageOrient[$bootstrapAccordionItem['mediaorient']],
                        'imagecols' => $bootstrapAccordionItem['imagecols'],
                        'image_zoom' => $bootstrapAccordionItem['image_zoom'],
                        'tx_bulmapackage_accordion_item_parent' => $uidBulmaAccordionItemUid
                    ]
                );
            }

            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $connection = $connectionPool->getConnectionForTable('tt_content');
            $connection->update(
                'tt_content',
                ['tx_bulmapackage_accordion_item' => $accordionContent['tx_bootstrappackage_accordion_item']],
                ['uid' => (int)$accordionContent['uid']],
                [Connection::PARAM_INT]
            );
        }

        return true;
    }

}
