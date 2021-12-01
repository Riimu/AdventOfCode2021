<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('/vendor/');

$config = new PhpCsFixer\Config();

return $config->setFinder($finder)
    ->setRules([
        '@PSR12' => true,

        'no_unused_imports' => true,
   ]);
