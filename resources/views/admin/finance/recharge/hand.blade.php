@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("rechargeHand", [$model->id])}}">
        {{ csrf_field() }}
        <fieldset>
            <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 充值 - 人工处理</legend>

            <div class="layui-form-item">
                <table  lay-even lay-skin="line" class="layui-table" width="100%">
                    <thead>
                    <tr role="row">
                        <th style="text-align: center;">用户名</th>
                        <th style="text-align: center;">订单号</th>
                        <th style="text-align: center;">金额</th>
                        <th style="text-align: center;">实际上分</th>
                        <th style="text-align: center;">附言</th>
                        <th style="text-align: center;">来源</th>
                        <th style="text-align: center;">ip</th>
                        <th style="text-align: center;">提交时间</th>
                        <th style="text-align: center;">回调时间</th>
                        <th style="text-align: center;">管理员</th>
                        <th style="text-align: center;">状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center;">
                            {{ $model->username }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->order_id }}
                        </td>
                        <td style="text-align: center;">
                            {{ number4($model->amount) }}
                        </td>
                        <td style="text-align: center;">
                            {{ number4($model->real_amount) }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->sign }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->source }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->client_ip }}
                        </td>
                        <td style="text-align: center;">
                            {{ date("Y-m-d H:i:s", $model->init_time) }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->callback_time ? date("Y-m-d H:i:s", $model->callback_time) : "--" }}
                        </td>
                        <td style="text-align: center;">
                            {{ $model->admin_id }}
                        </td>
                        <td style="text-align: center;">
                            <span>
                                @if ($model->status == -1)
                                    <span style="color:red;">请求失败</span><a reason="{{$model->fail_reason}}" href="javascript:void(0)">原因</a>
                                @elseif ($model->status == -2)
                                    <span style="color:red;">回调失败</span><a reason="{{$model->fail_reason}}" href="javascript:void(0)">原因</a>
                                @elseif ($model->status == -3)
                                    <span style="color:red;">人工失败</span><a reason="{{$model->fail_reason}}" href="javascript:void(0)">原因</a>
                                @elseif ($model->status == 2)
                                    <span style="color:green;">充值成功</span>
                                @elseif ($model->status == 3)
                                    <span style="color:green;">人工成功</span>
                                @else
                                    <span>充值中</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">结果:</label>
                <div class="layui-input-inline">
                    <select name="type" id="type" lay-verify="required" lay-filter="merchant_sign">
                        @foreach(\App\Models\Finance\Recharge::$handType as $sign => $name)
                            <option value="{{$sign}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">金额:</label>
                <div class="layui-input-inline">
                    <input type="text" id="amount" name="amount" value="{{ number4($model->amount)}}" required  lay-verify="required" placeholder="请输入金额" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">金额:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="reason" name="reason" value="" required  lay-verify="required" placeholder="请输入原因" autocomplete="off" class="layui-input">
                </div>
            </div>

        </fieldset>
        <div  class="layui-form-item">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <button class="btn btn-primary" id="btn-submit" type="button">
                        <i class="fa fa-save"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section("script")
    <script>
        layui.use(['form', 'table'], function(){
            var form    = layui.form;
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var iAmount   = $("#amount").val();
                if (!iAmount) {
                    _alert("对不起, 资金不能为空!");
                    return false;
                }

                var sReason  = $("#reason").val();
                if (!sReason) {
                    _alert("对不起, 原因不能为空!!!");
                    return false;
                }

                var sUrl = $("#addForm").attr('action');
                $.post(sUrl, $("#addForm").serialize(), function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            location.href = data.data.url;
                        } else {
                            _alert(data.msg);
                        }
                    }
                }, 'JSON');

            });
        });
    </script>
@endsection