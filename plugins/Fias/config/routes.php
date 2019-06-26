<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Fias',
    ['path' => '/fias'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
