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
                            <label class="col-md-5 control-label">{{__("user_stat.search.username")}}:</label>
                            <div class="col-md-2">
                                <input name="username" id="username" class="form-control" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="col-md-5 control-label">{{__("user_stat.search.start_day")}}:</label>
                            <div class="col-md-2">
                                <input name="start_day" id="start_day" class="form-control" value="{{isset($c['start_day']) ? $c['start_day'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-lg-3">
                            <label class="col-md-6 control-label">{{__("user_stat.search.end_day")}}:</label>
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
                        <th style="text-align: center;">充值单</th>
                        <th style="text-align: center;">提现单</th>
                        <th style="text-align: center;">投注单</th>
                        <th style="text-align: center;">工资</th>
                        <th style="text-align: center;">分红</th>
                        <th style="text-align: center;">礼金</th>
                        <th style="text-align: center;">充值量</th>
                        <th style="text-align: center;">首冲量</th>
                        <th style="text-align: center;">提现额</th>
                        <th style="text-align: center;">投注额</th>
                        <th style="text-align: center;">撤单额</th>
                        <th style="text-align: center;">自身返点</th>
                        <th style="text-align: center;">下级返点</th>

                        <th style="text-align: center;">人工充值</th>
                        <th style="text-align: center;">理赔</th>
                        <th style="text-align: center;">扣除</th>
                        <th style="text-align: center;">人工礼金</th>
                        <th style="text-align: center;">人工分红</th>
                        <th style="text-align: center;">人工工资</th>
                        <th style="text-align: center;">操作</th>
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
                                    {{ $item->recharge_count }}
                                </td>
                                <td>
                                    {{ $item->withdraw_count }}
                                </td>
                                <td>
                                    {{ $item->bet_count }}
                                </td>
                                <td>
                                    {{ $item->salary }}
                                </td>
                                <td>
                                    {{ $item->dividend }}
                                </td>
                                <td>
                                    {{ $item->gift }}
                                </td>
                                <td>
                                    {{ $item->recharge }}
                                </td>
                                <td>
                                    {{ $item->first_recharge }}
                                </td>
                                <td>
                                    {{ $item->withdraw }}
                                </td>
                                <td>
                                    {{ $item->bets }}
                                </td>
                                <td>
                                    {{ $item->cancel }}
                                </td>
                                <td>
                                    {{ $item->points_self }}
                                </td>
                                <td>
                                    {{ $item->points_child }}
                                </td>
                                <td>
                                    {{ $item->claim_recharge }}
                                </td>
                                <td>
                                    {{ $item->claim_add }}
                                </td>
                                <td>
                                    {{ $item->claim_reduce }}
                                </td>
                                <td>
                                    {{ $item->claim_gift }}
                                </td>
                                <td>
                                    {{ $item->claim_dividend }}
                                </td>
                                <td>
                                    {{ $item->claim_salary }}
                                </td>
                                <td>
                                    <a>图表</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="22" style="text-align: center;">数据为空！！</td></tr>
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