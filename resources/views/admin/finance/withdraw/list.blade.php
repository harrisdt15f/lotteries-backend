@extends('admin.layouts.list')
@section("content")
    <div role="content">
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
                            <label class="layui-form-label" style="width: 80px;">状态:</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="status" id="status"  class="layui-input">
                                    @foreach(\App\Models\Finance\Withdraw::$status as $id => $name)
                                        <option value="{{$id}}" @if(isset($c['status']) && $c['status'] == $id)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">请求日期:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="init_time" id="init_time" class="layui-input" value="{{isset($c['init_time']) ? $c['init_time'] : ""}}">
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
                            <th style="text-align: center;">真实金额</th>
                            <th style="text-align: center;">银行卡号</th>
                            <th style="text-align: center;">IP</th>
                            <th style="text-align: center;">时间</th>
                            <th style="text-align: center;">状态</th>
                            <th style="text-align: center;">操作</th>
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
                                    {{ number4($item->real_amount) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->card_number }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->client_ip }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->created_at }}
                                </td>
                                <td style="text-align: center;">
                                    <span>
                                        @if ($item->status == 1)
                                            <span style="color:black;">已领取</span>
                                        @elseif ($item->status == -2)
                                            <span style="color:red;">审核失败</span>
                                        @elseif ($item->status == -3)
                                            <span style="color:red;">代发失败</span>
                                        @elseif ($item->status == -4)
                                            <span style="color:red;">回调失败</span>
                                        @elseif ($item->status == -5)
                                            <span style="color:red;">人工失败</span>
                                        @elseif ($item->status == 2)
                                            <span style="color:green;">审核成功</span>
                                        @elseif ($item->status == 3)
                                            <span style="color:green;">代发成功</span>
                                        @elseif ($item->status == 4)
                                            <span style="color:green;">回调成功</span>
                                        @elseif ($item->status == 5)
                                            <span style="color:green;">人工成功</span>
                                        @else
                                            <span>充值中</span>
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    @if(in_array($item->status, [0, 1, 2, 3, -2, -3]))
                                        <a href="{{ route("withdrawHand", [$item->id]) }}">人工</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="8" style="text-align: center;">数据为空！！</td></tr>
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
    </script>
@endsection