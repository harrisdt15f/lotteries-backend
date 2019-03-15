@extends('admin.layouts.home')
@section("content")
    <fieldset class="layui-elem-field">
        <legend>投注测试</legend>
    </fieldset>
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-md2">
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;">彩种列表</a>
                        <dl class="layui-nav-child">
                            @foreach($lotteries as $lottery)
                                <dd><a  class="lottery" _data="{{json_encode($lottery->methods)}}" href="javascript:;" _to="{{$lottery->en_name}}">{{$lottery->cn_name}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-col-md10">
                <input type="hidden" name="lottery_id" id="lottery_id" value="" />

                <div class="layui-row">
                    <form class="layui-form" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">玩法:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <select id="method_id" name="method_id" lay-verify="required">

                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖金组:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="text" id="prize_group" name="prize_group" required  value="1950" lay-verify="required" placeholder="请输奖金组" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">号码:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="text" id="code" name="code" required value="1|2|3"  lay-verify="required" placeholder="请输入号码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">模式:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <select id="mode" name="mode" lay-verify="required">
                                    <option value="1">元</option>
                                    <option value="0.1">角</option>
                                    <option value="0.01">分</option>
                                    <option value="0.001">厘</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">单价:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <select id="single_price" name="single_price" lay-verify="required">
                                    <option value="2">2元模式</option>
                                    <option value="1">1元模式</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖期:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <select id="trace_issue" name="trace_issue" lay-verify="required">
                                    @foreach($issues as $issue)
                                        <option value="{{$issue->issue}}">{{$issue->issue}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">总价:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="text" id="total_cost" name="total_cost" required value="2"  lay-verify="required" placeholder="请输入总价" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                <button class="layui-btn" lay-filter="formDemo" id="betSubmit">投注</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>

                </div>
            </div>
        </div>

    </div>

@endsection
@section("script")
    <script>
        layui.use(['element', 'form'], function(){
            var element = layui.element;
            var form    = layui.form;

            $(".lottery").click(function () {

                var method      = $(this).attr("_data");
                var lotteryId   = $(this).attr("_to");

                $("#lottery_id").val(lotteryId);

                $("#method_id").html("");

                $.each(JSON.parse(method), function (i, v) {
                    $("#method_id").append("<option value='" + v.method_id + "'>" + v.method_name + "</option>");
                });

                form.render('select');
            });

            $("#betSubmit").click(function () {
                var data        = {};
                data.lottery_id = $("#lottery_id").val();
                data.balls      = [];

                var balls = {
                    'code'          : $("#code").val(),
                    'prize_group'   : $("#prize_group").val(),
                    'mode'          : $("#mode").val(),
                    'single_price'  : $("#single_price").val(),
                };

                data.balls[0]       = balls;
                data.total_cost     = $("#total_cost").val();
                data.trace_issue    = [];

                var issue               = $("#trace_issue").val();
                var issues              = {};
                issues[issue]           = 1;
                data.trace_issue[0]     = issues;

                console.log(data);

                var url = "http://a.zhongxing.com/bet";
                $.post(url, data, function () {

                });
            });

            $(".lottery").eq(0).trigger('click');
        });

    </script>
@endsection

