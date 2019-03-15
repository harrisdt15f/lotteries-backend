@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="table dataTable dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table  class="layui-hidden" id="dataTable" lay-filter="treeTable"></table>
                <table id="table" class="layui-table " role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align:center; width: 200px;">组名</th>
                            <th style="text-align:center;">成员数量</th>
                            <th style="text-align:center;">添加时间</th>
                            <th style="text-align:center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr role="row" class="odd">
                            <td>
                                @if (count($item['child']) > 0)
                                    <a class="showChild" href="javascript:void(0);" s="0" toId="{{$item['id']}}" style="cursor: pointer;"><i class="fa fa-caret-down"></i>&nbsp;{{ $item['name'] }}</a>
                                @else
                                    {{ $item['name'] }}
                                @endif
                            </td>
                            <td style="text-align:center;">{{$item['total_childs']}}</td>
                            <td style="text-align:center;">{{$item['created_at']}}</td>
                            <td style="text-align:center;">
                                <a href="{{route("adminGroupAclDetail", ['pid' => $item['id']])}}">查看权限</a>
                                <a href="{{route("adminGroupAclEdit", ['pid' => $item['id']])}}">修改权限</a>
                                <a href="{{route("adminGroupAdd", [$item['id']])}}">编辑</a>
                                <a href="{{route("adminGroupAdd", [$item['id']])}}">删除</a>
                            </td>
                        </tr>
                        @if (count($item['child']) > 0)
                            @foreach($item['child'] as $_item)
                                <tr role="row" class="odd" pid="{{$item['id']}}" >
                                    <td>
                                        &nbsp;&nbsp;
                                        @if (count($_item['child']) > 0)
                                            <a toId="{{$_item['id']}}" style="cursor: pointer;"><i class="fa fa-caret-down"></i>&nbsp;{{ $_item['name'] }}</a>
                                        @else
                                            {{ $_item['name'] }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">{{$_item['total_childs']}}</td>
                                    <td style="text-align:center;">{{$_item['created_at']}}</td>
                                    <td style="text-align:center;">
                                        <a href="{{route("adminGroupAclDetail",         ['pid' => $_item['id']])}}">查看权限</a>
                                        <a href="{{route("adminGroupAclEdit",            ['pid' => $_item['id']])}}">修改权限</a>
                                        <a href="{{route("adminGroupAdd",               [$_item['id']])}}">编辑</a>
                                        <a href="{{route("adminGroupDel",               [$_item['id']])}}">删除</a>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section("script")
    <script>
        $(document).ready(function () {
            $(".showChild").click(function () {
                var sToId   = $(this).attr('toId');
                var sStatus = $(this).attr('s');

                if (sStatus == 1) {
                    $(this).attr('s', 2);
                    $("tr[pid=" +sToId + "]").show();
                    $(this).children('i').removeClass("fa-caret-right");
                    $(this).children('i').addClass("fa-caret-down");
                } else {
                    $(this).attr('s', 1);
                    $("tr[pid=" +sToId + "]").hide();
                    $(this).children('i').removeClass("fa-caret-down");
                    $(this).children('i').addClass("fa-caret-right");
                }
            });

            $(".item-status").click(function () {
                var sUrl = $(this).attr('ref');
                $.post(sUrl, [], function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            location.reload();
                        } else {
                            _alert(data.msg);
                        }
                    }
                }, 'JSON');

            });
        });

    </script>
@endsection
