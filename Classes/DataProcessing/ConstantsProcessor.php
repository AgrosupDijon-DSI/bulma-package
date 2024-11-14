<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\DataProcessing;

use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

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
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        // The key to process
        $key = (string)$cObj->stdWrapValue('key', $processorConfiguration);
        if (empty($key)) {
            $key = 'page';
        }

        $settings = $this->getSettings($key);

        // Set the target variable
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if (!empty($targetVariableName)) {
            $processedData[$targetVariableName] = $settings;
        } else {
            $processedData['constants'] = $settings;
        }

        return $processedData;
    }

    protected function getSettings(string $key): array
    {
        $settings = $flatSettings = [];
        $prefix = $key . '.';

        /** @var FrontendTypoScript $frontendTyposcript */
        $frontendTyposcript = $this->getRequest()->getAttribute('frontend.typoscript');

        if ($frontendTyposcript->hasSetup()) {
            $flatSettings = array_filter($frontendTyposcript->getFlatSettings(), function ($key) use ($prefix) {
                return str_starts_with($key, $prefix);
            }, ARRAY_FILTER_USE_KEY);
        }

        foreach ($flatSettings as $key => $value) {
            $this->array_set($settings, substr($key, strlen($prefix)), $value);
        }

        return $settings;
    }

    protected function array_set(array &$array, string $key, mixed $value): array
    {
        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    protected function getRequest(): ServerRequest
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
