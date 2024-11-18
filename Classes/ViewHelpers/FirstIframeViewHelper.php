<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * FirstIframeViewHelper
 */
class FirstIframeViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('serviceName', 'string', 'Name of service, for usage with Consent Manager');
    }

    public function render(): string|false
    {
        $dom = new \DOMDocument();
        try {
            $dom->loadHTML($this->renderChildren());
        } catch (\Exception $e) {
            $headerLabel = LocalizationUtility::translate('tt_content.iframe.invalidHtml', 'BulmaPackage');
            $errorMessage = '';

            if ($error = libxml_get_last_error()) {
                $errorMessage = '<div class="message-body">' . LocalizationUtility::translate('tt_content.iframe.error', 'BulmaPackage') . '<strong>' . $error->message . '</strong></div>';
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

            if (!empty($this->arguments['serviceName'])) {
                if ($iframe->hasAttribute('src')) {
                    $iframe->setAttribute('data-src', $iframe->getAttribute('src'));
                    $iframe->removeAttribute('src');
                }
                $iframe->setAttribute('data-name', $this->arguments['serviceName']);
            }

            return $iframe->C14N();
        }
        return false;
    }
}
