@extends('admin.layouts.add')

@section("content")
    <form id="addForm" class="form-horizontal" action="{{route("adminGroupAdd")}}">
        {{ csrf_field() }}
        <fieldset>
            <legend>添加管理员</legend>
            @if ($group)
                <input type="hidden" name="id" value="{{ $group->id}}" />
            @endif
            @if ($parentGroup)
                <input type="hidden" name="pid" value="{{ $parentGroup->id }}" />
                <div class="form-group">
                    <label class="col-md-2 control-label">{{__("view.admin_group.add.field.parent_name")}}</label>
                    <div class="col-md-4">
                        <input class="form-control" value="{{$parentGroup->name}}" id="parent_name" name="parent_name" disabled="disabled" type="text">
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label class="col-md-2 control-label">{{__("view.admin_group.add.field.name")}}</label>
                <div class="col-md-4">
                    <input class="form-control" id="name" name="name" type="text">
                    <p class="note"><strong>Note:</strong> 2 ～ 16个字符</p>
                </div>
            </div>
        </fieldset>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-12">
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
                    _alert("{{ __("view.admin_group.add.error.empty_name") }}");
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