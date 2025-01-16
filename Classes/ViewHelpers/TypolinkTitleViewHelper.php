<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3\CMS\Core\LinkHandling\TypoLinkCodecService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * TypolinkTitleViewHelper
 */
class TypolinkTitleViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     *
     * @throws Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('parameter', 'string', 'stdWrap.typolink style parameter string');
    }

    public function render(): string|null
    {
        $typolinkConfiguration = self::createTypolinkParameterArrayFromArgument($this->arguments['parameter']);
        if (!empty($typolinkConfiguration) && !empty($typolinkConfiguration['title'])) {
            return $typolinkConfiguration['title'];
        }
        return LocalizationUtility::translate('lightbox-link-label', 'BulmaPackage');
    }

    /**
     * Transforms ViewHelper arguments to typo3link.parameters.typoscript option as array.
     *
     * @param string $parameter Example: 19 _blank - "testtitle \"with whitespace\"" &X=y
     *
     * @return array Associative array of TypoLink parts with the keys url, target, class, title, additionalParams
     */
    protected static function createTypolinkParameterArrayFromArgument(string $parameter): array
    {
        $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);

        return $typoLinkCodec->decode($parameter);
    }
}
