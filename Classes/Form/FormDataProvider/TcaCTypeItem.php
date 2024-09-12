<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

class TcaCTypeItem implements FormDataProviderInterface
{
    /**
     * @var array
     */
    protected $supportedInlineParentFields = [
        'tx_bulmapackage_tab_item_parent' => [
            0 => 'header',
            1 => 'text',
            2 => 'textmedia',
            3 => 'image',
            4 => 'shortcut',
            5 => 'html',
            6 => 'video',
            7 => 'menu_card_dir',
            8 => 'menu_card_list',
            9 => 'menu_categorized_pages',
            10 => 'menu_pages',
            11 => 'menu_recently_updated',
            12 => 'menu_section',
            13 => 'menu_section_pages',
            14 => 'menu_sitemap_pages',
            15 => 'menu_subpages',
            16 => 'menu_thumbnail_dir',
            17 => 'menu_thumbnail_list',
            18 => 'iframe',
            19 => 'uploads',
        ],
        'tx_bulmapackage_accordion_item_parent' => [
            0 => 'header',
            1 => 'text',
            2 => 'textmedia',
            3 => 'image',
            4 => 'shortcut',
            5 => 'html',
            6 => 'menu_card_dir',
            7 => 'menu_card_list',
            8 => 'menu_categorized_pages',
            9 => 'menu_pages',
            10 => 'menu_recently_updated',
            11 => 'menu_section',
            12 => 'menu_section_pages',
            13 => 'menu_sitemap_pages',
            14 => 'menu_subpages',
            15 => 'menu_thumbnail_dir',
            16 => 'menu_thumbnail_list',
            17 => 'video',
            18 => 'iframe',
            18 => 'uploads',
        ],
    ];

    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if ('tt_content' !== $result['tableName']
            || empty($result['databaseRow']['colPos'][0])
            || 999 !== (int)$result['databaseRow']['colPos'][0]
        ) {
            return $result;
        }

        if (!empty($result['inlineParentUid'])
            && in_array($result['inlineParentConfig']['foreign_field'], array_keys($this->supportedInlineParentFields), true)
        ) {
            $cTypes = $this->supportedInlineParentFields[$result['inlineParentConfig']['foreign_field']];
        } else {
            $parentField = array_filter(array_intersect_key($result['databaseRow'], $this->supportedInlineParentFields));
            if (empty($parentField)) {
                return $result;
            }

            if (count($parentField) === 1) {
                $cTypes = $this->supportedInlineParentFields[key($parentField)];
            } else {
                $cTypes = $result['databaseRow']['CType'];
            }
        }

        $result['processedTca']['columns']['CType']['config']['items'] = array_filter(
            $result['processedTca']['columns']['CType']['config']['items'],
            function ($item) use ($cTypes) {
                return in_array($item['value'], $cTypes);
            }
        );

        return $result;
    }
}
