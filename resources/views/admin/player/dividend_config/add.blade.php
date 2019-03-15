@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("playerSalaryConfigAdd", [$model->id])}}">
        {{ csrf_field() }}
        <fieldset>
            @if($model->id > 0)
                <legend><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:red;"></i> 编辑配置</legend>
            @else
                <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加配置</legend>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">用户名:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="username" name="username" value="{{$model->username}}" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">基准单位:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="base_count" name="base_count" value="{{$model->base_count? $model->base_count : 10000}}" required  lay-verify="required" placeholder="请输入基准单位" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 180px;">百分比:</label>
                <div class="layui-input-inline" style="width: 220px;">
                    <input type="text" id="rate" name="rate" value="{{$model->rate? $model->rate : 0.5}}" required  lay-verify="required" placeholder="请输入百分比" autocomplete="off" class="layui-input">
                </div>
            </div>
        </fieldset>
        <div  class="layui-form-item">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <button class="btn btn-primary" id="btn-submit" type="button">
                        <i class="fa fa-save"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section("script")
    <script>
        layui.use(['form', 'slider', ], function(){
            var form    = layui.form;
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sUrl = $("#addForm").attr('action');
                $.post(sUrl, $("#addForm").serialize(), function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            location.href = data.data.url;
                        } else {
                            _alert(data.msg);
                        }
                    }
                }, 'JSON');

            });
        });
    </script>
@endsection