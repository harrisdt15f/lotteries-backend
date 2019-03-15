<?php

// 不需要权限
Route::group(['namespace' => "Admin"], function () {
    Route::get('/register',                                             'AuthController@showRegistrationForm')->name('register');
    Route::post('/register',                                            'AuthController@create')->name('register');
    Route::get('/login',                                                'AuthController@showLoginForm')->name('login');
    Route::post('/login',                                               'AuthController@login')->name('login');
    Route::get('/logout',                                               'AuthController@logout')->name('logout');
    Route::post('/tCode',                                               'AuthController@getTcode')->name('tCode');
});

Route::post('bet',                                                      'Api\ApiGameController@bet')->name('bet');

// 后台管理
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Admin"], function () {
    Route::get('/',                                                     'HomeController@frame')->name('frame');
    Route::get('home',                                                  'HomeController@home')->name('home');

    // Menu
    Route::get('menuList',                                              'AdminMenuController@index')->name('menuList');
    Route::any('menuAdd/{pid}/{id?}',                                   'AdminMenuController@add')->name('menuAdd');
    Route::get('menuStatus/{id}',                                       'AdminMenuController@status')->name('menuStatus');

    // Chat ID
    Route::get('telegram/chatId/list',                                  'TelegramChatIdController@index')->name('telegramChatIdList');
    Route::any('telegram/chatId/add/{id?}',                             'TelegramChatIdController@add')->name('telegramChatIdAdd');
    Route::any('telegram/chatId/status/{id}',                           'TelegramChatIdController@status')->name('telegramChatIdStatus');

    // Logs
    Route::get('admin/access/log',                                      'AdminAccessLogController@index')->name('adminAccessLog');

    // 后台用户管理
    Route::get('admin/user/list',                                       'AdminUserController@index')->name('adminUserList');
    Route::get('admin/user/detail/{id}',                                'AdminUserController@detail')->name('adminUserDetail');
    Route::any('admin/user/add/{id?}',                                  'AdminUserController@add')->name('adminUserAdd');
    Route::get('admin/user/status/{id}',                                'AdminUserController@status')->name('adminUserStatus');
    Route::any('admin/password/{id}',                                   'AdminUserController@password')->name('adminUserPassword');

    // 后台用户组管理
    Route::get('admin/group/list',                                      'AdminGroupController@index')->name('adminGroupList');
    Route::get('admin/group/detail/{id}',                               'AdminGroupController@detail')->name('adminGroupDetail');
    Route::any('admin/group/add/',                                      'AdminGroupController@add')->name('adminGroupAdd');
    Route::any('admin/group/del',                                       'AdminGroupController@del')->name('adminGroupDel');
    Route::any('admin/group/aclDetail/{id}',                            'AdminGroupController@aclDetail')->name('adminGroupAclDetail');
    Route::any('admin/group/aclEdit/{id}',                              'AdminGroupController@aclEdit')->name('adminGroupAclEdit');
    Route::any('admin/group/addChildGroup/{id}',                        'AdminGroupController@addChildGroup')->name('adminGroupAddChildGroup');

    // 缓存
    Route::get('cache/list',                                            'CacheController@index')->name('cacheList');
    Route::get('cache/flush/{key?}',                                    'CacheController@flush')->name('cacheFlush');
    Route::get('cache/flushAll',                                        'CacheController@flushAll')->name('cacheFlushAll');

    // 后台配置
    Route::get('configure/list',                                        'ConfigureController@index')->name('configureList');
    Route::get('configure/detail/{id}',                                 'ConfigureController@detail')->name('configureDetail');
    Route::get('configure/flush',                                       'ConfigureController@flush')->name('configureFlush');
    Route::get('configure/status/{id}',                                 'ConfigureController@status')->name('configureStatus');
    Route::any('configure/add/{pid}/{id?}',                             'ConfigureController@add')->name('configureAdd');
    Route::get('configure/del/{id}',                                    'ConfigureController@del')->name('configureDel');

    // 测试页面
    Route::get('test',                                                  'TestController@index')->name('test');
    Route::get('test/bet',                                              'TestController@Bet')->name('testBet');
});

// 合作商相关
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Partner"], function () {
    // 统计数据 - 用户
    Route::get('partner/user/list',                                     'PartnerUserController@index')->name('partnerUserList');
    Route::get('partner/user/add',                                      'PartnerUserController@add')->name('partnerUserAdd');
    Route::get('partner/user/status/{id}',                              'PartnerUserController@status')->name('partnerUserStatus');
    Route::get('partner/user/setting/{id}',                             'PartnerUserController@setting')->name('partnerUserSetting');
});

// 游侠相关
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Game"], function () {
    // 游戏
    Route::get('lottery/list',                                          'LotteryController@index')->name('lotteryList');
    Route::get('lottery/detail/{id}',                                   'LotteryController@detail')->name('lotteryDetail');
    Route::any('lottery/add/{id?}',                                     'LotteryController@add')->name('lotteryAdd');
    Route::get('lottery/status/{id}',                                   'LotteryController@status')->name('lotteryStatus');
    Route::get('lottery/del/{id}',                                      'LotteryController@del')->name('lotteryDel');
    Route::get('lottery/flush',                                         'LotteryController@flush')->name('lotteryFlush');

    // 玩法
    Route::get('method/list',                                           'MethodController@index')->name('methodList');
    Route::get('method/status/{id}',                                    'MethodController@status')->name('methodStatus');

    // 奖期
    Route::get('issue/list',                                            'IssueController@index')->name('issueList');
    Route::get('issue/detail/{id}',                                     'IssueController@detail')->name('issueDetail');
    Route::any('issue/encode/{id?}',                                    'IssueController@encode')->name('issueEncode');
    Route::get('issue/calculated/{id}',                                 'IssueController@calculated')->name('issueCalculated');
    Route::get('issue/prize/{id}',                                      'IssueController@prize')->name('issuePrize');
    Route::get('issue/point/{id}',                                      'IssueController@point')->name('issuePoint');
    Route::get('issue/trace/{id}',                                      'IssueController@trace')->name('issueTrace');
    Route::any('issue/gen',                                             'IssueController@gen')->name('issueGen');

    // 奖期规则
    Route::get('issueRule/list',                                        'IssueRuleController@index')->name('issueRuleList');
    Route::any('issueRule/add/{id?}',                                   'IssueRuleController@add')->name('issueRuleAdd');
    Route::get('issueRule/del/{id}',                                    'IssueRuleController@del')->name('issueRuleDel');

    // 追号
    Route::get('trace/list',                                            'TraceController@index')->name('traceList');
    Route::get('trace/detail/{id}',                                     'TraceController@detail')->name('traceDetail');

    // 订单
    Route::get('project/list',                                          'ProjectController@index')->name('projectList');
    Route::get('project/detail/{id}',                                   'ProjectController@detail')->name('projectDetail');
    Route::get('project/cancel/{id}',                                   'ProjectController@cancel')->name('projectCancel');
});

// 玩家相关
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Player"], function () {

    // 玩家
    Route::get('player/list',                                           'PlayerController@index')->name('playerList');
    Route::any('player/add',                                            'PlayerController@add')->name('playerAdd');
    Route::get('player/detail/{id}',                                    'PlayerController@detail')->name('playerDetail');
    Route::any('player/password/{id}',                                  'PlayerController@password')->name('playerPassword');
    Route::any('player/frozen/{id}',                                    'PlayerController@frozen')->name('playerFrozen');
    Route::any('player/setting/{id}',                                   'PlayerController@setting')->name('playerSetting');
    Route::any('player/fund/{id}',                                      'PlayerController@fund')->name('playerFund');

    // 银行卡
    Route::get('card/list',                                             'CardController@index')->name('playerCardList');
    Route::any('card/add/{id?}',                                        'CardController@add')->name('playerCardAdd');
    Route::any('card/status/{id}',                                      'CardController@status')->name('playerCardStatus');
    Route::any('card/del/{id}',                                         'CardController@del')->name('playerCardDel');
    Route::any('card/fixTime/{id}',                                     'CardController@fixTime')->name('playerCardFixTime');

    // 日工资配置
    Route::get('salary/config/list',                                    'UserSalaryConfigController@index')->name('playerSalaryConfigList');
    Route::any('salary/config/add/{id?}',                               'UserSalaryConfigController@add')->name('playerSalaryConfigAdd');
    Route::any('salary/config/status/{id}',                             'UserSalaryConfigController@status')->name('playerSalaryConfigStatus');
    Route::any('salary/config/del/{id}',                                'UserSalaryConfigController@del')->name('playerSalaryConfigDel');

    // 分红配置
    Route::get('dividend/config/list',                                  'UserDividendConfigController@index')->name('playerDividendConfigList');
    Route::any('dividend/config/add/{id?}',                             'UserDividendConfigController@add')->name('playerDividendConfigAdd');
    Route::any('dividend/config/status/{id}',                           'UserDividendConfigController@status')->name('playerDividendConfigStatus');
    Route::any('dividend/config/del/{id}',                              'UserDividendConfigController@del')->name('playerDividendConfigDel');
});

// 资金相关
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Account"], function () {
    // 资金账户
    Route::get('account/list',                                          'AccountController@index')->name('accountList');

    // 帐变类型
    Route::get('accountChangeType/list',                                'AccountChangeTypeController@index')->name('accountChangeTypeList');
    Route::any('accountChangeType/add/{id?}',                           'AccountChangeTypeController@add')->name('accountChangeTypeAdd');
    Route::get('accountChangeType/flush',                               'AccountChangeTypeController@flush')->name('accountChangeTypeFlush');

    // 帐变
    Route::get('accountChangeReport/list',                              'AccountChangeReportController@index')->name('accountChangeReportList');
    Route::any('accountChangeReport/detail',                            'AccountChangeReportController@detail')->name('accountChangeReportDetail');

    // 帐变历史
    Route::get('accountChangeReportHistory/list',                       'AccountChangeReportHistoryController@index')->name('accountChangeReportHistoryList');
    Route::any('accountChangeReportHistory/detail',                     'AccountChangeReportHistoryController@detail')->name('accountChangeReportHistoryDetail');

    // 系统转账
    Route::get('systemTransfer/list',                                   'SystemTransferController@index')->name('systemTransferList');
    Route::get('systemTransfer/check/{id}',                             'SystemTransferController@check')->name('systemTransferCheck');

    // 玩家转账
    Route::get('playerTransfer/list',                                   'PlayerTransferController@index')->name('playerTransferList');
});

// 充提
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Finance"], function () {
    // 充值
    Route::get('recharge/list',                                         'RechargeController@index')->name('rechargeList');
    Route::any('recharge/detail/{id}',                                  'RechargeController@detail')->name('rechargeDetail');
    Route::any('recharge/hand/{id}',                                    'RechargeController@hand')->name('rechargeHand');
    Route::any('recharge/logDetail/{id}',                               'RechargeController@logDetail')->name('rechargeLogDetail');

    // 提现
    Route::get('withdraw/list',                                         'WithdrawController@index')->name('withdrawList');
    Route::any('withdraw/hand/{id}',                                    'WithdrawController@hand')->name('withdrawHand');
    Route::any('withdraw/logDetail/{id}',                               'WithdrawController@logDetail')->name('withdrawLogDetail');

    Route::any('rechargeLogList',                                       'RechargeLogController@index')->name('rechargeLogList');
    Route::any('withdrawLogList',                                       'WithdrawLogController@index')->name('withdrawLogList');

    // 审核
    Route::get('withdrawCheck/list',                                    'WithdrawCheckController@index')->name('withdrawCheckList');
    Route::get('withdrawCheck/hand',                                    'WithdrawCheckController@hand')->name('withdrawCheckHand');
    Route::any('withdrawCheck/log',                                     'WithdrawCheckController@log')->name('withdrawCheckLog');
});

// 报表相关
Route::group(['middleware' => 'admin.auth', 'namespace' => "Admin\Report"], function () {
    // 统计数据 - 用户
    Route::get('userStat/list',                                         'UserStatController@index')->name('userStatList');
    Route::get('userSale/list',                                         'UserSaleController@index')->name('userSaleList');

    // 日工资
    Route::get('salary/list',                                           'SalaryController@index')->name('salaryList');

    // 分红
    Route::get('dividend/list',                                         'DividendController@index')->name('dividendList');
});