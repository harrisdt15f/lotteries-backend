@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="table dataTable dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id="addForm"  class="layui-form"  action="{{route("adminGroupAclEdit", [$group->id])}}" method="post">
                    {{ csrf_field() }}
                    <table id="table" class="layui-table" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                        <tbody>
                        <tr>
                            <td colspan="5">
                                <div class="layui-form-item">
                                    <div class="layui-input-inline">
                                        <input id="selectAll" type="checkbox" name="selectAll" title="全选" lay-skin="primary"  lay-filter="selectAll">
                                    </div>

                                    <div class="layui-input-inline">
                                        <button class="layui-btn" lay-submit lay-filter="*">提交</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach($allMenus as $id => $item)
                            <tr role="row">
                                <td style="text-align:left;" colspan="2"><span style="font-size: 20px;color: #333333;">{{$item['title']}}&nbsp;<input  lay-filter="oneLevelSelectAll" lay-skin="primary" class="top" _id="{{$id}}" value="{{$id}}" type="checkbox" name="acl_id[]" @if(in_array($id, $currentAclIds)) checked @endif></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <table id="table" class="layui-table" style="width: 100%;" width="100%">
                                        @foreach($item['child'] as $_id => $_item)
                                            <tr role="row" class="odd">
                                                <td style="text-align:left;" colspan="5">
                                                    <span style="font-size: 18px;color: #333333;">{{$_item['title']}}&nbsp;<input  lay-filter="secondLevelSelectAll" lay-skin="primary" class="_parent" _parent="{{$id}}" _top="{{$id}}" _id="{{$_id}}" value="{{$_id}}" type="checkbox" name="acl_id[]" @if(in_array($_id, $currentAclIds)) checked @endif></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table id="table" class="layui-table" style="width: 100%;" width="100%">
                                                        @if ($_item['child'])
                                                            <tr role="row">
                                                                <td style="width: 20px;"></td>
                                                                <td style="text-align:left;" colspan="5">
                                                                    @foreach($_item['child'] as $__id =>  $__item)
                                                                        <span style="font-size: 16px;color: #333333;">{{$__item['title']}}&nbsp;<input lay-skin="primary" class="_item" _parent="{{$_id}}" _top="{{$id}}" value="{{$__id}}" type="checkbox" name="acl_id[]" @if(in_array($__id, $currentAclIds)) checked @endif></span>&nbsp;&nbsp;
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $(document).ready(function () {

            // 表单
            layui.use('form', function() {
                var form = layui.form;

                form.on('checkbox(selectAll)', function(data){
                    var isChecked   = data.elem.checked;

                    if (isChecked) {
                        $("._parent, ._item, .top").prop('checked', true);
                    } else {
                        $("._parent, ._item, .top").prop('checked', false);
                    }

                    form.render('checkbox');
                });

                // 一级全选
                form.on('checkbox(oneLevelSelectAll)', function(data){
                    let isChecked   = data.elem.checked;
                    let sId         = $(data.elem).attr('_id');
                    if (isChecked) {
                        $("._parent[_top='" + sId + "']").prop('checked', true);
                        $("._item[_top='" + sId + "']").prop('checked', true);
                    } else {
                        $("._parent[_top='" + sId + "']").prop('checked', false);
                        $("._item[_top='" + sId + "']").prop('checked', false);
                    }

                    form.render('checkbox');
                });

                // 二级全选
                form.on('checkbox(secondLevelSelectAll)', function(data){
                    let isChecked   = data.elem.checked;
                    let sId         = $(data.elem).attr('_id');

                    if (isChecked) {
                        $("._item[_parent='" + sId + "']").prop('checked', true);
                    } else {
                        $("._item[_parent='" + sId + "']").prop('checked', false);
                    }

                    form.render('checkbox');
                });

                // 提交
                form.on('submit(*)', function(data){
                    return true;
                });
            });
        });

    </script>
@endsection
