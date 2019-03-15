<?php namespace App\Console\Commands\User;

use App\Console\Commands\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class Stat extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'user:initStat {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "初始化用户的结算和销量报表";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');

        if($type == 'init'){
            $this->info("初始化用户销量记录!");
            //3点之后执行 今天的数据
            $now = time();
//            if($now < strtotime(date("Y-m-d").' 03:00:00')){
//                $this->info("不能在3点前执行!");
//                return ;
//            }

            $day = date("Y-m-d");

            $query=\App\Models\User::where('id','>',0)->where('del','=',0);
            $count = $query->count();

            $size=1000;
            $totalpage = ceil($count/$size);

            for($p=1;$p<=$totalpage;$p++) {
                $users = $query->skip( ($p-1) * $size)->take($size)->get();
                foreach($users as $user){
                    \App\Models\StatDay::initData($day,$user);
                }
            }
        }elseif($type == 'team'){
            $this->info("生成用户370销量统计数据!");
            //3点之后执行 统计之前的
            $now = time();
//            if($now < strtotime(date("Y-m-d").' 03:00:00')){
//                $this->info("不能在3点前执行!");
//                return ;
//            }

            $day = date("Y-m-d");

            $query=\App\Models\User::where('id','>',0)->where('del','=',0);
            $count = $query->count();

            $size=1000;
            $totalpage = ceil($count/$size);

            for($p=1;$p<=$totalpage;$p++) {
                $users = $query->skip( ($p-1) * $size)->take($size)->get();
                foreach($users as $user){
                    \App\Models\Stat::initTeam370Data($day,$user);
                }
            }
        }
    }

}
