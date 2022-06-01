<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Create search page and indexed_search plugin
 */
class BackgroundFrameUpdate implements UpgradeWizardInterface, ChattyInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @return string Unique identifier of this updater
     */
    public function getIdentifier(): string
    {
        return 'backgroundFrameUpdate';
    }

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
     * @throws \Doctrine\DBAL\Driver\Exception
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
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function executeUpdate(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter("", Connection::PARAM_STR))
            )
            ->andWhere(
                $queryBuilder->expr()->neq('background_color_class',
                    $queryBuilder->createNamedParameter("none", Connection::PARAM_STR))
            )
            ->set('background_frame', 'expanded')
            ->execute();

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter("", Connection::PARAM_STR))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('background_color_class',
                    $queryBuilder->createNamedParameter("none", Connection::PARAM_STR))
            )
            ->set('background_frame', 'limited')
            ->execute();

        return true;
    }

    /**
     * @return array|\mixed[][]
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    private function getContentsWithEmptyBackgroundFrame()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        return $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('background_frame',
                    $queryBuilder->createNamedParameter("", Connection::PARAM_STR))
            )
            ->execute()
            ->fetchAllAssociative();
    }

    /**
     * Setter injection for output into upgrade wizards
     *
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}
