<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config->getFinder()
    ->in(__DIR__ . '/')
    ->exclude([
        'public',
    ])
;

$config->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

return $config;
