<?php

declare(strict_types=1);

namespace AgrosupDijon\BulmaPackage\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Retrieves the website's last update date among pages and tt_content.
 * Default variable is `lastUpdate`
 *
 * Minimal TypoScript configuration
 * 10 = last-update
 *
 * Advanced TypoScript configuration
 * 10 = last-update
 * 10 {
 *   tables = pages, tt_content, tx_news_domain_model_news
 *   as = otherVariableName
 * }
 */
class LastUpdateProcessor implements DataProcessorInterface
{
    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array<string, mixed> $contentObjectConfiguration The configuration of Content Object
     * @param array<string, mixed> $processorConfiguration The configuration of this processor
     * @param array<string, mixed> $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array<mixed> the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData,
    ) {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        $tables = GeneralUtility::trimExplode(',', (string)$cObj->stdWrapValue('tables', $processorConfiguration, 'pages, tt_content'));

        $dates = [];

        foreach ($tables as $table) {
            $records = $cObj->getRecords($table, [
                'pidInList.data' => 'leveluid:0',
                'pidInList' => 'this',
                'recursive' => '10',
                'selectFields' => 'tstamp',
                'orderBy' => 'tstamp DESC',
                'max' => '1',
            ]);
            $dates[] = $records[0]['tstamp'] ?? 0;
        }

        // set the date into a variable, default "lastUpdate"
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'lastUpdate');
        $processedData[$targetVariableName] = $dates ? max($dates) : null;

        return $processedData;
    }
}
