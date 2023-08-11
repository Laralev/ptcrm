<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::extensions('xml');

Router::defaultRouteClass('DashedRoute');

Router::addUrlFilter(function ($params, $request) {
    if ($request->getParam('lang') && !isset($params['lang'])) {
        $params['lang'] = $request->getParam('lang');
    }
    return $params;
});


$basicRoutes = function (RouteBuilder $routes) {

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);
    $routes->connect('/getpassword', ['controller' => 'Users', 'action' => 'getpassword']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/offer/:id/:tbl/:floorplan_id', ['controller'=>'Proposals', 'action'=>'proposal'])->setPass(['id', 'tbl', 'floorplan_id']);

    $routes->connect('/pages/*', 'Pages::display');
    
    $routes->prefix('admin', function ($routes) {
        $routes->connect('/', ['controller' => 'Users', 'action'=>'dashboard']);
        $routes->connect('/categories/index/:pid', ['controller' => 'Categories', 'action'=>'index'])->setPass(['pid']);
        $routes->connect('/stats/props', ['controller' => 'Users', 'action'=>'dashboard', 'props' ]);
        $routes->connect('/stats/users', ['controller' => 'Users', 'action'=>'dashboard', 'users' ]);
        $routes->connect('/myaccount', ['controller' => 'Users', 'action'=>'myaccount']);
        $routes->fallbacks('DashedRoute');
    });

    $routes->fallbacks('DashedRoute');

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};

$realRoutes = function ($routes) use ($basicRoutes) {
    $routes->scope('/', $basicRoutes);

    return $routes;
};

$routes->scope('/ar', ['lang' => 'ar'], $realRoutes);
$routes->scope('/ru', ['lang' => 'ru'], $realRoutes);
$routes->scope('/en', ['lang' => 'en'], $realRoutes);
$routes->scope('/', $realRoutes);
