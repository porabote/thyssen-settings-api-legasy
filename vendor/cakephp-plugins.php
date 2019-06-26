<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Acl' => $baseDir . '/plugins/Acl/',
        'Api' => $baseDir . '/plugins/Api/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Chat' => $baseDir . '/plugins/Chat/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Docs' => $baseDir . '/plugins/Docs/',
        'Fias' => $baseDir . '/plugins/Fias/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Site' => $baseDir . '/plugins/Site/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/'
    ]
];