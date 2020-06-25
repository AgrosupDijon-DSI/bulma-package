<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * FirstIframeViewHelper
 */
class FirstIframeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;


    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string the formatted amount
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $dom = new \DOMDocument();

        try {
            $dom->loadHTML($renderChildrenClosure());
        } catch (\Exception $e) {
            return false;
        }

        $iframe = $dom->getElementsByTagName('iframe')->item(0);

        // Render only 1st iframe found
        if ($iframe instanceof \DOMElement) {
            return $iframe->C14N();
        } else {
            return false;
        }
    }
}
