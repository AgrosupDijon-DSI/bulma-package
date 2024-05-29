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
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate the RTE basic text styles (bold, italic, underline, strikethrough)
 * From eg <span class="has-text-weight-bold">Text</span> to <strong>Text</strong>
 */
#[UpgradeWizard('rteBasicTextStyleToTagUpdate')]
class RteBasicTextStyleToTagUpdate implements UpgradeWizardInterface, RepeatableInterface
{
    /**
     * @var array
     */
    private $classes = [
        'span' => [
            'has-text-weight-bold' => 'strong',
            'text-underline' => 'u',
            'is-italic' => 'i',
            'text-striked' => 's',
        ]
    ];

    /**
     * @return string Title of this updater
     */
    public function getTitle(): string
    {
        return 'Migrate RTE basic text styles from classes to tags';
    }

    /**
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrate the RTE basic text styles (bold, italic, underline, strikethrough) From eg <span class="has-text-weight-bold">Text</span> to <strong>Text</strong>';
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
                foreach ($replacements as $classBefore => $tagAfter) {
                    $crawler
                        ->filter("{$tag}.{$classBefore}")
                        ->each(function (Crawler $node) use ($classBefore, $tagAfter, &$needUpdate) {
                            /** @var \DOMElement $domElement */
                            $domElement = $node->getNode(0);

                            // Create new DOM element with new tag
                            $newNode = $domElement->ownerDocument->createElement($tagAfter);

                            // Build childNodes array upfront
                            $childNodes = [];
                            foreach ($domElement->childNodes as $childNode) {
                                $childNodes[] = $childNode;
                            }

                            // Inject all child nodes into the new DOM element
                            foreach ($childNodes as $childNode) {
                                $newChildNode = $domElement->ownerDocument->importNode($childNode, true);
                                $newNode->appendChild($newChildNode);
                            }

                            // Replace old DOM element $domElement with the new one $newNode
                            $domElement->parentNode->replaceChild($newNode, $domElement);
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
