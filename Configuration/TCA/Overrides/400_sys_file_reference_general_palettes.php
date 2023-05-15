<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

$GLOBALS['TCA']['sys_file_reference']['palettes']['basicImageoverlayPalette'] = [
    'showitem' => '
        title,alternative,--linebreak--,
        crop
    '
];

$GLOBALS['TCA']['sys_file_reference']['palettes']['basicImageoverlayPaletteWithoutCrop'] = [
    'showitem' => '
        title,alternative
    '
];

$GLOBALS['TCA']['sys_file_reference']['palettes']['imageoverlayPaletteWithoutLink'] = [
    'showitem' => '
        title,alternative,--linebreak--,
        description,--linebreak--,crop
    '
];

$GLOBALS['TCA']['sys_file_reference']['palettes']['videoOverlayPaletteWithoutLink'] = [
    'showitem' => '
        title,--linebreak--,autoplay
    '
];
