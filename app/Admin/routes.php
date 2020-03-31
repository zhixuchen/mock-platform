<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->resource('mockProject', MockProjectController::class);
    $router->resource('mockProjectMethod', MockProjectMethodController::class);
    $router->get('/', 'HomeController@index')->name('admin.home');
});
