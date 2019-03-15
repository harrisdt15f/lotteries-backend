@extends('admin.layouts.add_ajax')

@section("content")
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">登录密码</li>
            <li>资金密码</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form id="addForm"  class="layui-form" action="{{route("playerPassword", [$model->id])}}">
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
                            <label class="layui-form-label" style="width: 150px;">登录密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="password" name="password" value="" required  lay-verify="required" placeholder="请输入登录密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">确认密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="confirm_password" name="confirm_password" value="" required  lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-4"  style="width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="btn-submit-password" type="button">
                                    <i class="fa fa-save"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="layui-tab-item">
                <form id="fundForm"  class="layui-form" action="{{route("playerPassword", [$model->id])}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" id="mode" name="mode" value="2" />
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">用户账号:</label>
                            <div class="layui-input-inline">
                                <button class="layui-btn layui-btn-normal">{{ $model->username}}</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">资金密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="fund_password" name="fund_password" value="" required  lay-verify="required" placeholder="请输入登录密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">确认密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="confirm_fund_password" name="confirm_fund_password" value="" required  lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-4" style="width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="btn-submit-fund" type="button">
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

            $("#btn-submit-password").click(function () {

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

            $("#btn-submit-fund").click(function () {

                var sUrl = $("#fundForm").attr('action');
                $.post(sUrl, $("#fundForm").serialize(), function (data, status) {
                    if (data.status == 'success') {
                        _alert(data.msg, function  () {
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