<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config->getFinder()
    ->in(__DIR__ . '/')
    ->exclude([
        'vendor',
    ])
;

$config->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());
$config->setRules([
    '@PSR12' => true,
]);

return $config;
