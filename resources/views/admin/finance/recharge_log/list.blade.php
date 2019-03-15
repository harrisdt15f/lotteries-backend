@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id="searchForm" action="{{ $currentUrl }}">
                    <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    <div class="layui-form-item" style="padding-top:5px; ">
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label"  style="width: 80px;">用户名:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="username" id="username" class="layui-input" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>

                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label"  style="width: 80px;">订单号:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="order_id" id="order_id" class="layui-input" value="{{isset($c['order_id']) ? $c['order_id'] : ""}}">
                            </div>
                        </div>

                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label" style="width: 80px;">回调状态:</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="status" id="status"  class="layui-input">
                                    @foreach(\App\Models\Finance\Recharge::$status as $id => $name)
                                        <option value="{{$id}}" @if(isset($c['status']) && $c['status'] == $id)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-inline">
                            <div class="col-xs-12 col-md-6">
                                <button class="btn btn-primary" id="btn-submit" type="submit">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">订单号</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">发起ip</th>
                            <th style="text-align: center;">发起时间</th>
                            <th style="text-align: center;">发起参数</th>
                            <th style="text-align: center;">发起返回</th>
                            <th style="text-align: center;">发起状态</th>
                            <th style="text-align: center;">回调ip</th>
                            <th style="text-align: center;">回调时间</th>
                            <th style="text-align: center;">回调内容</th>
                            <th style="text-align: center;">回调状态</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->username }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->order_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->amount) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->ip }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i:s", $item->request_time) }}
                                </td>
                                <td style="text-align: center;">
                                    <a class="params_detail" _content="{{ $item->request_params }}" href="javascript:void(0)">详情</a>
                                </td>
                                <td style="text-align: center;">
                                    <a class="request_back_detail" _content="{{ $item->request_back }}" href="javascript:void(0)">详情</a>
                                </td>
                                <td style="text-align: center;">
                                    @if ($item->request_status == 1)
                                        <span style="color:green;">成功</span>
                                    @elseif ($item->request_status == 2)
                                        <span style="color:red;">失败</span>
                                    @else

                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->back_ip }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i:s", $item->back_time) }}
                                </td>
                                <td style="text-align: center;">
                                    <a class="params_detail" _content="{{ $item->content }}" href="javascript:void(0)">详情</a>
                                </td>
                                <td style="text-align: center;">
                                    @if ($item->back_status == 1)
                                        <span style="color:green;">成功</span>
                                    @elseif ($item->back_status == 2)
                                        <span style="color:red;">失败</span>
                                    @else

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="11" style="text-align: center;">数据为空！！</td></tr>
                    @endif
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
            </div>
        </div>
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

        $(".log-btn").click(function () {
            var _self   = $(this);
            var sUrl    = _self.attr('_url');

            layui.use('layer', function() {
                layer.open({
                    type: 2,
                    offset      : "120px",
                    area: ['920px', '600px'],
                    title: "详情",
                    content: [sUrl, 'no'],
                    end: function () {
                        return true;
                    }
                });
            });
        });
    </script>
@endsection