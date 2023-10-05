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
            '='  => 'align_single_space_minimal_by_scope',
            '=>' => 'align_single_space_minimal_by_scope',
        ]],
        'not_operator_with_successor_space'  => true,
    ])
    ->setFinder($finder)
;
