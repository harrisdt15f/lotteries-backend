@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                    <tr role="row">
                        <th style="text-align: center;">名称</th>
                        <th style="text-align: center;">key</th>
                        <th style="text-align: center;">过期时间</th>
                        <th style="text-align: center;">数据</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($data) > 0)
                        @foreach($data as $key =>  $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item['name'] }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item['key'] }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item['expire_time'] == 0)
                                        永久
                                    @else
                                        {{ $item['expire_time'] }}秒
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if (count($item['data']) > 0)
                                        共<span style="color: red;">{{count($item['data'])}}</span>条记录 <a class="button-blue" _data="{{json_encode($item['data'])}}">详情</a>
                                    @else
                                        暂无缓存
                                    @endif

                                </td>
                                <td style="text-align: center;">
                                    <a class="cache_item" href="javascript:void(0)" ref="{{route("cacheFlush", [$key])}}">清理缓存</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="10" style="text-align: center;">数据为空！！</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section("script")
    @parent
    <script>
        layui.use('element', function(){
            var element = layui.element;
        });
        
        $(document).ready(function () {
            $(".cache_item").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('ref');

                $.get(sUrl, [], function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            window.location.reload();
                        }
                        _alert(data.msg);
                    }
                }, 'JSON');
            });
        });
    </script>
@endsection
