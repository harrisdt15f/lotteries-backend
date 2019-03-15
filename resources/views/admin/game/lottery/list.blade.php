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
                    </div>
                </form>
                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">中文名</th>
                            <th style="text-align: center;">英文标识</th>
                            <th style="text-align: center;">系列</th>
                            <th style="text-align: center;">是否快彩</th>
                            <th style="text-align: center;">是否自开</th>
                            <th style="text-align: center;">每日期数</th>
                            <th style="text-align: center;">最大追号</th>
                            <th style="text-align: center;">奖金组</th>
                            <th style="text-align: center;">倍数</th>
                            <th style="text-align: center;">模式</th>
                            <th style="text-align: center;">奖期格式</th>
                            <th style="text-align: center;">添加日期</th>
                            <th style="text-align: center;">状态</th>
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
                                    {{ $item->cn_name }}
                                </td>
                                <td>
                                    {{ $item->en_name }}
                                </td>
                                <td>
                                    {{ $item->series_id }}
                                </td>

                                <td style="text-align: center;">
                                    @if($item->is_fast == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->auto_open == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->day_issue }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->max_trace_number }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->min_prize_group }} - {{ $item->max_prize_group }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->min_times }} - {{ $item->max_times }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->valid_modes }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->issue_format }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->created_at }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route("lotteryAdd",  [$item->id])}}">编辑</a>
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("lotteryStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>
                                    <a href="{{route("lotteryDel",  [$item->id])}}">删除</a>
                                    <a href="{{route("issueList") . "?lottery=" . $item->en_name}}">奖期</a>
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