<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addRecordType(
    [
        'label' => 'bulma_package.backend:content_element.site_update.label',
        'description' => 'bulma_package.backend:content_element.site_update.description',
        'value' => 'site_update',
        'icon' => 'actions-calendar',
        'group' => 'plugins',
    ],
    '
        --palette--;;headers,
        --palette--;bulma_package.backend:palette.siteupdatelayout;siteupdatelayout,
        --div--;frontend.ttc:tabs.appearance,
            --palette--;frontend.ttc:palette.frames;frames,
            --palette--;frontend.ttc:palette.appearanceLinks;appearanceLinks,
        --div--;core.form.tabs:categories,
            categories
    ',
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'siteupdatelayout',
    'message_class, table_header_position'
);
