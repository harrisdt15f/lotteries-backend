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
                    <input id="pid" type="hidden" name="pid" value="{{$data['pid']}}">
                </form>
                <table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                    <tr role="row">
                        <th   style="text-align: center;">名称</th>
                        <th   style="text-align: center;">标识</th>
                        <th   style="text-align: center;">值</th>
                        <th   style="text-align: center;">管理员ID</th>
                        <th   style="text-align: center;">状态</th>
                        <th   style="text-align: center;">创建时间</th>
                        <th   style="text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['data'] as $item)
                        <tr role="row" class="odd">
                            <td style="text-align: center;">{{ $item->name }}</td>
                            <td style="text-align: center;">{{$item->sign}}</td>
                            <td style="text-align: center;">{{$item->value}}</td>
                            <td style="text-align: center;">{{$item->admin_id}}</td>
                            <td style="text-align: center;">
                                    <span class="status_{{$item->id}}">
                                        @if ($item->status == 1)
                                            <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        @else
                                            <span style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                        @endif
                                    </span>
                            </td>
                            <td  style="text-align: center;">
                                {{$item->created_at}}
                            </td>
                            <td  style="text-align: center;">
                                @if($item->pid == 0)
                                <a href="{{url("configureList") . "?pid=" . $item->id}}">下级</a>
                                @endif
                                @if($item->pid > 0)
                                    <a href="{{route("configureAdd", $item->pid) . "?id=" . $item->id }}">编辑</a>
                                @endif
                                @if($item->pid > 0)
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("configureStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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
                    console.log(status);
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
