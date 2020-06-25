<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Utility;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * PageLayoutUtility
 */
class PageLayoutUtility
{
    /**
     * @param array $parameters
     */
    public function addLayoutItems(array $parameters)
    {
        $resultRows = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_bulmapackage_custom_color')
            ->select(
                ['uid', 'label'],
                'tx_bulmapackage_custom_color'
            )
            ->fetchAll();

        if (!empty($resultRows)) {
            $parameters['items'][] = ['LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_custom_color.layout_category', '--div--'];
        }

        foreach ($resultRows as $row) {
            // Multiply uid by 100 to differenciate from "normal" items
            $parameters['items'][] = [$row['label'], $row['uid'] * 100];
        }
    }

}
