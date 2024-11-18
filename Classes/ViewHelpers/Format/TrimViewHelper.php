<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * TrimViewHelper
 */
class TrimViewHelper extends AbstractViewHelper
{
    public function render(): string
    {
        return trim($this->renderChildren());
    }
}
