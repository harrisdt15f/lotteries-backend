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
                        <th style="text-align: center;">平台</th>
                        <th style="text-align: center;">用户名</th>
                        <th style="text-align: center;">彩种</th>
                        <th style="text-align: center;">玩法</th>
                        <th style="text-align: center;">奖金组</th>
                        <th style="text-align: center;">投注奖金组</th>
                        <th style="text-align: center;">模式</th>
                        <th style="text-align: center;">倍数</th>
                        <th style="text-align: center;">总金额</th>
                        <th style="text-align: center;">返点</th>
                        <th style="text-align: center;">是否中奖</th>
                        <th style="text-align: center;">奖金</th>
                        <th style="text-align: center;">录号</th>
                        <th style="text-align: center;">计奖</th>
                        <th style="text-align: center;">派奖</th>
                        <th style="text-align: center;">返点</th>
                        <th style="text-align: center;">追号</th>
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
                                <td style="text-align: center;">
                                    {{ $item->sign }}
                                </td>
                                <td>
                                    {{ $item->username }}
                                </td>
                                <td>
                                    {{ $item->lottery_id }}
                                </td>
                                <td>
                                    {{ $item->method_name }}
                                </td>
                                <td>
                                    {{ $item->user_prize_group }}
                                </td>
                                <td>
                                    {{ $item->bet_prize_group }}
                                </td>
                                <td>
                                    {{ $item->mode }}
                                </td>
                                <td>
                                    {{ $item->times }}
                                </td>
                                <td>
                                    {{ $item->total_price }}
                                </td>
                                <td>
                                    {{ $item->point }}
                                </td>
                                <td>
                                    {{ $item->is_win }}
                                </td>
                                <td>
                                    {{ $item->bonus }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_input == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_count == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_prize == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_point == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status_trace == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("lotteryStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a>详情</a>
                                    <a>计奖</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="20" style="text-align: center;">数据为空！！</td></tr>
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
        });
    </script>
@endsection