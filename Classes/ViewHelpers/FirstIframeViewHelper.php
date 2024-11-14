<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * FirstIframeViewHelper
 */
class FirstIframeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('serviceName', 'string', 'Name of service, for usage with Consent Manager');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return false|string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $dom = new \DOMDocument();

        try {
            $dom->loadHTML($renderChildrenClosure());
        } catch (\Exception $e) {
            $headerLabel = LocalizationUtility::translate('tt_content.iframe.invalidHtml', 'bulma_package');
            $errorMessage = '';

            if ($error = libxml_get_last_error()) {
                $errorMessage = '<div class="message-body">' . LocalizationUtility::translate('tt_content.iframe.error', 'bulma_package') . '<strong>' . $error->message . '</strong></div>';
            }
            $bulmaMessage = <<<EOD
<div class="message is-danger">
    <div class="message-header">$headerLabel</div>
    $errorMessage
</div>
EOD;
            return $bulmaMessage;
        }

        $iframe = $dom->getElementsByTagName('iframe')->item(0);

        // Render only 1st iframe found
        if ($iframe instanceof \DOMElement) {
            $iframe->removeAttribute('width');
            $iframe->removeAttribute('height');

            if (!empty($arguments['serviceName'])) {
                if ($iframe->hasAttribute('src')) {
                    $iframe->setAttribute('data-src', $iframe->getAttribute('src'));
                    $iframe->removeAttribute('src');
                }
                $iframe->setAttribute('data-name', $arguments['serviceName']);
            }

            return $iframe->C14N();
        }
        return false;
    }
}
