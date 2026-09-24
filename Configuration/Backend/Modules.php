<?php

use AgrosupDijon\BulmaPackage\Controller\WebsiteModuleController;

return [
    'system_BulmaPackageWebsitesettings' => [
        'parent' => 'system',
        'position' => ['before' => '*'],
        'access' => 'user',
        'path' => '/module/system/WebsiteSettings',
        'labels' => 'bulma_package.modules.website',
        'iconIdentifier' => 'module-dashboard',
        'extensionName' => 'BulmaPackage',
        'controllerActions' => [
            WebsiteModuleController::class => [
                'overview', 'customColors', 'metaTags',
            ],
        ],
    ],
];
