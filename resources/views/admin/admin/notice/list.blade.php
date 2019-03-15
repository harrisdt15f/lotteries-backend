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
                            <th style="text-align: center;">类型</th>
                            <th style="text-align: center;">标题</th>
                            <th style="text-align: center;">置顶权重</th>
                            <th style="text-align: center;">内容摘要</th>
                            <th style="text-align: center;">开始时间</th>
                            <th style="text-align: center;">结束时间</th>
                            <th style="text-align: center;">添加人</th>
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
                                    {{\App\Models\Admin\Notice::$types[$item->type]}}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->title }}
                                </td>

                                <td style="text-align: center;">
                                    {{ $item->top_score }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->content }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i", $item->start_time) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y-m-d H:i", $item->end_time) }}
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
                                    <a href="{{route("noticeAdd",  [$item->id])}}">编辑</a>
                                    <a class="status-btn" href="javascript:void(0)" ref="{{route("noticeStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>
                                    <a class="top-btn" href="javascript:void(0)" ref="{{route("noticeTop",  [$item->id])}}">置顶</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="10" style="text-align: center;">数据为空！！</td></tr>
                    @endif
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
            </div>
        </div>
    </div>

@endsection