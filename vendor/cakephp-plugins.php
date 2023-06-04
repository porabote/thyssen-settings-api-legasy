<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Acl' => $baseDir . '/plugins/Acl/',
        'Api' => $baseDir . '/plugins/Api/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Dictionaries' => $baseDir . '/plugins/Dictionaries/',
        'Docs' => $baseDir . '/plugins/Docs/',
        'Fias' => $baseDir . '/plugins/Fias/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Store' => $baseDir . '/plugins/Store/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/'
    ]
];