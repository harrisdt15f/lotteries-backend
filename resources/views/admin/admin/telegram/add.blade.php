@extends('admin.layouts.add')

@section("content")
    <form id="addForm" class="form-horizontal" action="{{route("telegramChatIdAdd")}}/{{$chatId->id ? $chatId->id :0}}">
        {{ csrf_field() }}
        <fieldset>
            <legend>添加 Chat Id</legend>

            <div class="form-group">
                <label class="col-md-2 control-label">{{__("field.telegram_chat.title")}}</label>
                <div class="col-md-4">
                    <input class="form-control" id="title" name="title" type="text" value="{{$chatId->id ? $chatId->title :""}}">
                    <p class="note"><strong>Note:</strong> 分类说明, 2 ～ 16个字符</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">{{__("field.telegram_chat.chat_id")}}</label>
                <div class="col-md-4">
                    <input class="form-control" id="chat_id" name="chat_id" type="text" value="{{$chatId->id ? $chatId->chat_id :""}}">
                    <p class="note"><strong>Note:</strong>Telegram 组ID, 6 ～ 16个字符.</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">{{__("field.telegram_chat.type")}}</label>
                <div class="col-md-4" style="height: auto;">
                    <select name="type" id="type" class="form-control">
                        @foreach($type as $id => $name)
                            <option value="{{$id}}" @if ($chatId->id && $id == $chatId->type) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
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
                var sTitle  = $("#title").val();
                if (!sTitle) {
                    _alert("Title 不能为空");
                    return false;
                }

                var sChatId = $("#chat_id").val();
                if (!sChatId) {
                    _alert("ChatId 不能为空");
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