<?php namespace App\Console\Commands\Lottery;

use App\Console\Commands\Command;
use App\Models\Game\Issue;

// 开奖
class CronSelfOpen extends Command {

    protected $signature    = 'lottery:selfOpen  {lottery_id}';
    protected $description  = "lottery:selfOpen 自开彩开奖!!";

    public function handle()
    {
        $lotteryId  = $this->argument('lottery_id');
        $issues      = Issue::getNeedOpenIssue($lotteryId);

        $code = "1,2,3,4,5";
        foreach ($issues as $issue) {
            $res = $issue->open($code);
        }

        $this->info(1111);
    }

}
