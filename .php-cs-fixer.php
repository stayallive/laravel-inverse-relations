<?php

$finder = PhpCsFixer\Finder::create()
                           ->in(__DIR__ . '/src')
                           ->in(__DIR__ . '/tests')
                           ->name('*.php')
                           ->ignoreDotFiles(true)
                           ->ignoreVCS(true);

$config = new PhpCsFixer\Config;

$config
    ->setRules([
        '@Symfony' => true,

        'yoda_style'                                       => false,
        'phpdoc_order'                                     => true,
        'new_with_braces'                                  => false,
        'short_scalar_cast'                                => true,
        'phpdoc_to_comment'                                => false,
        'single_line_throw'                                => false,
        'single_line_empty_body'                           => true,
        'single_blank_line_at_eof'                         => true,
        'no_superfluous_phpdoc_tags'                       => false,
        'linebreak_after_opening_tag'                      => true,
        'class_attributes_separation'                      => false,
        'blank_line_between_import_groups'                 => false,
        'not_operator_with_successor_space'                => false,
        'single_trait_insert_per_statement'                => false,
        'nullable_type_declaration_for_default_null_value' => true,

        'concat_space'                 => [
            'spacing' => 'one',
        ],
        'array_syntax'                 => [
            'syntax' => 'short',
        ],
        'ordered_types'                => [
            'sort_algorithm'  => 'none',
            'null_adjustment' => 'always_last',
        ],
        'ordered_imports'              => [
            'imports_order'  => ['class', 'const', 'function'],
            'sort_algorithm' => 'length',
        ],
        'cast_spaces'                  => [
            'space' => 'none',
        ],
        'new_with_parentheses'         => [
            'named_class'     => false,
            'anonymous_class' => false,
        ],
        'curly_braces_position'        => [
            'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        ],
        'align_multiline_comment'      => [
            'comment_type' => 'phpdocs_like',
        ],
        'global_namespace_import'      => [
            'import_classes'   => null,
            'import_constants' => null,
            'import_functions' => true,
        ],
        'type_declaration_spaces'      => [
            'elements' => [],
        ],
        'nullable_type_declaration'    => [
            'syntax' => 'question_mark',
        ],
        'attribute_empty_parentheses'  => [
            'use_parentheses' => false,
        ],
        'trailing_comma_in_multiline'  => [
            'elements' => ['arrays', 'arguments', 'parameters', 'match'],
        ],
        'phpdoc_align'                 => [
            'align' => 'vertical',
            'tags'  => [
                'param',
                'property',
                'property-read',
                'property-write',
                'return',
                'throws',
                'type',
                'var',
                'method',
            ],
        ],
        'increment_style'              => [
            'style' => 'post',
        ],
        'phpdoc_no_alias_tag'          => [
            'replacements' => [
                'type' => 'var',
                'link' => 'see',
            ],
        ],
        'no_extra_blank_lines'         => [
            'tokens' => [],
        ],
        'function_declaration'         => [
            'closure_function_spacing' => 'one',
        ],
        'binary_operator_spaces'       => [
            'operators' => [
                '|'  => null,
                '='  => 'align_single_space',
                '=>' => 'align_single_space',
            ],
        ],
        'fully_qualified_strict_types' => [
            'phpdoc_tags' => [],
        ],
    ])
    ->setFinder($finder);

return $config;
