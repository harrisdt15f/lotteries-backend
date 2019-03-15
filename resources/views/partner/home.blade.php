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
                                <select id="method" name="method" lay-verify="required">

                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖金组:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="group" name="group" required  value="1950" lay-verify="required" placeholder="请输奖金组" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">号码:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="code" name="code" required value="1|2|3"  lay-verify="required" placeholder="请输入号码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">模式:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="mode" name="mode" required value="1" lay-verify="required" placeholder="请输入模式" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">总价:</label>
                            <div class="layui-input-block" style="width: 250px;">
                                <input type="cost" name="cost" required value="2"  lay-verify="required" placeholder="请输入总价" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                <button class="layui-btn" lay-submit lay-filter="formDemo">投注</button>
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
                var method = $(this).attr("_data");
                $("#method").html("");

                $.each(JSON.parse(method), function (i, v) {
                    console.log(v);
                    $("#method").append("<option value='" + v.method + "'>" + v.name + "</option>");
                });

                form.render('select');
            });

            $(".lottery").eq(0).trigger('click');
        });

    </script>
@endsection

