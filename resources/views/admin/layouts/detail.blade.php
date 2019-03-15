<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>时代娱乐后台</title>

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production-plugins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-rtl.min.css') }}">

    <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
</head>
<body>
    <div id="main" role="main">
        <div id="ribbon">
            <span class="ribbon-button-alignment">
                <span id="refresh" class="btn btn-ribbon" data-html="true"><i class="fa fa-home"></i></span>
            </span>
            <ol class="breadcrumb">
                <li><a href="http://a.smart.me">Home</a></li><li>Widgets</li>
            </ol>
        </div>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section id="widget-grid" class="">
                        <div class="row">
                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
                                @yield('content')
                            </article>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/layui/layui.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @section('script')
    @show
</body>
</html>
