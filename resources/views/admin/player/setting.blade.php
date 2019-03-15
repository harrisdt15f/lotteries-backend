@extends('admin.layouts.add_ajax')

@section("content")
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">绑定unionId</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form id="addForm"  class="layui-form" action="{{route("playerSetting", [$model->id])}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" id="mode" name="mode" value="1" />
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">用户昵称:</label>
                            <div class="layui-input-inline">
                                <button class="layui-btn layui-btn-normal">{{ $model->nickname}}</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">绑定unionId:</label>
                            <div class="layui-input-inline">
                                <input type="text" id="union_id" name="union_id" value="" required  lay-verify="required" placeholder="请输入unionId" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">资金密码:</label>
                            <div class="layui-input-inline">
                                <input type="fund_password" id="fund_password" name="fund_password" value="" required  lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-4"  style="width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="btn-submit-unionid" type="button">
                                    <i class="fa fa-save"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
@section("script")
    <script>
        layui.use(['form', 'element'], function(){
            var form    = layui.form;
            var element = layui.element;

            $("#btn-submit-unionid").click(function () {
                _alert("对不起, 暂未开放");
                return true;
                var sUrl = $("#addForm").attr('action');
                $.post(sUrl, $("#addForm").serialize(), function (data, status) {
                    if (data.status == 'success') {
                        _alert(data.msg, function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    } else {
                        _alert(data.msg);
                    }

                }, 'JSON');

            });
        });

        $(document).ready(function () {


        });
    </script>
@endsection