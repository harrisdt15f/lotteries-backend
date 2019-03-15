@extends('admin.layouts.add')

@section("content")
    <form id="addForm" class="form-horizontal" action="{{route("adminUserAdd", [$user->id])}}">
        {{ csrf_field() }}
        <fieldset>
            @if($user->id > 0)
                <legend><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:red;"></i> 编辑管理员</legend>
            @else
                <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加管理员</legend>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">用户组:</label>
                <div class="layui-input-inline">
                    <select name="group_id" id="group_id" lay-verify="required" lay-filter="group_id">
                        @foreach($groupList as $gid => $item)
                            <option value="{{$gid}}" @if ($user->id && $gid == $user->group_id) selected @endif>{{$item['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">用户名称:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="username" name="username" value="{{$user->username}}" required  lay-verify="required" placeholder="请输入用户名称" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">用户邮箱:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="email" name="email" value="{{$user->email}}" required  lay-verify="required" placeholder="请输入用户邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            @if (!$user->id)
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 180px;">用户密码:</label>
                    <div class="layui-input-inline" style="width: 220px;">
                        <input type="text" id="password" name="password" value="{{$user->username}}" required  lay-verify="required" placeholder="请输入用户密码" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 180px;">资金密码:</label>
                    <div class="layui-input-inline" style="width: 220px;">
                        <input type="text" id="fund_password" name="fund_password" value="{{$user->fund_password}}" required  lay-verify="required" placeholder="请输入资金密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
            @endif

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
        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sUsername      = $("#username").val();
                if (!sUsername) {
                    _alert("对不起,用户名不能为空!");
                    return false;
                }

                var sEmail   = $("#email").val();
                if (!sEmail) {
                    _alert("对不起,邮箱不能为空!");
                    return false;
                }

                var sPassword   = $("#password").val();
                if (!sPassword) {
                    _alert("对不起,密码不能为空!");
                    return false;
                }

                var fundPassword   = $("#fund_password").val();
                if (!fundPassword) {
                    _alert("对不起,资金密码不能为空!");
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