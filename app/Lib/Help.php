<?php
namespace App\Lib;


class Help
{

    /** =========== 前端模板渲染 -- frontend =========== */

    /**
     * 返回试图
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static function view($view) {
        $theme = self::getTheme();
        return view($theme . "/" . $view);
    }

    /**
     * 获取当前admin的theme名称
     * @return string
     */
    static function getTheme() {

        return "frontend";
    }

    /** =========== 后端模板渲染 =========== */
    /**
     * @param $msg 必须翻译过的
     * @param $status
     * @param array $data
     * @param int $position
     * @return \Illuminate\Http\JsonResponse
     */
    static function returnJson($msg, $status = 0, $data = [], $position = 10000) {

        return response()->json([
            'status'    => $status ? "success" : "fail",
            'msg'       => $msg,
            'data'      => $data,
            'position'  => $position
        ]);

    }

    /**
     * @param $msg 必须翻译过的
     * @param $status
     * @param array $data
     * @param int $position
     * @return \Illuminate\Http\JsonResponse
     */
    static function returnApiJson($msg, $status = 0, $data = []) {

        $data = [
            'isSuccess'     => $status ? true :false,
            'msg'           => $msg,
            'data'          => $data
        ];

        return response()->json($data)->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param $msg
     * @param $type 1 成功 2 失败 3 提示
     * @param $option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static function AdminErrorView($msg, $type, $option = []) {
        $theme = self::getAdminTheme();
        return view($theme . "/error")->with(['msg' => $msg, 'type' => $type, 'option' => $option]);
    }

    /**
     * 返回试图
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static function adminView($view) {
        $theme = self::getAdminTheme();
        return view($theme . "/" . $view);
    }

    /**
     * 获取当前admin的theme名称
     * @return string
     */
    static function getAdminTheme() {

        return "admin";
    }

    /** ============== 商户模板 ============= */

    /**
     * 返回试图
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static function clientView($view) {
        $theme = self::getClientTheme();
        return view($theme . "/" . $view);
    }

    /**
     * 获取当前admin的theme名称
     * @return string
     */
    static function getClientTheme() {

        return "client";
    }

    static function cutStr($str, $length, $dot = false) {
        $resStr =  mb_substr($str, 0, $length, 'utf-8');
        if ($dot && $resStr !=  $str) {
            $resStr  .= "...";
        }
        return $resStr;
    }




    /** ============== 字段检查是否为空函数 ============= */

    /**
     * 检测字段是否万为空的 翻译
     * @param $module
     * @param $field
     * @param string $type
     * @return string
     */
    static function __empty($module, $field, $type = 'front') {
        $fieldName  = __("field_{$type}." . $module .'.'. $field);
        return __('error.field.empty', ['field' => $fieldName]);
    }

    /**
     * 检测字段不合法 翻译
     * @param $type
     * @param $field
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    static function __invalid($type, $field) {
        $transKey   = "view." . $type . ".field." . $field;
        $transValue = __($transKey);
        if ($transKey == $transValue) {
            $transValue = $field;
        }

        return __('view.field.error.invalid', ['field' => $transValue]);
    }

    /**
     * 字段修改成功 翻译
     * @param $type
     * @param $field
     * @param $res 是否成功
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    static function __modify($type, $field, $res) {
        $transKey   = "view." . $type . ".field." . $field;
        $transValue = __($transKey);
        if ($transKey == $transValue) {
            $transValue = $field;
        }

        if ($res) {
            return __('view.field.modify.success',  ['field' => $transValue]);
        } else {
            return __('view.field.modify.fail',     ['field' => $transValue]);
        }

    }

    /**
     * 2位小数
     * @param $number
     * @return string
     */
    static function number2($number) {
        $number = $number / 100;
        return number_format( self::stdRound( ceil($number * 1000) / 1000, 2),2,'.','' );
    }

    /**
     * 4位小数
     * @param $number
     * @return string
     */
    static function number4($number) {
        $number = $number / 10000;
        return number_format( self::stdRound( ceil($number * 10000) / 10000, 4),4,'.','' );
    }

    static function stdRound($num, $d = 0)
    {
        return round($num + 0.0001 / pow(10, $d), $d);
    }
}