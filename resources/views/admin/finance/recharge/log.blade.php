@extends('admin.layouts.add_ajax')
@section("content")
    <div role="content">
        <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                <tbody>
                <tr>
                    <td>发起人</td>
                    <td>金额</td>
                    <td>发起IP</td>
                    <td>发起时间</td>
                    <td>状态</td>
                    <td>原因</td>
                </tr>
                <tr>
                    <td>{{ $item->username }}</td>
                    <td>{{ number4($item->amount) }}</td>
                    <td>{{ $item->ip }}</td>
                    <td>{{ date("Y-m-d H:i:s", $item->request_time) }}</td>
                    <td>{{ $item->request_status }}</td>
                    <td>{{ $item->request_reason }}</td>
                </tr>
                    <tr>
                        <td colspan="6">发起参数</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                                <thead>
                                <tr role="row">
                                    @foreach (json_decode($item->request_params, true) as $key => $value)
                                        <th style="text-align: center;">{{$key}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row">
                                    @foreach (json_decode($item->request_params, true) as $key => $value)
                                        <th style="text-align: center;">{{$value}}</th>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <tr>
                    <td colspan="6">发起返回</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                            <thead>
                            <tr role="row">
                                @foreach (json_decode($item->request_back, true) as $key => $value)
                                    <th style="text-align: center;">{{$key}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row">
                                @foreach (json_decode($item->request_back, true) as $key => $value)
                                    <th style="text-align: center;">
                                        @if(is_array($value))
                                            {{json_encode($value)}}
                                        @else
                                            {{$value}}
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
            <tbody>
            <tr>
                <td>回调P</td>
                <td>回调时间</td>
                <td>回调状态</td>
                <td>回调原因</td>
            </tr>
            <tr>
                <td>{{ $item->back_ip }}</td>
                <td>
                    @if($item->back_time)
                         {{ date("Y-m-d H:i:s", $item->back_time) }}
                    @endif
                </td>
                <td>{{ $item->back_status }}</td>
                <td>{{ $item->back_reason }}</td>
            </tr>
            @if($item->content)
                <tr>
                    <td colspan="4">回调参数</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                            <thead>
                            <tr role="row">
                                @foreach (json_decode($item->content, true) as $key => $value)
                                    <th style="text-align: center;">{{$key}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row">
                                @foreach (json_decode($item->content, true) as $key => $value)
                                    <th style="text-align: center;">{{$value}}</th>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection

@section("script")
    <script>
        layui.use(['form', 'laydate'], function(){
            var form        = layui.form;
            var laydate    = layui.laydate;
            laydate.render({
                elem: '#register_time',
                type: "datetime"
            });
        });
    </script>
@endsection