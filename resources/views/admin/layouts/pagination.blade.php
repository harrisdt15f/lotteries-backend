@if(isset($data['total']) && $data['total'] > 1)
    <div id="pager"></div>
@endif
@section('script')
    @parent
    <script>
        $(document).ready(function () {
            layui.use('laypage', function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'pager',limit:{{$pageSize}},curr:{{$data['currentPage']}}, count: {{$data['total']}}
                });

                $("#layui-laypage-1 a").click(function () {
                    var pageNumber  = $(this).attr('data-page');
                    var pageNumber  = + pageNumber;
                    if (pageNumber >= 0) {
                        $("#pageIndex").val(pageNumber);
                        $("#searchForm").submit();
                    }
                });
            });
        });
    </script>
@endsection