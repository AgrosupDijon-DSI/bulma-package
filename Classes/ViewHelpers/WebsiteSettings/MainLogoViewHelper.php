<?php

declare(strict_types=1);

namespace AgrosupDijon\BulmaPackage\ViewHelpers\WebsiteSettings;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * @internal May change / vanish any time
 */
class MainLogoViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly FileRepository $fileRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function render()
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_bulmapackage_settings');
        $result = $queryBuilder
            ->select('uid', 'pid', 'sys_language_uid', 'logo_main')
            ->from('tx_bulmapackage_settings')
            ->executeQuery()
            ->fetchAssociative();

        if ($result) {
            $files = $this->fileRepository->findByRelation('tx_bulmapackage_settings', 'logo_main', $result['uid']);

            return $files[0];
        }
        return false;
    }
}
