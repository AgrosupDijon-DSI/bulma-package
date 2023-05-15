<?php

use AgrosupDijon\BulmaPackage\Controller\WebsiteModuleController;

return [
    'system_WebsiteSettings' => [
        'parent' => 'system',
        'position' => ['before' => '*'],
        'access' => 'user,group',
        'path' => '/module/system/WebsiteSettings',
        'labels' => 'LLL:EXT:bulma_package/Resources/Private/Language/locallang_mod.xlf',
        'iconIdentifier' => 'module-dashboard',
        'extensionName' => 'BulmaPackage',
        'controllerActions' => [
            WebsiteModuleController::class => [
                'overview', 'customColors', 'metaTags'
            ],
        ],
    ],
];

