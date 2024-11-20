<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\DataProcessing;

use AgrosupDijon\BulmaPackage\Utility\TypoScriptUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;

/**
 * Minimal TypoScript configuration
 * Assign all available typoscript constants for a key to template view, the
 * default key that is used is `page` and the default variable is `constants`.
 *
 * 10 = AgrosupDijon\BulmaPackage\DataProcessing\ConstantsProcessor
 *
 *
 * Advanced TypoScript configuration
 *
 * 10 = AgrosupDijon\BulmaPackage\DataProcessing\ConstantsProcessor
 * 10 {
 *   key = page
 *   as = constants
 * }
 */
class ConstantsProcessor implements DataProcessorInterface
{
    /**
     * @param ContentObjectRenderer $cObj
     * @param array $contentObjectConfiguration
     * @param array $processorConfiguration
     * @param array $processedData
     * @return array
     * @throws ContentRenderingException
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData): array
    {
        // The key to process
        $key = (string)$cObj->stdWrapValue('key', $processorConfiguration);
        if ($key === '') {
            $key = 'page';
        }

        $constants = TypoScriptUtility::getConstantsByPrefix($cObj->getRequest(), $key);
        $constants = TypoScriptUtility::unflatten($constants);

        // Set the target variable
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if ($targetVariableName !== '') {
            $processedData[$targetVariableName] = $constants;
        } else {
            $processedData['constants'] = $constants;
        }

        return $processedData;
    }
}
