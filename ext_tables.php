<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use AgrosupDijon\BulmaPackage\Controller\WebsiteModuleController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

(function (){
    // Register new backend skin to override rte_ckeditor css
    $GLOBALS['TBE_STYLES']['skins']['bulma_package'] = [
        'name' => 'Override RTE',
        'stylesheetDirectories' => [
            'css' => 'EXT:bulma_package/Resources/Public/Css/Skin/'
        ]
    ];
})();
