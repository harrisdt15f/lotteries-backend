@extends('admin.layouts.list')
@section("content")
    <div role="content">
        <div class="widget-body no-padding">
            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id="searchForm" action="{{ $currentUrl }}">
                    <input id="pageIndex" type="hidden" name="pageIndex" value="{{$data['currentPage']}}">
                    <div class="layui-form-item" style="padding-top:5px; ">
                        <div class="layui-inline" style="width: 210px;">
                            <label class="layui-form-label" style="width: 80px;">游戏:</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="lottery_id" id="lottery_id"  class="layui-input">
                                    <option value="all">所有游戏</option>
                                    @foreach($lotteries as $id => $name)
                                        <option value="{{$id}}" @if(isset($c['lottery_id']) && $c['lottery_id'] == $id)  selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 100px;">玩法SIGN:</label>
                            <div class="layui-input-inline" style="width: 180px;">
                                <input name="method_id" id="method_id" class="layui-input" value="{{isset($c['method_id']) ? $c['method_id'] : ""}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="col-xs-12 col-md-6">
                                <button class="btn btn-primary" id="btn-submit" type="submit">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_basic"  class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">彩种</th>
                            <th style="text-align: center;">玩法名称</th>
                            <th style="text-align: center;">组名</th>
                            <th style="text-align: center;">行名</th>
                            <th style="text-align: center;">组序</th>
                            <th style="text-align: center;">行序</th>
                            <th style="text-align: center;">玩法排序</th>
                            <th style="text-align: center;">状态</th>
                            <th style="text-align: center;">操作</th>
                         </tr>
                    </thead>
                    <tbody>
                    @if (count($data['data']) > 0)
                        @foreach($data['data'] as $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    {{ $item->id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->lottery_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->method_name }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $config['group_name'][$item->series_id][$item->method_group] }}
                                </td>
                                <td style="text-align: center;">
                                    @if ($item->method_row)
                                    {{ $config['row_name'][$item->method_row] }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->group_sort }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->row_sort }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->method_sort }}
                                </td>
                                <td style="text-align: center;">
                                    @if($item->status == 1)
                                        <i class="fa fa-check" style="color: green;"></i>
                                    @else
                                        <i class="fa fa-close" style="color: red;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a class="status_item" href="javascript:void(0)" ref="{{route("lotteryStatus", [$item->id])}}">
                                        @if($item->status == 1)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="10" style="text-align: center;">数据为空！！</td></tr>
                    @endif
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
            $(".status_item").click(function () {
                var _self   = $(this);
                var sUrl    = _self.attr('ref');

                $.get(sUrl, [], function (data, status) {
                    if (status == "success") {
                        if (data.status == 'success') {
                            window.location.reload();
                        }
                        _alert(data.msg);
                    }
                }, 'JSON');
            });
        });
    </script>
@endsection