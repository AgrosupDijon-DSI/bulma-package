<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

// Temporary fix for https://forge.typo3.org/issues/96135
$GLOBALS['TCA']['tx_bulmapackage_accordion_item']['columns']['hidden']['config']['items'][0]['invertStateDisplay'] = false;
$GLOBALS['TCA']['tx_bulmapackage_card_group_item']['columns']['hidden']['config']['items'][0]['invertStateDisplay'] = false;
$GLOBALS['TCA']['tx_bulmapackage_carousel_item']['columns']['hidden']['config']['items'][0]['invertStateDisplay'] = false;
$GLOBALS['TCA']['tx_bulmapackage_icon_group_item']['columns']['hidden']['config']['items'][0]['invertStateDisplay'] = false;
$GLOBALS['TCA']['tx_bulmapackage_tab_item']['columns']['hidden']['config']['items'][0]['invertStateDisplay'] = false;