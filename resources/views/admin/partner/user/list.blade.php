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
                            <label class="col-md-5 control-label">{{__("platform.search.sign")}}:</label>
                            <div class="col-md-2">
                                <input name="sign" id="start_day" class="form-control" value="{{isset($c['sign']) ? $c['sign'] : ""}}">
                            </div>
                        </div>
                        <div class="form-group  col-lg-3">
                            <label class="col-md-6 control-label">{{__("platform.search.username")}}:</label>
                            <div class="col-md-4">
                                <input name="username" id="username" class="form-control" value="{{isset($c['username']) ? $c['username'] : ""}}">
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
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">邮箱</th>
                            <th style="text-align: center;">标识</th>
                            <th style="text-align: center;">平台名</th>
                            <th style="text-align: center;">加入日期</th>
                            <th style="text-align: center;">添加</th>
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
                                    {{ $item->email }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->sign }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->platform_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->created_at }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->admin_id }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route("partnerUserAdd",  [$item->id])}}">编辑</a>
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("partnerUserStatus", [$item->id])}}">
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
                        <tr><td colspan="5" style="text-align: center;">数据为空！！</td></tr>
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