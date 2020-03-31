<?php

use Illuminate\Http\Request;

// 权限层
Route::group(['middleware' => ['app_auth'], 'namespace' => 'V1'], function () {
    Route::get('user/info', 'UserController@info')->name('用户信息');
});

// 无需登录
Route::group(['middleware' => [], 'namespace' => 'V1'], function () {

    Route::post('sms/sendSms', 'SmsController@sendSms')->name('发送短信');

    Route::post('user/login', 'UserController@login')->name('用户登录');
    Route::post('user/reg', 'UserController@reg')->name('用户注册');
});


