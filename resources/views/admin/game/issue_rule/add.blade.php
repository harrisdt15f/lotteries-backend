@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("issueRuleAdd", [$model->id])}}">
        {{ csrf_field() }}
        <fieldset>
            @if($model->id > 0)
                <legend><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:red;"></i> 编辑奖期规则</legend>
            @else
                <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加奖期规则</legend>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label">游戏:</label>
                <div class="layui-input-inline">
                    <select name="lottery_name" id="lottery_name" lay-verify="required" lay-filter="merchant_sign">
                        @foreach($lotteries as $sign => $name)
                            <option value="{{$sign}}" @if ($model->id && $sign == $model->lottery_name) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">开始时间:</label>
                <div class="layui-input-inline">
                    <input type="text" id="start_time" name="start_time" value="{{$model->start_time}}" required  lay-verify="required" placeholder="开始时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">结束时间:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="end_time" name="end_time" value="{{$model->end_time}}" required  lay-verify="required" placeholder="结束时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">第一期时间:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="first_time" name="first_time" value="{{$model->first_time}}" required  lay-verify="required" placeholder="第一期时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">每期秒数:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="issue_seconds" name="issue_seconds" value="{{$model->issue_seconds}}" required  lay-verify="required" placeholder="每期秒数" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">截单时间:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="adjust_time" name="adjust_time" value="{{$model->adjust_time}}" required  lay-verify="required" placeholder="截单时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">录号时间:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="encode_time" name="encode_time" value="{{$model->encode_time}}" required  lay-verify="required" placeholder="录号时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">每日期数:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="issue_count" name="issue_count" value="{{$model->issue_count}}" required  lay-verify="required" placeholder="每日期数" autocomplete="off" class="layui-input">
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
        layui.use(['form', 'date'], function(){
            var form = layui.form;
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sLottery        = $("#lottery_name").val();
                if (!sLottery) {
                    _alert("彩种不能为空!!!");
                    return false;
                }

                var sStartTime      = $("#start_time").val();
                if (!sStartTime) {
                    _alert("开始时间不能为空!!!");
                    return false;
                }

                var sEndTime        = $("#end_time").val();
                if (!sEndTime) {
                    _alert("结束时间不能为空!!!");
                    return false;
                }

                var sIssueSeconds   = $("#issue_seconds").val();
                if (!sIssueSeconds) {
                    _alert("每期时间不能为空!!!");
                    return false;
                }

                var sAdjustTime     = $("#adjust_time").val();
                if (!sAdjustTime) {
                    _alert("截单时间不能为空!!!");
                    return false;
                }

                var sEncodeTime     = $("#encode_time").val();
                if (sEncodeTime == undefined) {
                    _alert("录好不能为空!!!");
                    return false;
                }

                var sIssueCount     = $("#issue_count").val();
                if (!sIssueCount == undefined) {
                    _alert("奖期数不能为空!!!");
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