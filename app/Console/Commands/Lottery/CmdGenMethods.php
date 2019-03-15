<?php namespace App\Console\Commands\Lottery;

use App\Console\Commands\Command;
use App\Lib\Game\Lottery;
use Illuminate\Support\Facades\DB;

// 生成玩法
class CmdGenMethods extends Command {

    protected $signature    = 'lottery:genMethods';
    protected $description  = "lottery:genMethods 生成玩法到数据库!!";

    public function handle()
    {


        $totalCount = 0;
        $lotteries = Lottery::getAllLottery();
        $bar = $this->output->createProgressBar(count($lotteries));
        foreach ($lotteries as $lottery) {
            $data = [];
            $methods = $lottery->methods;

            foreach ($methods as $sign => $method) {
                $data[] = [
                    'series_id'         => $lottery->series_id,
                    'lottery_name'      => $lottery->cn_name,
                    'lottery_id'        => $lottery->en_name,
                    'method_name'       => $method['name'],
                    'method_id'         => $sign,
                    'method_group'      => $method['group'],
                    'method_row'        => isset($method['row']) ? $method['row'] : "",
                    'status'            => 1,
                ];
            }

            // 写入
            $res = DB::table('methods')->insert($data);
            $bar->advance();
            $this->info("--彩种{$lottery->cn_name}插入条数:" . count($data));
            $totalCount += count($data);
        }

        $bar->finish();
        $this->info("总计插入条数:" . $totalCount);
    }

}
