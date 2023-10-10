<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                             => true,
        '@Symfony'                           => true,
        '@PhpCsFixer'                        => true,
        'object_operator_without_whitespace' => true,
        'binary_operator_spaces'             => ['operators' => [
            '='  => 'align_single_space_minimal',
            '=>' => 'align_single_space_minimal',
        ]],
        'not_operator_with_successor_space'  => true,
        'php_unit_method_casing'             => ['case' => 'snake_case'],
    ])
    ->setFinder($finder)
;
