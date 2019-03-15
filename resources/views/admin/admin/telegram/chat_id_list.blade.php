@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form style="display: none;" id="searchForm" action="{{ $currentUrl }}">
                    <div class="dt-toolbar">
                        <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    </div>
                </form>
                <table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th>ID</th>
                            <th>分类</th>
                            <th>备注</th>
                            <th>Chat Id</th>
                            <th>添加日期</th>
                            <th>状态</th>
                            <th>操作</th>
                         </tr>
                    </thead>
                    <tbody>
                        @if (count($data['data']) > 0)
                            @foreach($data['data'] as $item)
                                <tr role="row" class="odd">
                                    <td>{{$item->id}}</td>
                                    <td>{{\App\Models\Admin\TelegramChatId::$types[$item->type]}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->chat_id}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td class=" expand">
                                        @if ($item->status == 1)
                                            <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></span>
                                        @else
                                            <span style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <a  href="{{route("telegramChatIdAdd",    [$item->id])}}">编辑</a>
                                        <a class="status_item" href="javascript:void(0)" ref="{{route("telegramChatIdStatus", [$item->id])}}">
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
                            <tr><td colspan="7" style="text-align: center;">数据为空！！</td></tr>
                        @endif
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
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
                            _alert(data.msg, function () {
                                window.location.reload();
                            });

                        }
                    }
                }, 'JSON');
            });
        });
    </script>
@endsection