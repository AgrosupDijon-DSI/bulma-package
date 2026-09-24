<?php

declare(strict_types=1);

namespace AgrosupDijon\BulmaPackage\Domain\Finishers;

use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Extbase\Service\CacheService;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ClearCache extends AbstractFinisher
{
    public function __construct(
        public CacheService $cacheService
    ) {
    }

    /**
     * @var array
     */
    protected $defaultOptions = [
        'pageUid' => 0,
    ];

    protected function executeInternal(): void
    {
        $pageUid = $this->parseOption('pageUid');

        if (!is_string($pageUid) || empty((int)$pageUid)) {
            /** @var PageArguments $routing */
            $routing = $this->finisherContext->getRequest()->getAttribute('routing');
            $pageUid = $routing->getPageId();
        }

        $this->cacheService->clearPageCache((int)$pageUid);
    }
}
