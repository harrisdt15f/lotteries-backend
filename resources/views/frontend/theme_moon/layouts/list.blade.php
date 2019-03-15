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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="main" role="main">
        <div id="ribbon">
            <span class="ribbon-button-alignment">
                <span id="refresh" class="btn btn-ribbon" data-html="true"><i class="fa fa-home"></i></span>
            </span>
            <ol class="breadcrumb">
                <li><a href="{{route("frame")}}"></a></li>
                @foreach ($breadcrumb as $index => $item)
                    @if($item['route'])
                        <li><a href="{{route($item['route'])}}">{{$item['title']}}</a></li>
                    @else
                        <li>{{$item['title']}}</li>
                    @endif
                @endforeach
            </ol>
        </div>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section id="widget-grid" class="">
                        <div class="row">
                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
                                <div class="jarviswidget jarviswidget-color-blueLight jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget">
                                    <header role="heading">
                                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                        <h2>{{$listTitle}}</h2>
                                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                                        <div class="text-align-right">
                                            @include("admin.layouts.element_buttons")
                                        </div>
                                        &nbsp;
                                        &nbsp;
                                    </header>

                                    @yield('content')
                                </div>
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
