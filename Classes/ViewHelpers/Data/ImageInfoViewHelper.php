<?php

declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers\Data;

use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * ImageInfoViewHelper
 */
class ImageInfoViewHelper extends AbstractViewHelper
{
    /**
     * @var array<string, int|string>
     */
    protected static $supportedProperties = [
        'width' => 0,
        'height' => 1,
        'type' => 3,
        'origFile' => 'origFile',
        'origFile_mtime' => 'origFile_mtime',
    ];

    /**
     * Initialize arguments.
     *
     * @throws Exception
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('src', 'string', 'Path to a file');
        $this->registerArgument('property', 'string', 'Possible values: width, height, type, origFile, origFile_mtime');
    }

    public function render(): string
    {
        $src = $this->arguments['src'];
        $property = $this->arguments['property'];
        if (!array_key_exists($property, self::$supportedProperties)) {
            throw new \InvalidArgumentException('The value of property is invalid. Valid properties are: width, height, type, origFile or origFile_mtime', 6476753000);
        }
        $assetCollector = self::getAssetCollector();
        $mediaOnPage = $assetCollector->getMedia();
        foreach ($mediaOnPage as $mediaName => $mediaData) {
            if (str_contains($src, $mediaName)) {
                return (string)$mediaData[self::$supportedProperties[$property]];
            }
        }
        return '';
    }

    /**
     * @return AssetCollector
     */
    protected static function getAssetCollector(): AssetCollector
    {
        return GeneralUtility::makeInstance(AssetCollector::class);
    }
}
