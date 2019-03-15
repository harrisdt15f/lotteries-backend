<?php

Route::post('login',                    'Api\AuthController@login')->name('login');
Route::options('login',                 'Api\AuthController@login')->name('login');

Route::post('register',                 'Api\AuthController@register')->name('register');
Route::options('register',              'Api\AuthController@register')->name('register');

Route::any('logout',                    'Api\AuthController@logout')->name('logout');
Route::options('logout',                'Api\AuthController@logout')->name('logout');

Route::any('captcha',                   'Api\AuthController@captcha')->name('captcha');


// API 登录
Route::group(['middleware' => ['jwt.auth', 'api'], 'namespace' => "Api"], function () {

    // 游戏相关
    Route::any('lotteryList',           'ApiGameController@lotteryList')->name('lotteryList');
    Route::any('methodList',            'ApiGameController@methodList')->name('methodList');
    Route::any('issueList',             'ApiGameController@issueList')->name('issueList');

    Route::any('bet',                   'ApiGameController@bet')->name('bet');

});