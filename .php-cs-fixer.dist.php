<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests')
    ->in(__DIR__ . '/database')
    ->in(__DIR__ . '/config')
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true, // Use PSR-12 as the base ruleset
    'array_syntax' => ['syntax' => 'short'], // Enforce short array syntax []
    'binary_operator_spaces' => [
        'default' => 'single_space',
        'operators' => ['=>' => 'align_single_space_minimal']
    ],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => [
        'statements' => ['return', 'if'],
    ],
    'cast_spaces' => ['space' => 'single'],
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'one',   // Одна пустая строка между константами
            'property' => 'one', // Одна пустая строка между свойствами
            'method' => 'one',   // Одна пустая строка между методами
        ],
    ],
    'concat_space' => ['spacing' => 'one'], // Add space around concatenation operator
    'declare_strict_types' => true, // Enforce strict typing
    'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'single_quote' => true, // Use single quotes instead of double quotes
    'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    'no_extra_blank_lines' => [
        'tokens' => [
            'curly_brace_block',
            'extra',
            'throw',
            'use',
            'parenthesis_brace_block',
            'return',
            'continue',
            'break',
        ],
    ], // Remove extra blank lines
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
