@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("playerAdd")}}">
        {{ csrf_field() }}
        <fieldset>
            <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加总代</legend>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">主题:</label>
                <div class="layui-input-inline">
                    <select name="theme" id="theme" lay-verify="required" lay-filter="merchant_sign">
                        @foreach($themeList as $sign => $name)
                            <option value="{{$sign}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">用户名:</label>
                <div class="layui-input-inline">
                    <input type="text" id="username" name="username" value="" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">密码:</label>
                <div class="layui-input-inline" style="width: 260px;">
                    <input type="password" id="password" name="password" value="" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px;">是否测试:</label>
                <div class="layui-input-inline">
                    <input type="checkbox" id="is_tester" name="is_tester" lay-skin="switch" lay-text="ON|OFF" value="1">
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
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sUsername   = $("#username").val();
                if (!sUsername) {
                    _alert("用户名不能为空!!!");
                    return false;
                }

                var sPassword  = $("#password").val();
                if (!sPassword) {
                    _alert("密码不能为空!!!");
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