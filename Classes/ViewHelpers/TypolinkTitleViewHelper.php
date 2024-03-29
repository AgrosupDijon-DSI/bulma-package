<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3\CMS\Core\LinkHandling\TypoLinkCodecService;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;


/**
 * TypolinkTitleViewHelper
 */
class TypolinkTitleViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments.
     *
     * @return void
     * @throws Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('parameter', 'string', 'stdWrap.typolink style parameter string');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $typolinkConfiguration = self::createTypolinkParameterArrayFromArgument($arguments['parameter']);

        if (!empty($typolinkConfiguration) && !empty($typolinkConfiguration['title'])) {
            return $typolinkConfiguration['title'];
        }else{
            return LocalizationUtility::translate('lightbox-link-label', 'bulma_package');
        }
    }

    /**
     * Transforms ViewHelper arguments to typo3link.parameters.typoscript option as array.
     *
     * @param string $parameter Example: 19 _blank - "testtitle \"with whitespace\"" &X=y
     *
     * @return array Associative array of TypoLink parts with the keys url, target, class, title, additionalParams
     */
    protected static function createTypolinkParameterArrayFromArgument($parameter)
    {
        $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);

        return $typoLinkCodec->decode($parameter);
    }
}
