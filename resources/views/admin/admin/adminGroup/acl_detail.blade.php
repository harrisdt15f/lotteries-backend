@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="table dataTable dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table id="table" class="layui-table" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <tbody>
                    @foreach($allMenus as $id => $item)
                        <tr role="row">
                            <td style="text-align:left;" colspan="2"><span style="font-size: 20px;color: green;">{{$item['title']}}&nbsp;<input class="top" _id="{{$id}}" value="{{$id}}" type="checkbox" checked name="acl_id[]"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <table id="table" class="layui-table" style="width: 100%;" width="100%">
                                    @foreach($item['child'] as $_id => $_item)
                                        <tr role="row" class="odd">
                                            <td style="text-align:left;" colspan="5">
                                                <span style="font-size: 18px;color: blue;">{{$_item['title']}}&nbsp;<input class="_parent" _parent="{{$id}}" _top="{{$id}}" _id="{{$_id}}" value="{{$_id}}" type="checkbox" checked name="acl_id[]"></span>
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
                                                                    <span style="font-size: 16px;color: #0C0C0C;">{{$__item['title']}}&nbsp;<input class="_item" _parent="{{$_id}}" _top="{{$id}}" value="{{$__id}}" type="checkbox" checked name="acl_id[]"></span>&nbsp;&nbsp;
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
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $(document).ready(function () {
            // 总分类全选
            $(".top").click(function () {
                var sId         = $(this).attr('_id');
                var isChecked   = $(this).is(':checked');

                if (isChecked) {
                    $("._parent[_top='" + sId + "']").prop('checked', true);
                    $("._item[_top='" + sId + "']").prop('checked', true);
                } else {
                    $("._parent[_top='" + sId + "']").prop('checked', false);
                    $("._item[_top='" + sId + "']").prop('checked', false);
                }
            });

            // 父类全选
            $("._parent").click(function () {
                var sId         = $(this).attr('_id');
                var isChecked   = $(this).is(':checked');

                if (isChecked) {
                    $("._item[_parent='" + sId + "']").prop('checked', true);
                } else {
                    $("._item[_parent='" + sId + "']").prop('checked', false);
                }
            });
        });

    </script>
@endsection
