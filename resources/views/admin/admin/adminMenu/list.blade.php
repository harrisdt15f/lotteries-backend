@extends('admin.layouts.list')
@section("content")
    @if (!empty($related))
        <h5>
            <span>
                <a href="{{ route("menuList")}}">根</a>
                <i class="fa fa-caret-right" aria-hidden="true"></i>
            </span>
            @foreach($related as $r)
                <span>
                    <a href="{{ route("menuList") . "?pid=" . $r->id}}">{{$r->title}}</a>
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                </span>
            @endforeach
        </h5>
    @endif
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form style="display: none;" id="searchForm" action="{{ $currentUrl }}">
                    <div class="dt-toolbar">
                        <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                        <input id="pid" type="hidden" name="pid" value="{{$data['pid']}}">
                    </div>
                </form>
                <table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th  style="text-align: center;">名称</th>
                            <th  style="text-align: center;">类型</th>
                            <th  style="text-align: center;">路由</th>
                            <th  style="text-align: center;">状态</th>
                            <th  style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @foreach($data['data'] as $item)
                        <tr role="row" class="odd">
                            <td  style="text-align: center;">{{ $item->title }}</td>
                            <td  style="text-align: center;">
                                @if ($item->type == 1)
                                    链接
                                @else
                                    菜单
                                @endif
                            </td>
                            <td>{{$item->route}}</td>
                            <td  style="text-align: center;">
                                <span class="status_{{$item->id}}">
                                    @if ($item->status == 1)
                                        <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    @else
                                        <span style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    @endif
                                </span>
                            </td>
                            <td  style="text-align: center;">
                                <a href="{{route("menuAdd", [$data['pid'], $item->id])}}">编辑</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route("menuList") . "?pid=" . $item->id}}">子菜单</a>&nbsp;&nbsp;&nbsp;
                                @if($item->parent_id > 0)
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("menuStatus", [$item->id])}}">
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

