<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\PageRenderer;

use AgrosupDijon\BulmaPackage\Service\CompileService;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * PreProcessHook
 */
class PreProcessHook
{
    /**
     * @var CompileService
     */
    protected $compileService;

    /**
     * @param array $params
     * @param PageRenderer $pagerenderer
     * @throws \Exception
     */
    public function execute(array &$params, PageRenderer &$pagerenderer): void
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend() === false) {
            return;
        }
        foreach (['cssLibs', 'cssFiles'] as $key) {
            $files = [];
            if (is_array($params[$key])) {
                foreach ($params[$key] as $file => $settings) {
                    $compiledFile = $this->getCompileService()->getCompiledFile($file);
                    if (!is_null($compiledFile)) {
                        $settings['file'] = $compiledFile;
                        $files[$compiledFile] = $settings;
                    } else {
                        $files[$file] = $settings;
                    }
                }
                $params[$key] = $files;
            }
        }
    }

    /**
     * Get the compile service
     *
     * @return CompileService
     */
    protected function getCompileService()
    {
        if ($this->compileService === null) {
            $this->compileService = GeneralUtility::makeInstance(CompileService::class);
        }
        return $this->compileService;
    }
}
