@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form style="display: none;" id="searchForm" action="{{ $currentUrl }}">
                    <div class="dt-toolbar">
                        <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    </div>
                </form>
                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">名称</th>
                            <th style="text-align: center;">标识</th>
                            <th style="text-align: center;">类型</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">用户</th>
                            <th style="text-align: center;">游戏</th>
                            <th style="text-align: center;">玩法</th>
                            <th style="text-align: center;">订单ID</th>
                            <th style="text-align: center;">奖期</th>
                            <th style="text-align: center;">来源</th>
                            <th style="text-align: center;">来源(管理)</th>
                            <th style="text-align: center;">冻结类型</th>
                            <th style="text-align: center;">活动</th>
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
                                    {{ $item->name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->sign }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->type == 1)
                                        <span style="color: green;">增加</span>
                                    @else
                                        <span style="color: red;">减少</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->amount == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->user_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->lottery_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->method_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    @if($item->project_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->issue == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->from_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->from_admin_id == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->frozen_type }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->activity_sign == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route("accountChangeTypeAdd",  [$item->id])}}">编辑</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="15" style="text-align: center;">数据为空！！</td></tr>
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