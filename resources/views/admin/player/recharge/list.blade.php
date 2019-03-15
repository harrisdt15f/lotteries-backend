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
                            <label class="col-md-5 control-label">{{__("salary.search.username")}}:</label>
                            <div class="col-md-2">
                                <input name="username" id="username" class="form-control" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="col-md-5 control-label">{{__("salary.search.start_day")}}:</label>
                            <div class="col-md-2">
                                <input name="start_day" id="start_day" class="form-control" value="{{isset($c['start_day']) ? $c['start_day'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-lg-3">
                            <label class="col-md-6 control-label">{{__("salary.search.end_day")}}:</label>
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
                            <th style="text-align: center;">平台</th>
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">订单号</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">实际上分</th>
                            <th style="text-align: center;">附言</th>
                            <th style="text-align: center;">来源</th>
                            <th style="text-align: center;">ip</th>
                            <th style="text-align: center;">提交时间</th>
                            <th style="text-align: center;">上分时间</th>
                            <th style="text-align: center;">管理员</th>
                            <th style="text-align: center;">状态</th>
                            <th style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->p_sign }}
                                </td>
                                <td>
                                    {{ $item->username }}
                                </td>
                                <td>
                                    {{ $item->order_id }}
                                </td>
                                <td>
                                    {{ $item->amount }}
                                </td>
                                <td>
                                    {{ $item->real_amount }}
                                </td>
                                <td>
                                    {{ $item->sign }}
                                </td>
                                <td>
                                    {{ $item->source }}
                                </td>
                                <td>
                                    {{ $item->ip }}
                                </td>
                                <td>
                                    {{ $item->request_time }}
                                </td>
                                <td>
                                    {{ $item->process_time }}
                                </td>
                                <td>
                                    {{ $item->admin_id }}
                                </td>
                                <td>
                                    <span>
                                        @if ($item->status == 1)
                                            <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        @else
                                            <span style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route("rechargeHand", [$item->id]) }}">人工</a>&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="13" style="text-align: center;">数据为空！！</td></tr>
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