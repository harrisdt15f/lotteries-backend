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
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">平台:</label>
                            <div class="layui-input-inline" style="width: 100px;">
                                <select name="sign" id="sign"  class="layui-input">
                                    <option value="all">所有</option>
                                    @foreach($platforms as $sign => $name)
                                        <option value="{{$sign}}" @if(isset($c['sign']) && $c['sign'] == $sign)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"  style="width: 80px;">用户名:</label>
                            <div class="layui-input-inline" style="width: 100px;" >
                                <input  name="username" id="username" class="layui-input" value="{{isset($c['username']) ? $c['username'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">类型:</label>
                            <div class="layui-input-inline" style="width: 100px;">
                                <select name="type" id="type"  class="layui-input">
                                    <option value="all">所有</option>
                                    @foreach($types as $sign => $type)
                                        <option value="{{$sign}}" @if(isset($c['type']) && $c['type'] == $sign)  selected @endif>{{$type['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">注单ID:</label>
                            <div class="layui-input-inline" style="width: 80px;">
                                <input name="project_id" id="project_id" class="layui-input" value="{{isset($c['project_id']) ? $c['project_id'] : ""}}">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">奖期:</label>
                            <div class="layui-input-inline" style="width: 100px;">
                                <input name="issue" id="issue" class="layui-input" value="{{isset($c['issue']) ? $c['issue'] : ""}}">
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
                            <th style="text-align: center;">平台</th>
                            <th style="text-align: center;">用户ID</th>
                            <th style="text-align: center;">用户名</th>
                            <th style="text-align: center;">类型</th>
                            <th style="text-align: center;">帐变名称</th>
                            <th style="text-align: center;">金额</th>
                            <th style="text-align: center;">游戏</th>
                            <th style="text-align: center;">玩法</th>
                            <th style="text-align: center;">注单</th>
                            <th style="text-align: center;">奖期</th>
                            <th style="text-align: center;">前余额</th>
                            <th style="text-align: center;">余额</th>
                            <th style="text-align: center;">前冻结</th>
                            <th style="text-align: center;">冻结</th>
                            <th style="text-align: center;">活动</th>
                            <th style="text-align: center;">时间</th>
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
                                    {{ $platforms[$item->sign] }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->user_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->username }}
                                </td>
                                <td style="text-align: center;">
                                    @if($types[$item->type_sign]['type'] == 1)
                                        <span style="color: red;">增加</span>
                                    @else
                                        <span style="color: green;">减少</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->type_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->amount) }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->lottery_id)
                                        {{$item->lottery_id}}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->method_id)
                                        {{$item->method_id}}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->project_id)
                                        {{$item->project_id}}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($item->issue)
                                        {{$item->issue}}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->before_balance)}}
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->balance)}}
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->before_frozen_balance)}}
                                </td>
                                <td style="text-align: center;">
                                    {{ number4($item->frozen_balance)}}
                                </td>
                                <td style="text-align: center;">
                                    {{$item->activity_sign}}
                                </td>
                                <td style="text-align: center;">
                                    {{$item->created_at}}
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
        layui.use(['form', 'laydate'], function(){
            var form        = layui.form;
            var laydate    = layui.laydate;
            laydate.render({
                elem: '#add_time',
                type: "datetime"
            });
        });

        $(document).ready(function () {

            $(".detail-btn").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('_url');


                layui.use('layer', function() {
                    layer.open({
                        type: 2,
                        offset      : "120px",
                        area: ['1080px', '700px'],
                        title: "红包详情",
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
