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
                        <div class="layui-inline" style="width: 260px;">
                            <label class="layui-form-label"  style="width: 120px;">发起人ID:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="from_user_id" id="from_user_id" class="layui-input" value="{{isset($c['from_user_id']) ? $c['from_user_id'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline" style="width: 260px;">
                            <label class="layui-form-label"  style="width: 120px;">发起人昵称:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="from_nickname" id="from_nickname" class="layui-input" value="{{isset($c['from_nickname']) ? $c['from_nickname'] : ""}}">
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
                            <th style="text-align: center;">发起ID</th>
                            <th style="text-align: center;">发起人</th>
                            <th style="text-align: center;">目标ID</th>
                            <th style="text-align: center;">目标人</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">添加日期</th>
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
                                    {{ $item->from_user_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->from_nickname }}
                                </td>

                                <td style="text-align: center;">
                                    {{ $item->to_user_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->to_nickname }}
                                </td>
                                <td style="text-align: center;">
                                   {{ number4($item->amount) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Ymd", $item->add_time) }}
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