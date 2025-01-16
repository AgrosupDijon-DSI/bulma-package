<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class DivViewHelper
 */
class DivViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'div';

    public function render(): string
    {
        $this->tag->setContent($this->renderChildren());
        return $this->tag->render();
    }
}
