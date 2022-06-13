<?php
declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks;

/**
 * Mostly copy paste from https://github.com/b13/masi
 */

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SlugModifier
{
    /**
     * @var string
     */
    protected $tableName;
    /**
     * @var string
     */
    protected $fieldName;
    /**
     * @var int
     */
    protected $workspaceId;
    /**
     * @var array
     */
    protected $configuration;
    /**
     * Defines whether the slug field should start with "/".
     * For pages (due to rootline functionality), this is a must have, otherwise the root level page
     * would have an empty value.
     *
     * @var bool
     */
    protected $prependSlashInSlug;
    /**
     * @var int
     */
    protected $pid;
    /**
     * @var array
     */
    protected $recordData;

    /**
     * Hooks into after a page URL was generated.
     *
     * @param array $parameters
     * @param SlugHelper $helper
     * @return string
     */
    public function modifyGeneratedSlugForPage(array $parameters, SlugHelper $helper): string
    {
        $this->resolveHookParameters(
            $parameters['configuration'],
            $parameters['tableName'],
            $parameters['fieldName'],
            $parameters['pid'],
            $parameters['workspaceId'],
            $parameters['record']
        );
        return $this->regenerateSlug($helper);
    }

    /**
     * Re-creates the slug like core, however, uses our custom "resolveParentPageRecord" method.
     *
     * @param SlugHelper $helper
     * @return string
     */
    protected function regenerateSlug(SlugHelper $helper): string
    {
        $prefix = $this->configuration['generatorOptions']['prefix'] ?? '';
        if ($this->configuration['generatorOptions']['prefixParentPageSlug'] ?? false) {
            $languageFieldName = $GLOBALS['TCA'][$this->tableName]['ctrl']['languageField'] ?? null;
            $languageId = (int)($this->recordData[$languageFieldName] ?? 0);
            $parentPageRecord = $this->resolveParentPageRecord($this->pid, $languageId);
            if (is_array($parentPageRecord)) {
                // If the parent page has a slug, use that instead of "re-generating" the slug from the parents' page title
                if (!empty($parentPageRecord['slug'])) {
                    $rootLineItemSlug = $parentPageRecord['slug'];
                } else {
                    $rootLineItemSlug = $helper->generate($parentPageRecord, (int)$parentPageRecord['pid']);
                }
                $rootLineItemSlug = trim($rootLineItemSlug, '/');
                if (!empty($rootLineItemSlug)) {
                    $prefix .= $rootLineItemSlug;
                }
            }
        }
        $fieldSeparator = $this->configuration['generatorOptions']['fieldSeparator'] ?? '/';
        $slugParts = [];
        $replaceConfiguration = $this->configuration['generatorOptions']['replacements'] ?? [];
        foreach ($this->configuration['generatorOptions']['fields'] ?? [] as $fieldNameParts) {
            if (is_string($fieldNameParts)) {
                $fieldNameParts = GeneralUtility::trimExplode(',', $fieldNameParts);
            }
            foreach ($fieldNameParts as $fieldName) {
                if (!empty($this->recordData[$fieldName])) {
                    $pieceOfSlug = $this->recordData[$fieldName];
                    $pieceOfSlug = str_replace(
                        array_keys($replaceConfiguration),
                        array_values($replaceConfiguration),
                        $pieceOfSlug
                    );
                    $slugParts[] = $pieceOfSlug;
                    break;
                }
            }
        }
        $slug = implode($fieldSeparator, $slugParts);
        $slug = $helper->sanitize($slug);
        // No valid data found
        if ($slug === '' || $slug === '/') {
            $slug = 'default-' . substr(md5((string)json_encode($this->recordData)), 0, 10);
        }
        if ($this->prependSlashInSlug && ($slug[0] ?? '') !== '/') {
            $slug = '/' . $slug;
        }
        if (!empty($prefix)) {
            $slug = $prefix . $slug;
        }
        return (string)$helper->sanitize($slug);
    }

    /**
     * Take over hook values to our own class.
     *
     * @param array $configuration
     * @param string $tableName
     * @param string $fieldName
     * @param int $pid
     * @param int $workspaceId
     * @param array $record
     * @return void
     */
    protected function resolveHookParameters(array $configuration, string $tableName, string $fieldName, int $pid, int $workspaceId, array $record): void
    {
        $this->configuration = $configuration;
        $this->tableName = $tableName;
        $this->fieldName = $fieldName;
        $this->pid = $pid;
        $this->workspaceId = $workspaceId;
        $this->recordData = $record;
        if ($tableName === 'pages' && $fieldName === 'slug') {
            $this->prependSlashInSlug = true;
        } else {
            $this->prependSlashInSlug = $this->configuration['prependSlash'] ?? false;
        }
    }

    /**
     * Similar to core logic, but a bit different:
     * Fetches the parent page, but only respects recyclers! includes sysfolders
     *
     * @param int $pid
     * @param int $languageId
     * @return array|null
     */
    protected function resolveParentPageRecord(int $pid, int $languageId): ?array
    {
        $parentPageRecord = null;
        $rootLine = BackendUtility::BEgetRootLine($pid, '', true, ['nav_title', 'exclude_slug_for_subpages']);
        do {
            $parentPageRecord = array_shift($rootLine);
            $parentPageRecord = $this->tryRecordOverlay($parentPageRecord, $languageId);
            $excludeThisPageRecordForSubpages = (bool)$parentPageRecord['exclude_slug_for_subpages'];
        } while (!empty($rootLine) && ((int)$parentPageRecord['doktype'] === 255 || $excludeThisPageRecordForSubpages));
        return $parentPageRecord;
    }

    /**
     * Fetches a record translation if there is one and returns that one instead.
     *
     * @param array $page
     * @param int $languageId
     * @return array
     */
    protected function tryRecordOverlay(array $page, int $languageId): array
    {
        if ($languageId > 0) {
            $localizedParentPageRecord = BackendUtility::getRecordLocalization('pages', $page['uid'], $languageId);
            if (!empty($localizedParentPageRecord)) {
                $page = reset($localizedParentPageRecord);
            }
        }
        return $page;
    }
}
