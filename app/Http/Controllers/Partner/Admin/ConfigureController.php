<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Configure;
use App\Models\Admin\AdminMenu;
use Illuminate\Http\Request;
use App\Lib\Help;
class ConfigureController extends Controller
{
    public function index(Request $request)
    {
        $data           = Configure::getConfigList($request->all());
        $data['pid']    = $request->input("pid", 0);
        $listConfig     = config('model.list.sys_configures');

        // 顶部按钮
        $buttonConfig = [
            ['route' => "configAdd",    'params' => [$data['pid']]],
            ['route' => "configFlush",  'params' => []]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView('config/list')->with(['data' => $data, 'listConfig' => $listConfig, 'buttons' => $buttons]);
    }

    /**
     * 添加
     * @param int $pid
     * @return mixed
     */
    public function add($pid = 0, $id = 0) {
        // 存在上级
        if ($pid) {
            $configParent   = Configure::find($pid);
            if (!$configParent) {
                return \Help::AdminErrorView(__('error.configure.add.invalid_pid'), 2);
            }
        } else {
            $configParent = [];
        }

        // 是编辑
        $id = \Request::input("id", 0);
        if ($id) {
            $config   = Configure::find($id);
            if (!$config) {
                return Help::AdminErrorView(__('error.configure.add.invalid_id'), 2);
            }
        } else {
            $config = new Configure();
        }

        if (\Request::isMethod('post')) {
            $name   = \Request::input("name");
            if (!$name) {
                return Help::returnJson(__("error.config.add.empty_name"), 0);
            }

            // sign
            $sign   = \Request::input("sign");
            if (!$sign) {
                return Help::returnJson(__("error.configure.add.empty_sign"), 0);
            }
            if ($configParent && !$id) {
                $sign = $configParent->sign . "_" . $sign;
            }

            $_config = Configure::where('sign', '=', $sign)->first();
            if (!$config && $_config) {
                return \Help::returnJson(__("error.configure.add.already_exist"), 0);
            }

            $value  = \Request::input("value");
            if (!$value) {
                return Help::returnJson(__("error.configure.add.empty_value"), 0);
            }
            $config->pid    = $pid;
            $config->sign   = $sign;
            $config->name   = $name;
            $config->value  = $value;
            $config->save();

            return Help::returnJson(__("error.configure.add.success"), 1, ['url' => route("configList", ['pid' => $pid])]);
        }

        return Help::adminView('config/add')->with(['pid' => $pid, 'configParent' => $configParent, 'config' => $config]);
    }

    /**
     * 状态修改
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $config   = Configure::find($id);
        if (!$config) {
            return Help::returnJson(__('error.configure.status.invalid_item'), 0);
        }

        $config->status = $config->status  == 1 ? 0 : 1;
        $config->save();

        return Help::returnJson(__('error.configure.status.success'), 1);
    }

    /**
     * 刷新缓存
     */
    public function flush() {
        \C::flush();
        $links = [
            ['name' => "配置列表", 'url' => route("configList")]
        ];
        return Help::AdminErrorView(__("error.configure.flush.success"), 1, ['links' => $links]);
    }

    /**
     * buttons参数设定
     * @return array
     */
    public function getButtonParams()
    {
        $pid    = \Request::input('pid', 0);
        return ['configAdd' => [$pid]];
    }


}
