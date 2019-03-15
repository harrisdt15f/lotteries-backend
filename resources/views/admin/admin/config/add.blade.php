@extends('admin.layouts.add')

@section("content")
    <form id="addForm" class="form-horizontal" action="{{route("configAdd", ['pid' => $pid, 'id' => 0])}}">
        {{ csrf_field() }}
        <fieldset>
            <legend>添加配置</legend>
            @if ($configParent)
                <div class="form-group">
                    <label class="col-md-2 control-label">上级标识:</label>
                    <div class="col-md-6">
                        <input class="form-control" value="{{ $configParent->name }}" name="parent_sign" disabled="disabled" type="text">
                    </div>
                </div>
            @endif

            @if ($config)
                <input type="hidden" name="id" value="{{ $config->id}}" />
            @endif

            <div class="form-group">
                <label class="col-md-2 control-label">名称:</label>
                <div class="col-md-6">
                    <input class="form-control" id="name" name="name" type="text" value="@if($config->id){{$config->name}}@endif">
                    <p class="note"><strong>Note:</strong> 2 ～ 16个字符</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">标识:</label>
                <div class="col-md-6">
                    <input class="form-control" id="sign" name="sign" type="text" value="@if($config->id){{$config->sign}}@endif">
                    <p class="note"><strong>Note:</strong> 2 ～ 16个字符, 有上级的以上级Sign为前缀</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">值</label>
                <div class="col-md-6">
                    <input class="form-control" id="value" name="value" type="text" value="@if($config->id){{$config->value}}@endif">
                    <p class="note"><strong>Note:</strong> 2 ～ 16个字符.</p>
                </div>
            </div>

        </fieldset>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-4">
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
        $(document).ready(function () {
            $("#btn-submit").click(function () {
                var sName      = $("#name").val();
                if (!sName) {
                    _alert("{{ __("view.config.add.error.empty_name") }}");
                    return false;
                }

                var sSign   = $("#sign").val();
                if (!sSign) {
                    _alert("{{ __("view.config.add.error.empty_sign") }}");
                    return false;
                }

                var sValue   = $("#value").val();
                if (!sValue) {
                    _alert("{{ __("view.config.add.error.empty_value") }}");
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