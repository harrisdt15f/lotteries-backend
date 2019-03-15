<?php namespace App\Lib;

// Tom 2019
class SystemCheck {

    public static function checkRedis() {

    }

    public static function checkBeanstalk() {

    }

    public static function checkDb() {

    }

    public static function checkCpu() {

    }

    // 检测硬盘
    public static  function checkDisk() {
        $disks      = [];
        $process    = new Process("df -k");
        $process->run();
        $buffer     =   $process->getOutput();
        $_disks     =   array_filter(preg_split("[\r|\n]", trim($buffer)));
        array_shift($_disks);
        foreach($_disks as $disk){
            $temp   =   array_values(array_filter(explode(" ",  $disk)));
            if(count($temp) < 5) {
                continue;
            }

            if(strpos($temp[4],'%') === false) {
                continue;
            }

            $disks[] = [
                'disk'  => $temp[0],
                'size'  => self::byteFormat($temp[1]),
                'used'  => self::byteFormat($temp[2]),
                'avail' => self::byteFormat($temp[3]),
                'use%'  => $temp[4],
            ];
        }

        return $disks;
    }

    // 检测进程数量
    public static  function checkProcessCount($exe, $submitParams = '') {
        $process = new Process("ps -w -eo pid,command | grep {$exe} | grep -e '{$submitParams}' | grep -v grep");
        $process->run();

        $buffer = $process->getOutput();
        $procs  = array_filter(explode("\n", $buffer));

        return count($procs);
    }

    /**
     * 字节格式化 把字节数格式为 B K M G T P E Z Y 描述的大小
     * @param int $size 大小
     * @param int $precision 显示类型
     * @return int
     */
    public static function byteFormat($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = ['K', 'M', 'G', 'T'];
        $suffix = $suffixes[floor($base)];
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffix;
    }
}
