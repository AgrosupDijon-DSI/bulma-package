<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Updates;

use Doctrine\DBAL\Exception;
use Symfony\Component\DomCrawler\Crawler;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate the RTE classes from Bootstrap to Bulma
 */
class BootstrapToBulmaRteUpdate implements UpgradeWizardInterface, RepeatableInterface
{
    /**
     * @var array
     */
    private $classes = [
        'p' => [
            'lead' => 'box',
            'alert-primary' => 'is-primary',
            'alert-success' => 'is-success',
            'alert-info' => 'is-info',
            'alert-warning' => 'is-warning',
            'alert-danger' => 'is-danger',
            'alert' => 'notification',
        ],
        'a' => [
            'btn-default' => '',
            'btn-primary' => 'is-primary',
            'btn-success' => 'is-success',
            'btn-info' => 'is-info',
            'btn-warning' => 'is-warning',
            'btn-danger' => 'is-danger',
            'btn' => 'button',
        ],
        'span' => [
            'text-primary' => 'has-text-primary',
            'text-success' => 'has-text-success',
            'text-info' => 'has-text-info',
            'text-warning' => 'has-text-warning',
            'text-danger' => 'has-text-danger',
        ],
        '*' => [
            'text-center' => 'has-text-centered',
            'text-right' => 'has-text-right',
        ]
    ];

    /**
     * @return string Unique identifier of this updater
     */
    public function getIdentifier(): string
    {
        return 'bootstrapToBulmaRteUpdate';
    }

    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate RTE classes from Bootstrap to Bulma';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrate css classes used in RTE from Bootstrap to Bulma. Eg: "btn btn-primary" becomes "button is-primary"';
    }

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('uid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('deleted', '0')
            )
            ->executeQuery();

        foreach ($result->fetchAllAssociative() as $item) {
            $crawler = new Crawler($item['bodytext']);

            foreach ($this->classes as $tag => $replacements) {
                foreach ($replacements as $classBefore => $classAfter) {
                    if ($crawler->filter("{$tag}.{$classBefore}")->count() > 0) {
                        return true;
                    }
                }
            }
        }

        return false;
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
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('uid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('deleted', '0')
            )
            ->executeQuery();

        foreach ($result->fetchAllAssociative() as $item) {
            $crawler = new Crawler($item['bodytext']);
            $needUpdate = false;
            foreach ($this->classes as $tag => $replacements) {
                foreach ($replacements as $classBefore => $classAfter) {
                    $crawler
                        ->filter("{$tag}.{$classBefore}")
                        ->each(function (Crawler $node) use ($classBefore, $classAfter, &$needUpdate) {
                            /** @var \DOMElement $domElement */
                            $domElement = $node->getNode(0);
                            $domElement->setAttribute(
                                'class',
                                str_replace(
                                    $classBefore,
                                    $classAfter,
                                    (string)$node->attr('class')
                                )
                            );
                            $needUpdate = true;
                        });
                }
            }
            if ($needUpdate === true) {
                $queryBuilder->update('tt_content')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $item['uid'])
                    )
                    ->set('bodytext', $crawler->filter('body')->html())
                    ->executeStatement();
            }
        }

        return true;
    }

}
