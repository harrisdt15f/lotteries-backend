<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>时代娱乐后台</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production-plugins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-rtl.min.css') }}">

    <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('smart/js/libs/jquery-2.1.1.min.js ') }}"></script>
</head>
<body>
@include('admin.layouts.frame.left')
<div style="padding-left: 220px;">
    <iframe frameborder="0" width="100%" height="960px" name="mainFrame" id="mainFrame" src="{{ route("home") }}">1</iframe>
    <script>

        var browserVersion = window.navigator.userAgent.toUpperCase();
        var isOpera = browserVersion.indexOf("OPERA") > -1 ? true : false;
        var isFireFox = browserVersion.indexOf("FIREFOX") > -1 ? true : false;
        var isChrome = browserVersion.indexOf("CHROME") > -1 ? true : false;
        var isSafari = browserVersion.indexOf("SAFARI") > -1 ? true : false;
        var isIE = (!!window.ActiveXObject || "ActiveXObject" in window);
        var isIE9More = (! -[1,] == false);
        function reinitIframe(iframeId, minHeight) {
            try {
                var iframe = document.getElementById(iframeId);
                var bHeight = 0;
                if (isChrome == false && isSafari == false) {
                    try {
                        bHeight = iframe.contentWindow.document.body.scrollHeight;
                    } catch (ex) {
                    }
                }
                var dHeight = 0;
                if (isFireFox == true)
                    dHeight = iframe.contentWindow.document.documentElement.offsetHeight;//如果火狐浏览器高度不断增加删除+2
                else if (isIE == false && isOpera == false && iframe.contentWindow) {
                    try {
                        dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
                    } catch (ex) {
                    }
                }
                else if (isIE == true && isIE9More) {//ie9+
                    var heightDeviation = bHeight - eval("window.IE9MoreRealHeight" + iframeId);
                    if (heightDeviation == 0) {
                        bHeight += 3;
                    } else if (heightDeviation != 3) {
                        eval("window.IE9MoreRealHeight" + iframeId + "=" + bHeight);
                        bHeight += 3;
                    }
                }
                else//ie[6-8]、OPERA
                    bHeight += 3;

                var height = Math.max(bHeight, dHeight);
                if (height < minHeight) height = minHeight;
                //alert(iframe.contentWindow.document.body.scrollHeight + "~" + iframe.contentWindow.document.documentElement.scrollHeight);
                iframe.style.height = height + "px";
            } catch (ex) { }
        }

        function startInit(iframeId, minHeight) {
            eval("window.IE9MoreRealHeight" + iframeId + "=0");
            window.setInterval("reinitIframe('" + iframeId + "'," + minHeight + ")", 1000);
        }

        startInit('mainFrame', 960);

    </script>
</div>
<script src="{{ asset('smart/js/app.config.js') }}"></script>
<script src="{{ asset('js/layui/layui.js') }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>
</html>
