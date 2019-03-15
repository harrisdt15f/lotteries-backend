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
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">彩种</th>
                            <th style="text-align: center;">玩法</th>
                            <th style="text-align: center;">奖金组</th>
                            <th style="text-align: center;">投注奖金组</th>
                            <th style="text-align: center;">模式</th>
                            <th style="text-align: center;">倍数</th>
                            <th style="text-align: center;">总金额</th>
                            <th style="text-align: center;">总期数</th>
                            <th style="text-align: center;">开始期数</th>
                            <th style="text-align: center;">当前期数</th>
                            <th style="text-align: center;">总金额</th>
                            <th style="text-align: center;">完成金额</th>
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
                                    {{ $item->total_issues }}
                                </td>
                                <td>
                                    {{ $item->start_issue }}
                                </td>
                                <td>
                                    {{ $item->now_issue }}
                                </td>
                                <td>
                                    {{ $item->total_price }}
                                </td>
                                <td>
                                    {{ $item->finished_amount }}
                                </td>

                                <td style="text-align: center;">
                                    @if($item->status == 2)
                                        <span style="color: green;">已完成</span>(@if($item->finished_status == 2) 异常停止 @elseif($item->finished_status == 2) 中奖停止  @else 正常停止 @endif
                                    @elseif($item->status == 1)
                                        <span style="color: greenyellow;">进行中</span>
                                    @else
                                        <span style="color: grey;">未开始</span>
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
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="16" style="text-align: center;">数据为空！！</td></tr>
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