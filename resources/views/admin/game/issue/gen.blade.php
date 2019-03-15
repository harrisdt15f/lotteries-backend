@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("issueGen")}}">
        {{ csrf_field() }}
        <fieldset>

            <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 生成奖期</legend>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">系列:</label>
                <div class="layui-input-inline">
                    <select name="lottery_id" id="lottery_id" lay-verify="required" lay-filter="lottery_id">
                        @foreach($lotteries as $ign => $lottery)
                            <option _startDay="{{$lottery['start_day']}}" _type="{{$lottery['issue_type']}}" _lastIssue="{{$lottery['last_issue']}}" value="{{$ign}}">{{$lottery['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">开始时间:</label>
                <div class="layui-input-inline"  style="width: 300px;">
                    <input type="text" id="start_time" name="start_time" value="" required  lay-verify="required" placeholder="请输入开始时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">结束时间:</label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="end_time" name="end_time" value="" required  lay-verify="required" placeholder="请输入结束时间" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" id="start_issue_wapper">
                <label class="layui-form-label" style="width: 120px;">开始奖期:</label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="start_issue" name="start_issue" value="" required  lay-verify="required" placeholder="请输入开始奖期" autocomplete="off" class="layui-input">
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
        layui.use(['form', 'laydate'], function(){
            var form = layui.form;
            var laydate = layui.laydate;

            form.on('select(lottery_id)', function(data){

                var $option = $(data.elem[data.elem.selectedIndex]);

                var type        =   $option.attr('_type');
                var startDay    =   $option.attr('_startDay');

                laydate.render({
                    elem: '#start_time',
                    value: startDay
                });

                laydate.render({
                    elem: '#end_time',
                });

                if (type == 'day') {
                    $("#start_issue_wapper").hide();
                } else {
                    $("#start_issue_wapper").show();
                }
            });

            $("#lottery_id").trigger('change');
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sLotteryId   = $("#lottery_id").val();
                if (!sLotteryId) {
                    _alert("彩种不能为空!!!");
                    return false;
                }

                var sStartTime  = $("#start_time").val();
                if (!sStartTime) {
                    _alert("开始时间不能为空!!!");
                    return false;
                }

                var sEndTime     = $("#end_time").val();
                if (!sEndTime) {
                    _alert("结束时间不能为空!!!");
                    return false;
                }

                var sUrl = $("#addForm").attr('action');
                $.post(sUrl, $("#addForm").serialize(), function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            location.href = data.data.url;
                        } else {
                            if (data.data) {
                                var sHtml = "";
                                $.each(data.data, function (i, v) {
                                    console.log(v);
                                });
                                _alert(data.msg);
                            } else {
                                _alert(data.msg);
                            }

                        }
                    }
                }, 'JSON');

            });
        });
    </script>
@endsection