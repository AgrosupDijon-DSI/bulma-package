<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class CustomConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            $this->getPageLayoutRecursiveFunction(),
        ];
    }

    protected function getPageLayoutRecursiveFunction(): ExpressionFunction
    {
        return new ExpressionFunction('pageLayoutRecursive', function () {
            // Not implemented, we only use the evaluator
        }, function($arguments) {
            $reverseRootline = array_reverse($arguments['tree']->rootLine);
            foreach ($reverseRootline as $page) {
                if(!empty($page['layout'])) {
                    return $page['layout'];
                }
            }
            return false;
        });
    }
}
