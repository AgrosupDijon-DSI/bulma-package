<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\PageRenderer;

use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BulmaMetaTagHook
 */
class BulmaMetaTagHook
{

    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        if (TYPO3_MODE !== 'FE') {
            return;
        }

        $metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_meta_tags');
        $metaTags = $queryBuilder->select('*')
            ->from('tx_bulmapackage_meta_tags')
            ->execute()
            ->fetchAllAssociative();

        foreach ($metaTags as $meta){
            $manager = $metaTagManagerRegistry->getManagerForProperty($meta['name']);
            $manager->addProperty($meta['name'], $meta['content']);
        }
    }
}
