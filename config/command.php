<?php

$phpbin     = env("PHP_BIN_PATH", '/usr/bin/php-7.1');
$basepath   = __DIR__.'/../'; //根目录

$cron_path          = __DIR__.'/../storage/logs/queue/cron_';

return array(
    'phpbin'        => $phpbin,
    'basepath'      => $basepath,
    'cron_path'     => $cron_path,

    // 用 crontab 调度的进程
    'crontab' => array(
        //------------队列守护------------
        'queue_recharge'=>array(
            'name'      => '充值回调',
            'cron'      => '* * * * *',
            'command'   => "{$phpbin} {$basepath}artisan queue:loop 1 --queue=recharge --sleep=1",
            'logfile'   => $cron_path.'queue_recharge.log',
        ),

        'queue_withdraw'=>array(
            'name'      => '提现回调',
            'cron'      => '* * * * *',
            'command'   => "{$phpbin} {$basepath}artisan queue:loop 1 --queue=withdraw --sleep=1",
            'logfile'   => $cron_path.'queue_withdraw.log',
        ),

        'queue_log'=>array(
            'name'      => '日志存储',
            'cron'      => '* * * * *',
            'command'   => "{$phpbin} {$basepath}artisan queue:loop 1 --queue=log --sleep=1",
            'logfile'   => $cron_path.'queue_log.log',
        ),

        'queue_common'=>array(
            'name'      => '通用',
            'cron'      => '* * * * *',
            'command'   => "{$phpbin} {$basepath}artisan queue:loop 1 --queue=common --sleep=1",
            'logfile'   => $cron_path.'queue_common.log',
        ),

        /** ---- 一般cron ----- */
        'cron_withdraw_query'=>array(
            'name'      => '提现轮询',
            'cron'      => '*/2 * * * *',
            'command'   => "{$phpbin} {$basepath}artisan finance:CmdWithdrawQuery",
            'logfile'   => $cron_path.'cron_withdraw_query.log',
        ),

        'cron_stat_client_gen'=>array(
            'name'      => '商户预先生成',
            'cron'      => '10 5 * * *',
            'command'   => "{$phpbin} {$basepath}artisan common:genStat client",
            'logfile'   => $cron_path.'cron_gen_stat_client.log',
        ),

        'cron_stat_account_gen'=>array(
            'name'      => '账户预先生成',
            'cron'      => '10 5 * * *',
            'command'   => "{$phpbin} {$basepath}artisan common:genStat account",
            'logfile'   => $cron_path.'cron_gen_stat_account.log',
        ),
    ),
);