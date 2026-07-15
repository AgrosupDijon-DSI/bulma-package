<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addRecordType(
    [
        'label' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.site_update.label',
        'description' => 'LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:content_element.site_update.description',
        'value' => 'site_update',
        'icon' => 'actions-calendar',
        'group' => 'plugins',
    ],
    '
        --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --palette--;LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:palette.siteupdatelayout;siteupdatelayout,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories
    ',
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'siteupdatelayout',
    'table_header_position'
);
