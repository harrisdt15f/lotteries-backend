@extends('admin.layouts.add_ajax')

@section("content")
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">冻结类型</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form id="addForm"  class="layui-form" action="{{route("playerFrozen", [$model->id])}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" id="mode" name="mode" value="1" />
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">用户账号:</label>
                            <div class="layui-input-inline">
                                <span>
                                    <button class="layui-btn layui-btn-normal">{{ $model->username}} - 余额({{ number2($account->balance / 100)}}元)</button>
                                </span>

                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">当前类型:</label>
                            <div class="layui-input-inline">
                                <button class="layui-btn layui-btn-normal">{{ \App\Models\Player\Player::$frozenType[$model->frozen_type]}}</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 150px;">登录密码:</label>
                            <div class="layui-input-inline">
                                <select name="frozen">
                                    @foreach(\App\Models\Player\Player::$frozenType as $type => $name)
                                        <option value="{{$type}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div  class="layui-form-item">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-md-4"  style="width: 150px;">
                                </div>
                                <button class="btn btn-primary" id="btn-submit-frozen" type="button">
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

            $("#btn-submit-frozen").click(function () {

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

    </script>
@endsection