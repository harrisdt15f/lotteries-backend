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
                            <label class="layui-form-label" style="width: 80px;">游戏:</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="lottery_id" id="lottery_id"  class="layui-input">
                                    <option value="all">所有游戏</option>
                                    @foreach($lotteries as $id => $name)
                                        <option value="{{$id}}" @if(isset($c['lottery_id']) && $c['lottery_id'] == $id)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">奖期号:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="issue_no" id="issue_no" class="layui-input" value="{{isset($c['issue_no']) ? $c['issue_no'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">开始时间:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="start_time" id="start_time" class="layui-input" value="{{isset($c['start_time']) ? $c['start_time'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">结束时间:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="end_time" id="end_time" class="layui-input" value="{{isset($c['end_time']) ? $c['end_time'] : ""}}">
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
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">中文名</th>
                            <th style="text-align: center;">英文标识</th>
                            <th style="text-align: center;">奖期</th>
                            <th style="text-align: center;">开始时间</th>
                            <th style="text-align: center;">结束时间</th>
                            <th style="text-align: center;">官方开奖时间</th>
                            <th style="text-align: center;">开奖号码</th>
                            <th style="text-align: center;">录号时间</th>
                            <th style="text-align: center;">是否计奖</th>
                            <th style="text-align: center;">是否派奖</th>
                            <th style="text-align: center;">是否返点</th>
                            <th style="text-align: center;">是否追号</th>
                            <th style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->lottery_name }}
                                </td>
                                <td>
                                    {{ $item->lottery_id }}
                                </td>
                                <td>
                                    {{ $item->issue }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i:s", $item->begin_time) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i:s", $item->end_time) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i:s", $item->official_open_time) }}
                                </td>
                                <td>
                                    {{ $item->official_code }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_encode)
                                    {{ date("Y-m-d H:i:s", $item->encode_time) }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if(!$item->status_calculated)
                                        <i class="fa fa-check" style="color: red;"></i>
                                    @else
                                        {{ date("Y-m-d H:i:s", $item->time_calculated) }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if(!$item->status_prize)
                                        <i class="fa fa-check" style="color: red;"></i>
                                    @else
                                        {{ date("Y-m-d H:i:s", $item->time_prize) }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if(!$item->status_commission)
                                        <i class="fa fa-check" style="color: red;"></i>
                                    @else
                                        {{ date("Y-m-d H:i:s", $item->time_commission) }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if(!$item->status_trace)
                                        <i class="fa fa-check" style="color: red;"></i>
                                    @else
                                        {{ date("Y-m-d H:i:s", $item->time_trace ) }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route("lotteryAdd",  [$item->id])}}">异常处理</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="14" style="text-align: center;">数据为空！！</td></tr>
                    @endif
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
            </div>
        </div>
    </div>

@endsection

@section("script")
    @parent
    <script>
        layui.use(['form', 'laydate'], function() {
            var form        = layui.form;
            var laydate    = layui.laydate;

            laydate.render({
                elem: '#start_time',
                type: "datetime"
            });

            laydate.render({
                elem: '#end_time',
                type: "datetime"
            });
        });

        $(document).ready(function () {
            $(".status_item").click(function () {
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

            $(".open_task").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_ref');


                layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        area: ['800px', '500px'],
                        title: "发起任务",
                        content: [sUrl, 'no'],
                        end: function () {
                            window.location.reload();
                            return true;
                        }
                    });
                });


            });
        });
    </script>
@endsection