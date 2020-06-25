<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

class TcaColPosItem implements FormDataProviderInterface
{
    /**
     * @var array
     */
    protected $supportedInlineParentFields = [
        0 => 'tx_bulmapackage_tab_item_parent',
        1 => 'tx_bulmapackage_accordion_item_parent',
    ];

    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if ('tt_content' !== $result['tableName']
            || empty($result['databaseRow']['colPos'])
            || 999 !== (int)$result['databaseRow']['colPos']
            || ((empty($result['inlineParentUid'])
                    || !in_array($result['inlineParentConfig']['foreign_field'], $this->supportedInlineParentFields, true))
                && empty(array_filter(array_intersect_key($result['databaseRow'], array_flip($this->supportedInlineParentFields))))
            )
        ) {
            return $result;
        }

        if (!is_array($result['processedTca']['columns']['colPos']['config']['items'])) {
            $result['processedTca']['columns']['colPos']['config']['items'] = [];
        }
        array_unshift(
            $result['processedTca']['columns']['colPos']['config']['items'],
            [
                'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tt_content.colPos.nestedContentColPos',
                $result['databaseRow']['colPos'],
            ]
        );
        unset($result['processedTca']['columns']['colPos']['config']['itemsProcFunc']);

        return $result;
    }
}
