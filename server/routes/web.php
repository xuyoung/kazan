<?php

$moduleDir = dirname(__DIR__) . '/app/KaZanApp';
$modules   = get_config_routes();

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['namespace' => 'App\KaZanApp', 'middleware' => 'authCheck', 'prefix' => '/api'], function ($router) use ($moduleDir, $modules) {
    $router->get('app-login-info', 'Auth\Controllers\AuthController@appLoginInfo');
    add_routes($router, $moduleDir, $modules);
});

$router->group(['namespace' => 'App\KaZanApp', 'prefix' => '/api'], function ($router) {
    $router->post('auth/login', 'Auth\Controllers\AuthController@login');
    $router->get('auth/check', 'Auth\Controllers\AuthController@check');
    $router->get('auth/login-out', 'Auth\Controllers\AuthController@loginOut');

});
