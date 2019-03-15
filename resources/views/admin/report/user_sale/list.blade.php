@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id="searchForm" action="{{ $currentUrl }}">
                    <div class="dt-toolbar">
                        <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    </div>
                    <div class="dt-toolbar col-md-12">
                        <div class="form-group  col-md-3">
                            <label class="col-md-5 control-label">{{__("user_sale.search.username")}}:</label>
                            <div class="col-md-2">
                                <input name="username" id="username" class="form-control" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="col-md-5 control-label">{{__("user_sale.search.start_day")}}:</label>
                            <div class="col-md-2">
                                <input name="start_day" id="start_day" class="form-control" value="{{isset($c['start_day']) ? $c['start_day'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-lg-3">
                            <label class="col-md-6 control-label">{{__("user_sale.search.end_day")}}:</label>
                            <div class="col-md-4">
                                <input name="end_day" id="end_day" class="form-control" value="{{isset($c['end_day']) ? $c['end_day'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-md-2">
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
                            <th style="text-align: center;">日期</th>
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">游戏</th>
                            <th style="text-align: center;">玩法</th>
                            <th style="text-align: center;">投注额</th>
                            <th style="text-align: center;">返点</th>
                            <th style="text-align: center;">奖金</th>
                            <th style="text-align: center;">撤单</th>
                            <th style="text-align: center;">团队投注额</th>
                            <th style="text-align: center;">团队返点</th>
                            <th style="text-align: center;">团队奖金</th>
                            <th style="text-align: center;">团队撤单</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->day }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->username }}
                                </td>
                                <td>
                                    {{ $item->lottery_id }}
                                </td>
                                <td>
                                    {{ $item->method_id }}
                                </td>
                                <td>
                                    {{ $item->bets }}
                                </td>
                                <td>
                                    {{ $item->points }}
                                </td>
                                <td>
                                    {{ $item->bonus }}
                                </td>
                                <td>
                                    {{ $item->canceled }}
                                </td>
                                <td>
                                    {{ $item->team_bets }}
                                </td>
                                <td>
                                    {{ $item->team_points }}
                                </td>
                                <td>
                                    {{ $item->team_bonus }}
                                </td>
                                <td>
                                    {{ $item->team_canceled }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="12" style="text-align: center;">数据为空！！</td></tr>
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
    </script>
@endsection