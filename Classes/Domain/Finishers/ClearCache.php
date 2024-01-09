<?php

declare(strict_types=1);

namespace AgrosupDijon\BulmaPackage\Domain\Finishers;

use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Extbase\Service\CacheService;

class ClearCache extends AbstractFinisher
{

    public function __construct(
        public CacheService $cacheService
    ) {
    }

    protected function executeInternal()
    {
        $pageUid = $this->parseOption('pageUid');

        if(empty($pageUid)){
            /** @var PageArguments $routing */
            $routing = $this->finisherContext->getRequest()->getAttribute('routing');
            $pageUid = $routing->getPageId();
        }

        $this->cacheService->clearPageCache($pageUid);
    }
}