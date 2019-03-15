@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id="searchForm" action="{{ $currentUrl }}">
                    <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    <div class="layui-form-item" style="padding-top:5px; ">
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label"  style="width: 60px;">ID:</label>
                            <div class="layui-input-inline" style="width: 100px;" >
                                <input  name="id" id="id" class="layui-input" value="{{isset($c['id']) ? $c['id'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label"  style="width: 80px;">昵称:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="nickname" id="nickname" class="layui-input" value="{{isset($c['nickname']) ? $c['nickname'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">添加日期:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="add_time" id="add_time" class="layui-input" value="{{isset($c['add_time']) ? $c['add_time'] : ""}}">
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
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">用户ID</th>
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">银行</th>
                            <th style="text-align: center;">拥有者</th>
                            <th style="text-align: center;">卡号</th>
                            <th style="text-align: center;">支行</th>
                            <th style="text-align: center;">省</th>
                            <th style="text-align: center;">市</th>
                            <th style="text-align: center;">修改时间</th>
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
                                    {{ $item->user_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->nickname }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->bank_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->owner_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->card_number }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->branch }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->province }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->city }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->updated_at }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status == 1)
                                        <a class="status_item" href="javascript:void(0)" ref="{{route("playerCardStatus",    [$item->id])}}">禁用</a>
                                    @else
                                        <a class="status_item" href="javascript:void(0)" ref="{{route("playerCardStatus",    [$item->id])}}">启用</a>
                                    @endif

                                    <a class="fix_item" href="javascript:void(0)" ref="{{route("playerCardFixTime",  [$item->id])}}">修正</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="12" style="text-align: center;">数据为空！！</td></tr>
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
        layui.use(['form', 'laydate', 'element'], function(){
            var form        = layui.form;
            var laydate    = layui.laydate;
            laydate.render({
                elem: '#add_time',
                type: "datetime"
            });
        });

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

            $(".del_item").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('ref');
                _confirm("您确定要删除记录么?", function (index) {
                    layer.close(index);
                    $.get(sUrl, [], function (data, status) {
                        if (status == "success") {
                            if (data.status == 'success') {
                                _alert(data.msg);
                                window.location.reload();
                            } else {
                                _alert(data.msg);
                            }
                        }
                    }, 'JSON');
                });

            });

            $(".fix_item").click(function () {
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
        });
    </script>
@endsection