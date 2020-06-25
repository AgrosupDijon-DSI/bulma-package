<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\Backend;

use TYPO3\CMS\Backend\View\PageLayoutView;

class PageLayoutViewHook
{
    /**
     * Allow the usage of records in colpos 999 for mask nested content elements
     *
     * @param array $params
     * @param PageLayoutView $parentObject
     * @return bool
     */
    public function contentIsUsed(array $params, PageLayoutView $parentObject)
    {
        if ($params['used']) {
            return true;
        }
        $record = $params['record'];
        return $record['colPos'] === 999;
    }
}
