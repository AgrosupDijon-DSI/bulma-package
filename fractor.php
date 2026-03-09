<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;

return FractorConfiguration::configure()
    ->withPaths([
        __DIR__ . '/',
    ])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_13,
    ])
    ->withSkip([
        __DIR__ . '/.tools/*',
        __DIR__ . '/vendor/*',
        __DIR__ . '/phpcs.xml',
        __DIR__ . '/node_modules/*',
        __DIR__ . '/public/*',
        __DIR__ . '/Resources/Public/Contrib/*',
    ])
    ->withOptions([
        TypoScriptProcessorOption::INDENT_SIZE => 2,
        TypoScriptProcessorOption::INDENT_CHARACTER => PrettyPrinterConfiguration::INDENTATION_STYLE_SPACES,
        TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS => true,
    ]);
