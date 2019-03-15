@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form style="display: none;" id="searchForm" action="{{ $currentUrl }}">
                    <div class="dt-toolbar">
                        <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    </div>
                </form>
                <table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dt_basic_info" style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th  style="text-align: center;">用户名</th>
                            <th  style="text-align: center;">IP</th>
                            <th  style="text-align: center;">路由</th>
                            <th  style="text-align: center;">参数</th>
                            <th  style="text-align: center;">时间</th>
                         </tr>
                    </thead>
                    <tbody>
                    @foreach($data['data'] as $item)
                        <tr role="row" class="odd">
                            <td  style="text-align: center;">{{ $item->admin_username }}</td>
                            <td  style="text-align: center;">{{$item->ip}}</td>
                            <td  style="text-align: center;">{{$item->route}}</td>
                            <td>{{$item->params}}</td>
                            <td style="text-align: center;">{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include("admin.layouts.pagination")
            </div>
        </div>
    </div>

@endsection

@section("script")
    @parent
    <script>
        $(document).ready(function () {
        });
    </script>
@endsection

