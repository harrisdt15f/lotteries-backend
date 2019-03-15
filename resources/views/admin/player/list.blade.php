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
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label"  style="width: 80px;">上级ID:</label>
                            <div class="layui-input-inline" style="width: 120px;" >
                                <input  name="parent_id" id="parent_id" class="layui-input" value="{{isset($c['parent_id']) ? $c['parent_id'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label" style="width: 80px;">用户组:</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="type" id="type"  class="layui-input">
                                    @foreach(\App\Models\Player\Player::$types as $id => $name)
                                        <option value="{{$id}}" @if(isset($c['type']) && $c['type'] == $id)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">注册日期:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="register_time" id="register_time" class="layui-input" value="{{isset($c['register_time']) ? $c['register_time'] : ""}}">
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
                @if($ridStr)
                    <div style="padding-left: 13px;">
                        <span class="layui-breadcrumb">
                            @foreach($ridStr as $id => $username)
                                <a class="rLink" _parent_id="{{$id}}" href="javascript:void(0)">{{$username}}</a>
                            @endforeach
                        </span>
                    </div>
                @endif
                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">昵称</th>
                            <th style="text-align: center;">类型</th>
                            <th style="text-align: center;">邀请码</th>
                            <th style="text-align: center;">是否测试</th>
                            <th style="text-align: center;">可用金额</th>
                            <th style="text-align: center;">冻结金额</th>
                            <th style="text-align: center;">上次登录时间</th>
                            <th style="text-align: center;">注册时间</th>
                            <th style="text-align: center;">冻结类型</th>
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
                                    <a href="{{route("playerList", ['parent_id' => $item->id, 'type' => 2])}}">{{ $item->nickname }}</a>
                                </td>
                                <td style="text-align: center;">
                                    @if($item->type == 1)
                                        <span style="color:#0a7be6;">直属</span>
                                    @elseif($item->type == 2)
                                        <span style="color: #0b2e13;">代理</span>
                                    @else
                                        <span style="color: #0b2e13;">玩家</span>
                                    @endif
                                    @if($item->is_robot)
                                        <i class="fa fa-android" style="color: green;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <span style="color: blue;">{{ $item->invite_code }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($item->is_tester == 1)
                                        <span style="color: red;">是</span>
                                    @else
                                        <span style="color: green;">否</span>
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    <span style="color: green;">{{ number4($item->balance) }}</span>
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->frozen) }}
                                </td>
                                <td style="text-align: center;">
                                    @if ($item->last_login_time)
                                        {{ date("Y/m/d H:i", $item->last_login_time )}}
                                    @else
                                        ---
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ date("Y/m/d H:i", strtotime($item->created_at) ) }}
                                </td>
                                <td style="text-align: center;">
                                    {{ \App\Models\Player\Player::$frozenType[$item->frozen_type] }}
                                </td>
                                <td style="text-align: center;">
                                    <a  class="detail-btn" href="javascript:;" _url="{{route("playerDetail",    [$item->id])}}">详情</a>
                                    <a  class="password-btn" href="javascript:;" _url="{{route("playerPassword",  [$item->id])}}">密码</a>
                                    <a href="{{route("playerSetting",   [$item->id])}}">设置</a>
                                    <a class="fund-btn" href="javascript:;" _url="{{route("playerFund",      [$item->id])}}">资金</a>
                                    <a class="frozen-btn" href="javascript:;" _url="{{route("playerFrozen",    [$item->id])}}">冻结</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="17" style="text-align: center;">数据为空！！</td></tr>
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
                        title: "修改密码",
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

            $(".rLink").click(function () {
                var _self       = $(this);
                var _parentId   = _self.attr('_parent_id');

                $("#parent_id").val(_parentId);
                $("#btn-submit").trigger("click");
            });
        });
    </script>
@endsection