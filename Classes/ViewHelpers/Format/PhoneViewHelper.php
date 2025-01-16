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
 * PhoneViewHelper
 */
class PhoneViewHelper extends AbstractViewHelper
{
    public function render(): array|string|null
    {
        // Get rid of everything between parentheses (parentheses included)
        $firstReplace = preg_replace('/\((\X+?)\)/', '', $this->renderChildren());
        // Get rid of everything that is not a digit or a + character in first position
        return preg_replace('/(?!(^\+))\D+/', '', $firstReplace);
    }
}
