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
                <table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">邮箱</th>
                            <th style="text-align: center;">用户组</th>
                            <th style="text-align: center;">注册IP</th>
                            <th style="text-align: center;">添加日期</th>
                            <th style="text-align: center;">上次登录</th>
                            <th style="text-align: center;">创建人</th>
                            <th style="text-align: center;">状态</th>
                            <th style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @foreach($data['data'] as $item)
                        <tr role="row" class="odd">
                            <td style="text-align: center;">{{$item->username}}</td>
                            <td style="text-align: center;">{{$item->email}}</td>
                            <td style="text-align: center;">{{$item->group_name}}</td>
                            <td style="text-align: center;">{{$item->register_ip}}</td>
                            <td style="text-align: center;">{{$item->created_at}}</td>
                            <td style="text-align: center;">
                                @if($item->last_login_time)
                                    {{ date("Y-m-d H:i:s", $item->last_login_time)}}
                                @endif
                            </td>
                            <td style="text-align: center;">{{$item->admin_id}}</td>
                            <td  style="text-align: center;">
                                @if ($item->status == 1)
                                    <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></span>
                                @else
                                    <span style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{route("adminUserAdd", [$item->id])}}">编辑</a>
                                <a  class="password-btn" href="javascript:;" _url="{{route("adminUserPassword",  [$item->id])}}">密码</a>
                                <a class="status-btn" href="javascript:void(0)" ref="{{route("adminUserStatus", [$item->id])}}">
                                    @if($item->status == 1)
                                        禁用
                                    @else
                                        启用
                                    @endif
                                </a>
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
                    if (status == "success") {
                        if (data.status == 'success') {
                            window.location.reload();
                        }
                        _alert(data.msg);
                    }
                }, 'JSON');
            });

            var openIndex = null;
            $(".password-btn").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_url');


                openIndex = layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        offset      : "120px",
                        area: ['620px', '400px'],
                        title: "修改管理员密码",
                        content: [sUrl, 'no'],
                        end: function () {
                            window.location.reload();
                            return true;
                        }
                    });
                });
            });
        });
    </script>
@endsection