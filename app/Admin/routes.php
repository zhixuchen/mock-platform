<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->resource('authMenu', AuthMenuController::class);
    $router->resource('authPermission', AuthPermissionController::class);
    $router->resource('company', CompanyController::class);

    $router->get('/', 'HomeController@index')->name('admin.home');

});
