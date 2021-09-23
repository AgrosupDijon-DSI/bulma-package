<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Hooks\DataHandling;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

class DataHandlerHook
{
    public function processDatamap_postProcessFieldArray(&$status, $table, $id, $fieldArray, DataHandler $dataHandler)
    {
        if($table == 'tx_bulmapackage_settings' && $status == 'new'){

            // Check if a record exists for pid
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bulmapackage_settings');
            $countBulmaSettings = $queryBuilder
                ->count('uid')
                ->from('tx_bulmapackage_settings')
                ->where(
                    $queryBuilder->expr()->in('pid', $fieldArray['pid'])
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $fieldArray['sys_language_uid'])
                )
                ->execute()->fetchColumn(0);

            if($countBulmaSettings > 0){
                $status = false;

                $message = GeneralUtility::makeInstance(FlashMessage::class,
                    $this->getLanguageService()->sL('LLL:EXT:bulma_package/Resources/Private/Language/Backend.xlf:tx_bulmapackage_settings.warning'),
                    '',
                    FlashMessage::WARNING,
                    true
                );

                $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
                $messageQueue = $flashMessageService->getMessageQueueByIdentifier('extbase.flashmessages.tx_bulmapackage_system_bulmapackagewebsitesettings');
                $messageQueue->addMessage($message);

                $returnUrl = GeneralUtility::sanitizeLocalUrl(GeneralUtility::_GP('returnUrl'));
                HttpUtility::redirect($returnUrl);
            }

        }
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

}
