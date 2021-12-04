<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'binary_operator_spaces' => true,
        'native_function_invocation' => true,
        'no_unused_imports' => true,
   ]);
