<?php
use PhpCsFixer\Finder;
use PhpCsFixer\Config;

return Config::create()
    ->setFinder(Finder::create()->in(__DIR__)->exclude('vendor'))
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_namespace' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => true,
        'declare_equal_normalize' => true,
        'declare_strict_types' => true,
        'function_typehint_space' => true,
        'general_phpdoc_annotation_remove' => true,
        'hash_to_slash_comment' => true,
        'linebreak_after_opening_tag' => true,
        'lowercase_cast' => true,
        'modernize_types_casting' => true,
        'no_empty_comment' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_scalar' => true,
        'phpdoc_summary' => true,
        'phpdoc_trim' => true,
        'phpdoc_var_without_name' => true,
        'short_scalar_cast' => true,
        'single_quote' => true,
        'single_blank_line_before_namespace' => true,
        'switch_case_semicolon_to_colon' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
    ])
    ->setUsingCache(false);