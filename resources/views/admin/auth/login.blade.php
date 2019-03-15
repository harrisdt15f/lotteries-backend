@extends('admin.layouts.auth')

@section('content')

    <div class="fly-panel fly-panel-user" pad20="">
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title">
                <li class="layui-this">登入</li>
            </ul>
            <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form layui-form-pane">
                        <form method="post" id="login-form" action="{{route("login")}}">
                            <div class="layui-form-item">
                                <label for="email" class="layui-form-label">注册邮箱</label>
                                <div class="layui-input-inline">
                                    <input id="email" name="email" required="" lay-verify="required" autocomplete="off" class="layui-input" type="text">
                                </div>
                                <div class="layui-form-mid layui-word-aux"> 使用注册的邮箱 </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="password" class="layui-form-label">用户密码</label>
                                <div class="layui-input-inline">
                                    <input id="password" name="password" required="" lay-verify="required" autocomplete="off" class="layui-input" type="password">
                                </div>
                                <a id="fetch_code" class="layui-btn  layui-btn-normal"  _url="{{route("tCode")}}">获取安全码</a>
                            </div>
                            <div class="layui-form-item">
                                <label for="t_code" class="layui-form-label">安全码</label>
                                <div class="layui-input-inline"> <input id="t_code" name="t_code" placeholder="请输入安全码!!" autocomplete="off" class="layui-input" type="text"> </div>
                                <div class="layui-form-mid">
                                    <span style="color: #c00;"></span>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <a class="layui-btn" lay-filter="*" id="btn-submit">立即登录</a>
                                <span style="padding-left:20px;">
                                    <a href="javascript:;" onclick="alert('请联系销售人员！！')">忘记密码？</a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#fetch_code").click(function () {
                var sEmail      = $("#email").val();
                if (!sEmail) {
                    _alert("对不起,请输入Email!");
                    return false;
                }

                var sPassword   = $("#password").val();
                if (!sPassword) {
                    _alert("对不起,请输入密码!");
                    return false;
                }

                var self    = $(this);
                var sUrl    = self.attr('_url');
                $.post(sUrl, $("#login-form"). serialize(), function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            _alert(data.msg);
                        } else {
                            _alert(data.msg);
                        }
                    }
                }, 'JSON');
            });

            $("#btn-submit").click(function () {
                var sEmail      = $("#email").val();
                if (!sEmail) {
                    _alert("{{ __("view.auth.login.error.email.empty") }}");
                    return false;
                }

                var sPassword   = $("#password").val();
                if (!sPassword) {
                    _alert("{{ __("view.auth.login.error.password.empty") }}");
                    return false;
                }

                var sUrl = $("#login-form").attr('action');
                $.post(sUrl, $("#login-form"). serialize(), function (data, status) {
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