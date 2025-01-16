<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers\Data;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * TrimViewHelper
 */
class IsNullViewHelper extends AbstractViewHelper
{
    public function render(): bool
    {
        return is_null($this->renderChildren());
    }
}
