<?php namespace App\Lib;

class Configure
{
    public function get($key, $default = null) {
        return \Cache::tags('configure')->get($key, function () use($key, $default) {
            $res = \DB::table('sys_configures')->where('sign', '=', $key)->where('status', '=', 1)->first();
            if (!is_null($res)) {
                \Cache::tags('configure')->forever($key, $res->value);
                return $res->value;
            } else {
                return $default;
            }
        });
    }

    public function set($key,$value){
        \DB::table('sys_configures')->where('sign', '=', $key)->update(array('value' => $value));
        \Cache::tags('configure')->forget($key);
    }

    public function flush() {
        \Cache::tags('configure')->flush();
    }
}