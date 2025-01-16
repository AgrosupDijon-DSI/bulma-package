<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * SocialsLinksViewHelper
 */
class SocialsLinksViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('as', 'string', 'Name of variable to create', true);
        $this->registerArgument('links', 'array', 'Array of "socialsLinks" from Bulma Package settings module', true);
    }

    public function render(): void
    {
        $linksByType = self::buildLinksByType($this->arguments['links']);
        $this->renderingContext->getVariableProvider()->add($this->arguments['as'], $linksByType);
    }

    /**
     * Groups links by "type" and remove bad (empty) links
     *
     * @param array $links
     * @return array
     */
    protected static function buildLinksByType(array $links): array
    {
        $reorganizedLinks = [];
        foreach ($links as $link) {
            if (self::isUrl($link['data']['link']) === true) {
                if ($link['data']['standalone']) {
                    $type = $link['data']['uid'];
                } elseif (!empty($link['iconFile']) && $link['data']['icon_custom']) {
                    $type = $link['iconFile'][0]->getIdentifier();
                } else {
                    $type = str_replace(' ', '', $link['data']['icon']);
                }
                $reorganizedLinks[$type]['icon'] = $link['data']['icon'];
                $reorganizedLinks[$type]['iconFile'] = $link['data']['icon_custom'] && !empty($link['iconFile']) ? $link['iconFile'][0] : '';
                $reorganizedLinks[$type]['data'][] = [
                    'url' => $link['data']['link'],
                    'label' => $link['data']['label'],
                    'force_label' => $link['data']['force_label'],
                ];
                $reorganizedLinks[$type]['uniqueId'] = uniqid();
            }
        }

        return $reorganizedLinks;
    }

    /**
     * Check if a typolink string leads to an url creation
     *
     * @param string $typolink
     * @return bool
     */
    protected static function isUrl(string $typolink)
    {
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $url = $contentObject->typoLink_URL(['parameter' => $typolink]);

        return empty($url) ? false : true;
    }
}
