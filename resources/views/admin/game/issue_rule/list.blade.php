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
                            <div class="col-xs-12 col-md-6">
                                <button class="btn btn-primary" id="btn-submit" type="submit">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="layui-table"  style="width: 100%;" width="100%">
                    <thead>
                        <tr role="row">
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">彩种</th>
                            <th style="text-align: center;">开始时间</th>
                            <th style="text-align: center;">结束时间</th>
                            <th style="text-align: center;">第一期时间</th>
                            <th style="text-align: center;">每期秒数</th>
                            <th style="text-align: center;">截单时间</th>
                            <th style="text-align: center;">录号延迟</th>
                            <th style="text-align: center;">总期数</th>
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
                                <td>
                                    {{ $lotteries[$item->lottery_id] }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->begin_time }}
                                </td>

                                <td style="text-align: center;">
                                    {{ $item->end_time }}
                                </td>

                                <td style="text-align: center;">
                                    {{ $item->first_time }}
                                </td>

                                <td style="text-align: center;">
                                    {{ $item->issue_seconds }}
                                </td>

                                <td>
                                    {{ $item->adjust_time }}
                                </td>
                                <td>
                                    {{ $item->encode_time }}
                                </td>
                                <td>
                                    {{ $item->issue_count }}
                                </td>

                                <td style="text-align: center;">
                                    <a href="{{route("issueRuleAdd",  [$item->id])}}">编辑</a>
                                    <a href="{{route("issueRuleDel",  [$item->id])}}">删除</a>
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

    </script>
@endsection