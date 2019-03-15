<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>时代娱乐 - 后台管理</title>

    <!-- Styles -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

</head>
<body>
<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" style="font-size: 28px; color: #009688;" href="/">时代娱乐</a>
        <ul class="layui-nav fly-nav layui-hide-xs"  lay-filter="">
            <li class="layui-nav-item"> <a href="javascript:;" onclick="alert('敬请期待!');"><i class="iconfont icon-jiaoliu"></i>交流</a> </li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="iconfont icon-chanpin" style="top: 1px;"></i>文档<span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="/doc/admin">操作文档</a></dd>
                    <dd><a href="/doc/api">接入文档</a></dd>
                </dl>
            </li>
            <span class="layui-nav-bar" style="left: 0px; top: 55px; width: 0px; opacity: 0;"></span>
        </ul>
    </div>
</div>
<div class="layui-container fly-marginTop">
    @yield('content')
</div>
<div class="fly-footer">
    <p>
        <a href="{{route("login")}}">时代娱乐</a> 2018 ©
        <a href="{{route('frame')}}">{{route("frame")}}</a>
    </p>
    <p>
        <a href="/doc/api"      target="_blank">接入说明</a>
        <a href="/doc/example"  target="_blank">案例</a>
        <a href="/doc/wechat"   target="_blank">微信公众号</a>
    </p>
</div>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/layui/layui.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        layui.use('element', function(){
            var element = layui.element;
        });
    </script>
    @yield('script')
</body>
</html>
