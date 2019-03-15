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
                            <label class="layui-form-label"  style="width: 80px;">用户名:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="username" id="username" class="layui-input" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline" style="width: 260px;">
                            <label class="layui-form-label"  style="width: 120px;">上级用户名:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="parent_username" id="parent_username" class="layui-input" value="{{isset($c['parent_username']) ? $c['parent_username'] : ""}}">
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
                            <th style="text-align: center;">平台</th>
                            <th style="text-align: center;">上级</th>
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">用户类型</th>
                            <th style="text-align: center;">契约</th>
                            <th style="text-align: center;">状态</th>
                            <th style="text-align: center;">签订时间</th>
                            <th style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->sign }}
                                </td>
                                <td>
                                    {{ $item->parent_username }}
                                </td>
                                <td>
                                    {{ $item->username }}
                                </td>
                                <td>
                                    {{ $item->user_type }}
                                </td>
                                <td>
                                    {{ $item->contract }}
                                </td>
                                <td>
                                    {{ $item->status }}
                                </td>
                                <td>
                                    {{ $item->created_at }}
                                </td>
                                <td>
                                    <a href="{{route("userDividendConfigAdd",  [$item->id])}}">编辑</a>
                                    <a class="status-btn" href="javascript:void(0)" ref="{{route("userDividendConfigStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>

                                    <a href="{{route("userDividendConfigDel",  [$item->id])}}">删除</a>
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
    @parent
    <script>
    </script>
@endsection