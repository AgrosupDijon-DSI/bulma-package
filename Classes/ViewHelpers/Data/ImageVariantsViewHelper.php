<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers\Data;

use AgrosupDijon\BulmaPackage\Utility\ImageVariantsUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ImageVariantsViewHelper
 */
class ImageVariantsViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('as', 'string', 'Name of variable to create', true);
        $this->registerArgument('variants', 'array', 'Variants for responsive images', false);
        $this->registerArgument('multiplier', 'array', 'Multiplier to calculate responsive image widths', false);
        $this->registerArgument('gutters', 'array', 'Gutter that needs to be respected when calculating responsive image widths', false);
        $this->registerArgument('corrections', 'array', 'Corrections to be applied after calculation of image widths', false);
    }

    public function render(): void
    {
        if ($this->arguments['gutters'] === '') {
            $this->arguments['gutters'] = null;
        }
        $variants = ImageVariantsUtility::getImageVariants($this->arguments['variants'], $this->arguments['multiplier'], $this->arguments['gutters'], $this->arguments['corrections']);
        $this->renderingContext->getVariableProvider()->add($this->arguments['as'], $variants);
    }
}
