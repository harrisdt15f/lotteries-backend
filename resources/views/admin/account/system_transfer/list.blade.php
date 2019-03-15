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
                            <label class="layui-form-label"  style="width: 80px;">昵称:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="nickname" id="nickname" class="layui-input" value="{{isset($c['nickname']) ? $c['nickname'] : ""}}">
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
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">模式</th>
                            <th style="text-align: center;">类型</th>
                            <th style="text-align: center;">发起管理员</th>
                            <th style="text-align: center;">发起日期</th>
                            <th style="text-align: center;">处理管理员</th>
                            <th style="text-align: center;">处理日期</th>
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
                                    {{ $item->nickname }}
                                </td>

                                <td style="text-align: center;">
                                    {{ number4($item->amount) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ \App\Models\Player\AdminTransferRecords::$mode[$item->mode] }}
                                </td>
                                <td style="text-align: center;">
                                   {{ $item->type }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->admin_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("m-d H:i:s", $item->add_time) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->process_admin_name }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->process_time > 0)
                                        {{ date("Ymd", $item->process_time) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->status }}
                                </td>
                                <td style="text-align: center;">
                                    <a>详情</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="15" style="text-align: center;">数据为空！！</td></tr>
                    @endif
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
            </div>
        </div>
    </div>

@endsection

@section("script")
    <script>
        layui.use(['form', 'laydate', 'element'], function(){
            var form        = layui.form;
            var laydate    = layui.laydate;
            laydate.render({
                elem: '#register_time',
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

            $(".fund-btn").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_url');

                layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        offset      : "120px",
                        area: ['720px', '500px'],
                        title: "理赔扣减",
                        content: [sUrl, 'no'],
                        end: function () {
                            window.location.reload();
                            return true;
                        }
                    });
                });
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
                        title: "理赔扣减",
                        content: [sUrl, 'no'],
                        end: function () {
                            window.location.reload();
                            return true;
                        }
                    });
                });
            });

            $(".frozen-btn").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_url');

                layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        offset      : "120px",
                        area: ['620px', '400px'],
                        title: "冻结",
                        content: [sUrl, 'no'],
                        end: function () {
                            window.location.reload();
                            return true;
                        }
                    });
                });
            });

            $(".detail-btn").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_url');

                layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        offset      : "120px",
                        area: ['920px', '600px'],
                        title: "详情",
                        content: [sUrl, 'no'],
                        end: function () {
                            return true;
                        }
                    });
                });
            });
        });
    </script>
@endsection