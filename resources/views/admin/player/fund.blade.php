@extends('admin.layouts.add_ajax')

@section("content")
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">理赔</li>
            <li>扣减</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form id="addForm"  class="layui-form" action="{{route("playerFund", [$model->id])}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" id="mode" name="mode" value="1" />
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">用户余额:</label>
                            <div class="layui-input-inline">
                                <button class="layui-btn layui-btn-normal">{{ number4($account->balance)}}</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">理赔类型:</label>
                            <div class="layui-input-inline">
                                <select name="type" id="type" lay-verify="required" lay-filter="type">
                                    @foreach($fundAddTypes as $sign => $item)
                                        <option value="{{$sign}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>$item
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">理赔金额:</label>
                            <div class="layui-input-inline">
                                <input type="text" id="amount" name="amount" value="" required  lay-verify="required" placeholder="请输入资金" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">最小:{{$min}}, 最大:{{$max}}</div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">资金密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="password" name="password" value="" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">操作描述:</label>
                            <div class="layui-input-inline">
                                <input type="text" id="desc" name="desc" value="" required  lay-verify="required" placeholder="请输入描述" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="btn-submit-add" type="button">
                                    <i class="fa fa-save"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item">
                <form id="reduceForm"  class="layui-form" action="{{route("playerFund", [$model->id])}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" id="mode" name="mode" value="2" />
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">用户余额:</label>
                            <div class="layui-input-inline">
                                <button class="layui-btn layui-btn-normal">{{ number2($account->balance)}}</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">扣减类型:</label>
                            <div class="layui-input-inline">
                                <select name="type" id="type" lay-verify="required" lay-filter="merchant_sign">
                                    @foreach($fundAddTypes as $sign => $item)
                                        <option value="{{$sign}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">理赔金额:</label>
                            <div class="layui-input-inline">
                                <input type="text" id="amount" name="amount" value="" required  lay-verify="required" placeholder="请输入资金" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">最小:{{$min}}, 最大:{{$max}}</div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">资金密码:</label>
                            <div class="layui-input-inline">
                                <input type="password" id="password" name="password" value="" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">操作描述:</label>
                            <div class="layui-input-inline">
                                <input type="text" id="desc" name="desc" value="" required  lay-verify="required" placeholder="请输入描述" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="btn-submit-reduce" type="button">
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

        });

        $(document).ready(function () {

            $("#btn-submit-add").click(function () {

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

            $("#btn-submit-reduce").click(function () {

                var sUrl = $("#reduceForm").attr('action');
                $.post(sUrl, $("#reduceForm").serialize(), function (data, status) {
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
    </script>
@endsection