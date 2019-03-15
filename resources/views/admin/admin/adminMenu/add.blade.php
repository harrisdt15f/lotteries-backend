@extends('admin.layouts.add')

@section("content")
    <form id="addForm" class="form-horizontal" action="{{url("menuAdd", [intval($parent->id), $model->id])}}">
        {{ csrf_field() }}
        <fieldset>
            <legend>添加菜单</legend>
            @if ($parent->id)
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 180px;">上级:</label>
                    <div class="layui-input-inline" style="width: 420px;">
                        <input type="text" id="parent_name" name="parent_name" value="{{$parent->title}}|{{$parent->route}}" required  lay-verify="required" placeholder="请输入上级" autocomplete="off" class="layui-input">
                    </div>
                </div>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">名称:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="title" name="title" value="{{$model->title}}" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">路由:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="route" name="route" value="{{$model->route}}" required  lay-verify="required" placeholder="请输入路由" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">图标类:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="css_class" name="css_class" value="{{$model->css_class}}" required  lay-verify="required" placeholder="请输入图标类" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">类型:</label>
                <div class="layui-input-inline">
                    <select name="type" id="type" lay-verify="required" lay-filter="room_type">
                        @foreach([0 => "菜单", 1 => "链接"] as $sign => $name)
                            <option value="{{$sign}}" @if ($model->id && $sign == $model->type) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </fieldset>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-12">
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
        $(document).ready(function () {
            $("#btn-submit").click(function () {
                var sTitle      = $("#title").val();
                if (!sTitle) {
                    _alert("对不起, 标题不能为空!");
                    return false;
                }

                var sRoute   = $("#route").val();
                if (!sRoute) {
                    _alert("对不起, 标识不能为空!");
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