<?php

/** ============= 合作伙伴 路由 =========== */

// 不需要权限
Route::group(['namespace' => "Admin"], function () {
    Route::get('/register',                                     'AuthController@showRegistrationForm')->name('register');
    Route::post('/register',                                    'AuthController@create')->name('register');
    Route::get('/login',                                        'AuthController@showLoginForm')->name('login');
    Route::post('/login',                                       'AuthController@login')->name('login');
    Route::get('/logout',                                       'AuthController@logout')->name('logout');
    Route::post('/tCode',                                       'AuthController@getTcode')->name('tCode');
});

// 需要权限的
Route::group(['middleware' => 'partner.auth', 'namespace' => "Partner"], function () {
    // 首页
    Route::get('/',                                             'HomeController@frame')->name('frame');
    Route::get('home',                                          'HomeController@home')->name('home');

    // 合作伙伴 菜单
    Route::get('partner/menu/list',                             'PartnerMenuController@index')->name('partnerMenuList');
    Route::get('partner/menu/add//{pid}/{id?}',                 'PartnerMenuController@add')->name('partnerMenuAdd');
    Route::get('partner/menu/status/{id}',                      'PartnerMenuController@status')->name('partnerMenuStatus');

    // 合作伙伴 访问日志
    Route::get('partner/access/log',                            'PartnerAccessLogController@index')->name('partnerAccessLog');

    // 合作伙伴
    Route::get('partner/user/list',                             'PartnerUserController@index')->name('partnerUserList');
    Route::get('partner/user/detail/{id}',                      'PartnerUserController@detail')->name('partnerUserDetail');
    Route::any('partner/user/add/{id?}',                        'PartnerUserController@add')->name('partnerUserAdd');
    Route::get('partner/user/status/{id}',                      'PartnerUserController@status')->name('partnerUserStatus');

    // 合作伙伴用户组
    Route::get('partner/group/list',                            'AdminGroupController@index')->name('partnerGroupList');
    Route::get('partner/group/detail/{id}',                     'AdminGroupController@detail')->name('partnerGroupDetail');
    Route::any('partner/group/add/',                            'AdminGroupController@add')->name('partnerGroupAdd');
    Route::any('partner/group/del',                             'AdminGroupController@del')->name('partnerGroupDel');
    Route::any('partner/group/aclDetail/{id}',                  'AdminGroupController@aclDetail')->name('partnerGroupAclDetail');
    Route::any('partner/group/aclEdit/{id}',                    'AdminGroupController@aclEdit')->name('partnerGroupAclEdit');
    Route::any('partner/group/addChildGroup/{id}',              'AdminGroupController@addChildGroup')->name('partnerGroupAddChildGroup');

});