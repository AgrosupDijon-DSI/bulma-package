<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * TextIconUtility
 */
class TextIconUtility
{
    /**
     * @param array $parameters
     * @return void
     */
    public function addIconItems(array $parameters)
    {
        $directory = $parameters['row']['icon_set'][0] ?? '';
        if ($directory !== '') {
            /** @var array $icons */
            $icons = $this->getIcons($directory);
            if ($icons) {
                $parameters['items'] = array_merge($parameters['items'], $icons);
            }
        }
    }

    /**
     * @param string $directory
     * @return array|bool
     */
    protected function getIcons($directory)
    {
        $icons = [];
        if (strpos($directory, 'EXT:') !== 0 || !strpos($directory, 'Resources/Public')) {
            return false;
        }
        $path = GeneralUtility::getFileAbsFileName($directory);
        if (!is_dir($path)) {
            return false;
        }
        $files = iterator_to_array(
            new \FilesystemIterator(
                $path,
                \FilesystemIterator::KEY_AS_PATHNAME
            )
        );
        ksort($files);
        foreach ($files as $key => $fileinfo) {
            /** @var \SplFileInfo $fileinfo */
            if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['svg', 'png', 'gif'])) {
                $icons[] = [
                    $fileinfo->getBasename('.' . $fileinfo->getExtension()),
                    $fileinfo->getBasename('.' . $fileinfo->getExtension()),
                    $directory . $fileinfo->getFilename()
                ];
            }
        }

        return $icons;
    }
}
