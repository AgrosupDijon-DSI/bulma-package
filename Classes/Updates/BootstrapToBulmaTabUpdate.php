<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use Doctrine\DBAL\ForwardCompatibility\Result;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate Accordions Content Element from Bootstrap to Bulma
 */
class BootstrapToBulmaTabUpdate implements UpgradeWizardInterface, RepeatableInterface
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
        return 'BootstrapToBulmaTabUpdate';
    }

    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate Tabs Content Element from Bootstrap to Bulma';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrate tabs items';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

        /** @var Result $result */
        $result = $queryBuilder->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter("tab", Connection::PARAM_STR))
            )
            ->andWhere(
                $queryBuilder->expr()->gt('tx_bootstrappackage_tab_item', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('tx_bulmapackage_tab_item', 0)
            )
            ->execute();

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
     */
    public function executeUpdate(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

        /** @var Result $result */
        $result = $queryBuilder->select('uid', 'tx_bootstrappackage_tab_item')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter("tab", Connection::PARAM_STR))
            )
            ->andWhere(
                $queryBuilder->expr()->gt('tx_bootstrappackage_tab_item', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('tx_bulmapackage_tab_item', 0)
            )
            ->execute();

        foreach ($result->fetchAllAssociative() as $tabContent){
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bootstrappackage_tab_item');
            /** @var Result $result */
            $result = $queryBuilder->select('*')
                ->from('tx_bootstrappackage_tab_item')
                ->where(
                    $queryBuilder->expr()->eq('tt_content', $tabContent['uid'])
                )
                ->execute();

            foreach ($result->fetchAllAssociative() as $bootstrapTabItem){
                $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
                $connection = $connectionPool->getConnectionForTable('tx_bulmapackage_tab_item');
                $connection->insert(
                    'tx_bulmapackage_tab_item',
                    [
                        'pid' => $bootstrapTabItem['pid'],
                        'title' => $bootstrapTabItem['header'],
                        'sorting' => $bootstrapTabItem['sorting'],
                        'tt_content' => $bootstrapTabItem['tt_content'],
                        'record' => 1
                    ]
                );
                $uidBulmaTabItemUid = (int)$connection->lastInsertId('tx_bulmapackage_tab_item');

                $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
                $connection = $connectionPool->getConnectionForTable('tt_content');
                $connection->insert(
                    'tt_content',
                    [
                        'pid' => $bootstrapTabItem['pid'],
                        'colpos' => 999,
                        'bodytext' => $bootstrapTabItem['bodytext'],
                        'CType' => $bootstrapTabItem['media'] ? 'textmedia' : 'text',
                        'media' => $bootstrapTabItem['media'],
                        'imageorient' => $this->imageOrient[$bootstrapTabItem['mediaorient']],
                        'imagecols' => $bootstrapTabItem['imagecols'],
                        'image_zoom' => $bootstrapTabItem['image_zoom'],
                        'tx_bulmapackage_tab_item_parent' => $uidBulmaTabItemUid
                    ]
                );
            }

            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $connection = $connectionPool->getConnectionForTable('tt_content');
            $connection->update(
                'tt_content',
                ['tx_bulmapackage_tab_item' => $tabContent['tx_bootstrappackage_tab_item']],
                ['uid' => (int)$tabContent['uid']],
                [Connection::PARAM_INT]
            );
        }

        return true;
    }

}
