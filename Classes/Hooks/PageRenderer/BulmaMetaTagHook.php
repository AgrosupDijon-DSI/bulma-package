<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\PageRenderer;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BulmaMetaTagHook
 */
class BulmaMetaTagHook
{
    /**
     * @throws Exception
     */
    public function execute(): void
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend() === false) {
            return;
        }

        $metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_meta_tags');
        $result = $queryBuilder->select('*')
            ->from('tx_bulmapackage_meta_tags')
            ->executeQuery();

        foreach ($result->fetchAllAssociative() as $meta) {
            $manager = $metaTagManagerRegistry->getManagerForProperty($meta['name']);
            $manager->addProperty($meta['name'], $meta['content']);
        }
    }
}
