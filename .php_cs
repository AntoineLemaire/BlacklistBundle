<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/')
;

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules([
        '@Symfony'               => true,
        'array_syntax'           => ['syntax' => 'short'],
        'array_indentation'      => true,
        'ordered_class_elements' => true,
        'phpdoc_order'           => true,
        'ordered_imports'        => true,
        'phpdoc_to_comment'      => false,
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals'       => true,
        ],
    ])
    ->setFinder($finder)
    ;
