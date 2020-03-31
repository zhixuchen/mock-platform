<?php

use Illuminate\Http\Request;

// 权限层
Route::group(['middleware' => ['admin_auth']], function () {
    Route::prefix('auth')->group(function () {
        // 获取管理员菜单
        Route::any('menu', 'AuthController@menu');  //1
        // 修改密码
        Route::post('updatePasswd', 'AuthController@updatePasswd');//1
        // 公司总角色功能
        Route::get('rolePermission', 'PermissionController@rolePermission');//1
        // 添加角色
        Route::post('saveRole', 'PermissionController@saveRole');//1
        // 修改角色
        Route::post('updateRole', 'PermissionController@updateRole');//1
        // 删除角色
        Route::any('delRole', 'PermissionController@delRole');//1
        // 角色菜单id
        Route::get('roleMenuId', 'PermissionController@roleMenuId');//1
        // 管理员列表
        Route::get('listAdmin', 'AuthController@listAdmin');//1
        // 添加管理员
        Route::post('saveAdmin', 'AuthController@saveAdmin');//1
        // 编辑管理员
        Route::post('updateAdmin', 'AuthController@updateAdmin');//1
        // 管理员详情
        Route::get('infoAdmin', 'AuthController@infoAdmin');//1
        // 获取公司角色
        Route::get('listCompanyRole', 'AuthController@listCompanyRole');//1
        Route::post('updateAdminActive', 'AuthController@updateAdminActive');//1
    });
});

// 无需登录
Route::group(['middleware' => []], function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
    });

});
