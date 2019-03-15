@extends('admin.layouts.add')

@section("content")
    <form id="addForm"  class="layui-form" action="{{route("playerCardAdd")}}">
        {{ csrf_field() }}
        <fieldset>
            <legend><i class="fa fa-plus" aria-hidden="true" style="color:green;"></i> 添加银行卡</legend>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">银行:</label>
                <div class="layui-input-inline">
                    <select name="bank_sign" id="bank_sign" lay-verify="required" lay-filter="bank_sign">
                        @foreach($banks as $sign => $name)
                            <option value="{{$sign}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">用户名:</label>
                <div class="layui-input-inline">
                    <input type="text" id="username" name="username" value="" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">卡号:</label>
                <div class="layui-input-inline" style="width: 360px;">
                    <input type="text" id="card_number" name="card_number" value="" required  lay-verify="required" placeholder="卡号" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">持卡人:</label>
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" id="owner_name" name="owner_name" value="" required  lay-verify="required" placeholder="请输入持卡人姓名" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">支行:</label>
                <div class="layui-input-inline" style="width: 60px;">
                    <input type="text" id="branch" name="branch" value="" required  lay-verify="required" placeholder="支行" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">省:</label>
                <div class="layui-input-inline">
                    <select name="province" id="province" lay-verify="required" lay-filter="province">
                        @foreach($province as $sign => $item)
                            <option value="{{$sign}}">{{$item['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 120px;">市:</label>
                <div class="layui-input-inline">
                    <select name="city" id="city" lay-verify="required" lay-filter="city">

                    </select>
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
        layui.use(['form'], function(){
            var form    = layui.form;
            var aProvince   = {!! json_encode($province)  !!};

            form.on('select(province)', function(data){
                var aList = aProvince[data.value]['city'];

                $("#city").html("");
                $.each(aList, function (i, o) {
                    $("#city").append("<option value='" + i + "'>" + o + "</option>");
                });
                form.render('select');
            });

            @if (!$model->id)
                $("#province").trigger('change');
            @endif
        });

        $(document).ready(function () {

            $("#btn-submit").click(function () {
                var sUsername   = $("#username").val();
                if (!sUsername) {
                    _alert("用户名不能为空!!!");
                    return false;
                }


                var sOwnername = $("#owner_name").val();
                if (!sOwnername) {
                    _alert("持卡人不能为空!!!");
                    return false;
                }

                var sCardNumber  = $("#card_number").val();
                if (!sCardNumber) {
                    _alert("卡号不能为空!!!");
                    return false;
                }

                var sBranch = $("#branch").val();
                if (!sBranch) {
                    _alert("支行不能为空!!!");
                    return false;
                }

                var sProvince = $("#province").val();
                if (sProvince == undefined) {
                    _alert("省份不能为空!!!");
                    return false;
                }

                var sCity = $("#city").val();
                if (sCity == undefined) {
                    _alert("城市不能为空!!!");
                    return false;
                }

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