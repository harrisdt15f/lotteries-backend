@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("noticeAdd", [$model->id])}}">
        {{ csrf_field() }}
        <fieldset>
            @if($model->id > 0)
                <legend><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:red;"></i> 编辑公告</legend>
            @else
                <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加公告</legend>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">公告类型:</label>
                <div class="layui-input-inline">
                    <select name="type" id="type" lay-verify="required" lay-filter="room_type">
                        @foreach($types as $sign => $name)
                            <option value="{{$sign}}" @if ($model->id && $sign == $model->type) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">标题:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="title" name="title" value="{{ $model->title }}" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">内容:</label>
                <div class="layui-input-inline" style="width: 480px;">
                    <textarea name="content" placeholder="请输入内容" class="layui-textarea">{{ $model->content }}</textarea>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">开始时间:</label>
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" id="start_time" name="start_time" value="{{ $model->start_time }}" required  lay-verify="required" placeholder="请输入开始时间" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">结束时间:</label>
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" id="end_time" name="end_time" value="{{ $model->end_time }}" required  lay-verify="required" placeholder="请输入结束时间" autocomplete="off" class="layui-input">
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
        layui.use(['form', 'slider', 'laydate', ], function(){
            var form        = layui.form;
            var laydate     = layui.laydate;

            laydate.render({
                elem: '#start_time',
                type: "datetime"
            });

            laydate.render({
                elem: '#end_time',
                type: "datetime"
            });

        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
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