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
 * ChunkViewHelper
 */
class ChunkViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('as', 'string', 'Name of variable to create', true);
        $this->registerArgument('data', 'array', 'Array of data to chunck', true);
        $this->registerArgument('length', 'integer', 'Chunk size', true);
    }

    public function render(): void
    {
        $this->renderingContext->getVariableProvider()->add($this->arguments['as'], array_chunk($this->arguments['data'], $this->arguments['length']));
    }
}
