<?php

declare(strict_types=1);

// https://mlocati.github.io/php-cs-fixer-configurator/
$finder = PhpCsFixer\Finder::create()->in(__DIR__)->exclude('somedir');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);
