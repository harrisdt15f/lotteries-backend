@extends('admin.layouts.add_ajax')

@section("content")
    <div role="content">
        <div>
            <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                <thead>
                <tr role="row">
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">用户名</th>
                    <th style="text-align: center;">昵称</th>
                    <th style="text-align: center;">上级</th>
                    <th style="text-align: center;">余额</th>
                    <th style="text-align: center;">冻结金额</th>
                    <th style="text-align: center;">邀请码</th>
                    <th style="text-align: center;">冻结状态</th>
                </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd">
                        <td style="text-align: center;">
                            {{ $model->id }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->username }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->nickname }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->parent_id }}
                        </td>
                        <td style="text-align: center;">
                            {{ number4($account->balance) }}元
                        </td>
                        <td style="text-align: center;">
                            {{ number4($account->frozen) }}元
                        </td>
                        <td style="text-align: center;">
                            {{ $model->invite_code }}
                        </td>
                        <td style="text-align: center;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                <thead>
                <tr role="row">
                    <th style="text-align: center;">注册IP</th>
                    <th style="text-align: center;">注册时间</th>
                    <th style="text-align: center;">上次登录Ip</th>
                    <th style="text-align: center;">上次登录时间</th>

                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                    <td style="text-align: center;">
                        {{ $model->register_ip }}
                    </td>
                    <td style="text-align: center;">
                        {{ date("Y-m-d H:i:s", $model->register_time) }}
                    </td>
                    <td style="text-align: center;">
                        {{ $model->last_login_ip }}
                    </td>
                    <td style="text-align: center;">
                        {{ date("Y-m-d H:i:s", $model->last_login_time) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div>
            <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                <thead>
                <tr role="row">
                    <th style="text-align: center;">总充值</th>
                    <th style="text-align: center;">总提现</th>
                    <th style="text-align: center;">人工充值</th>
                    <th style="text-align: center;">人工扣减</th>
                    <th style="text-align: center;">发包数</th>
                    <th style="text-align: center;">发包金额</th>
                    <th style="text-align: center;">抢包数</th>
                    <th style="text-align: center;">抢包金额</th>
                    <th style="text-align: center;">免死金额</th>
                    <th style="text-align: center;">系统佣金</th>
                    <th style="text-align: center;">中雷收款</th>
                    <th style="text-align: center;">中雷付款</th>
                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                    <td style="text-align: center;">
                        {{ number4($stat->recharge ) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->withdraw) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->manual_recharge) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->manual_reduce) }}
                    </td>
                    <td style="text-align: center;">
                        {{ $stat->send_packet_count }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->send_packet_amount) }}
                    </td>
                    <td style="text-align: center;">
                        {{ $stat->fetched_packet_count }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->fetched_packet_amount) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->system_ms_amount) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->system_brokerage) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->landmine_in_amount) }}
                    </td>
                    <td style="text-align: center;">
                        {{ number4($stat->landmine_out_amount) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section("script")
    <script>
        layui.use(['form', 'element'], function(){
            var form    = layui.form;
            var element = layui.element;

        });

        $(document).ready(function () {

        });
    </script>
@endsection