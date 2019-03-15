@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("partnerUserAdd")}}">
        {{ csrf_field() }}
        <fieldset>
            @if($model->id > 0)
                <legend><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:red;"></i> 编辑游戏</legend>
            @else
                <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加游戏</legend>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label">Theme:</label>
                <div class="layui-input-inline">
                    <select name="series_id" id="series_id" lay-verify="required" lay-filter="merchant_sign">
                        @foreach($theme as $sign => $name)
                            <option value="{{$sign}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">用户名:</label>
                <div class="layui-input-inline">
                    <input type="text" id="cn_name" name="cn_name" value="{{$model->cn_name}}" required  lay-verify="required" placeholder="请输入中文名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">英文名:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="en_name" name="en_name" value="{{$model->en_name}}" required  lay-verify="required" placeholder="请输入英文名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">奖期格式:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="issue_format" name="issue_format" value="{{$model->issue_format}}" required  lay-verify="required" placeholder="奖期格式" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">最大奖期:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="max_trace_number" name="max_trace_number" value="{{$model->max_trace_number}}" required  lay-verify="required" placeholder="最大奖期" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否快彩</label>
                <div class="layui-input-inline">
                    <input type="checkbox" id="is_fast" name="is_fast" lay-skin="switch" lay-text="ON|OFF" value="1" checked>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否自开</label>
                <div class="layui-input-inline">
                    <input type="checkbox" id="auto_open" name="auto_open" lay-skin="switch" lay-text="ON|OFF" value="1" checked>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">每日期数:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="day_issue" name="day_issue" value="{{$model->day_issue}}" required  lay-verify="required" placeholder="每日期数" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">允许号码:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="text" id="valid_code" name="valid_code" value="{{$model->valid_code}}" required  lay-verify="required" placeholder="允许号码, 逗号隔开" autocomplete="off" class="layui-input">
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
        layui.use(['form', 'slider'], function(){
            var form    = layui.form;
            var slider  = layui.slider;
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sSeriesId   = $("#series_id").val();
                if (!sSeriesId) {
                    _alert("系列ID不能为空!!!");
                    return false;
                }

                var sCnName  = $("#cn_name").val();
                if (!sCnName) {
                    _alert("中文名称不能为空!!!");
                    return false;
                }

                var sEnName     = $("#en_name").val();
                if (!sEnName) {
                    _alert("英文名称不能为空!!!");
                    return false;
                }

                var iMaxTraceNumber     = $("#max_trace_number").val();
                if (!iMaxTraceNumber) {
                    _alert("最大追号不能为空!!!");
                    return false;
                }

                var sIssueFormat     = $("#issue_format").val();
                if (!sIssueFormat) {
                    _alert("奖期格式不能为空!!!");
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