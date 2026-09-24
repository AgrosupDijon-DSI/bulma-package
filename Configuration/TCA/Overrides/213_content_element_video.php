<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

/***************
 * Add Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['video'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['video'] = [];
}

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'bulma_package.backend:content_element.video',
        'value' => 'video',
        'icon' => 'mimetypes-x-content-multimedia',
        'group' => 'media',
    ],
    'textmedia',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['video'] = 'mimetypes-x-content-multimedia';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['video'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['video'],
    [
        'showitem' => '
            --div--;core.form.tabs:general,
                --palette--;frontend.ttc:palette.general;general,
                --palette--;frontend.ttc:palette.headers;headers,
            --div--;frontend.ttc:tabs.media,
                assets,
                file_folder,
                filelink_sorting,
                --palette--;frontend.database:tt_content.palette.mediaAdjustments;mediaAdjustments,
                --palette--;frontend.database:tt_content.palette.gallerySettings;gallerySettings,
                --palette--;frontend.ttc:palette.imagelinks;imagelinks,
            --div--;frontend.ttc:tabs.appearance,
                --palette--;frontend.ttc:palette.frames;frames,
                --palette--;frontend.ttc:palette.appearanceLinks;appearanceLinks,
            --div--;core.form.tabs:language,
                --palette--;;language,
            --div--;core.form.tabs:access,
                --palette--;;hidden,
                --palette--;frontend.ttc:palette.access;access,
            --div--;core.form.tabs:categories,
                categories,
            --div--;core.form.tabs:notes,
                rowDescription,
            --div--;core.form.tabs:extended,
        ',
        'columnsOverrides' => [
            'assets' => [
                'config' => [
                    'filter' => [
                        0 => [
                            'parameters' => [
                                'allowedFileExtensions' => 'youtube, vimeo',
                            ],
                        ],
                    ],
                    'overrideChildTca' => [
                        'columns' => [
                            'uid_local' => [
                                'config' => [
                                    'appearance' => [
                                        'elementBrowserAllowed' => 'youtube, vimeo',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
);
