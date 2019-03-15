@extends('toad.layouts.index-game')
@section('content')
    <script>
        $(document).ready(function(){
            var apiurl='{{url('/') . '/'}}';

            var app=window.AppViewModel({
                lotteryid:'{{$lotteryid}}',
                user:{
                    id:'{{$userGameData['hashid']}}',
                    point:{{$userGameData['point']}},
                    maxpoint:{{$userGameData['maxpoint']}},
                    balance:{{$userGameData['balance']}}
                },
                apis:{
                    userInfo:apiurl + 'user/info',
                    issue:apiurl+'game/issueInfo?kind={{$lotteryid}}',
                    code:apiurl+'game/issueInfo?kind={{$lotteryid}}',
                    order:apiurl+'order/history',
                    orderDetail:apiurl+'order/detail',
                    orderCancel:apiurl+'order/cancel',
                    orderRebet:apiurl+'order/rebet',
                    upload:apiurl+'upload',
                    bets:apiurl+'game/play',
                    openList:apiurl+'openList'
                },
                issues:{!! json_encode($issueInfo)  !!}
            });

            app.init();
        });

    </script>
    <div class="warp">
        <div class="main-center">
            <div id="nav-mobile" class="sidebar">
                <div class="sidebar-list-new ">
                    <ul class="sidebar-list-new__ul">
                        <li class="sidebar-list-new__li @if($cat == 'hot') selected__li @endif">
                            <span>热门彩种</span>
                            <i class="side-hot__i">火热
                            </i>
                            <div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['hot'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-list-new__li @if($cat == 'ssc') selected__li @endif">时时彩系列
                            <div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['ssc'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-list-new__li  @if($cat == '115') selected__li @endif"">11选五系列
                            <div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['115'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li style="display: none" class="sidebar-list-new__li  @if($cat == 'kl3') selected__li @endif">快三系列<div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['kl3'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li style="display: none" class="sidebar-list-new__li @if($cat == 'lhc') selected__li @endif"> 六合彩系列<div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['lhc'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li style="display: none" class="sidebar-list-new__li @if($cat == 'pk10') selected__li @endif"> PK10系列<div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['pk10'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-list-new__li @if($cat == 'slow') selected__li @endif">低频彩系列
                            <div class="sidemenu-new">
                                <ul class="sidemenu-new__ul">
                                    @foreach($sideBarLotteries['slow'] as $_key => $_config)
                                        <li class="sidemenu-new__li @if($lotteryid == $_key) sidemenu-new__li--on @endif">
                                            <a sign="{{$_key}}" href="{{url('game/' . $_key)}}">{{$_config['name']}}</a>
                                            @if($_config['hot'])
                                                <i class="side-hot__i">火热</i>
                                            @endif
                                            @if($_config['new'])
                                                <i class="side-new__i">新</i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div id='game-body'>
                <div class="main-center-con">
                    <div class="main-lottery-top-msg">
                        <div class="main-deadline">
                            @if(!$lottery->fastopen)
                                <div>
                                    <h5>第 <strong id="current_no">@if(isset($issueInfo['datas']['issues'][0][0])) {{$issueInfo['datas']['issues'][0][0]}} @else '' @endif</strong> 期剩余投注时间</h5>
                                    <div class="main-deadline-time" id="current_remainTime">00:00</div>
                                    <div class="main-deadline-txt">{{$lottery->desc}}</div>
                                </div>
                            @else
                                <div>
                                    <div class="main-deadline-time">{{$lottery->name}}</div>
                                </div>
                            @endif
                        </div>
                        <div @if($lottery->pattern=='pk10') class="main-lottery-num-pk" @else class="main-lottery-num" @endif>
                            <h5>
                                <span>{{$lottery->name}}</span>
                                <i>
                                    第 <i id="before_no">@if(isset($issueInfo['datas']['before'][0])) {{$issueInfo['datas']['before'][0]}} @else '' @endif</i> 期
                        <span id="before_desc">
                        </span>
                                </i>
                            </h5>
                            <ul id="before_opencode">
                                @if($lottery->pattern=='digital3')
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                @elseif($lottery->pattern=='pk10')
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                @else
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                    <li class="open-num"></li>
                                @endif
                            </ul>
                        </div>

                        <div @if($lottery->pattern=='pk10') class="main-lottery-list-pk" @else class="main-lottery-list" @endif>
                            <h5>最新开奖<i class="ico ico-new">new</i>  <a href="{{$lottery->trend}}" target="_blank">走势图</a></h5>
                            <ul id="open-list">
                            </ul>
                        </div>
                    </div>

                    <div class="bet-type-box">
                        <div class="bet-type-crow">
                            <ul id="crowd-menu">
                            </ul>
                            @if($lottery->hasrx)
                                <div class="bet-type-optional" id="rx"><span></span></div>
                            @endif
                        </div>
                        <div id="crowd-menu2">

                        </div>
                    </div>

                    <div class="main-row-1">
                        <div class="main-play-introduce">
                            <div class="introduce-txt" id="method-desc">每位至少选择一个号码，竞猜开奖号码的后三位，号码和位置都对应即中奖。</div>
                            <a href="javascript:;" class="ico-why">?<div class="tooltip1" id="method-help"></div><span></span></a>
                            <a href="javascript:;" class="ico-case">例<div class="tooltip1" id="method-example"></div><span></span></a>
                        </div>
                    </div>

                    <div class="main-ball-section">
                        <div class="main-ball-random"><a href="javascript:;" class=" btn-red" id="random1">机选一注</a><a href="javascript:;" class=" btn-red" id="random5">机选五注</a></div>
                        <div class="main-ball-box" id="ball-multi">
                            <div class="position">

                            </div>
                            <div class="ball">
                            </div>
                        </div>

                        <div class="main-ball-box" id="ball-text" style="display: none">
                            <div class="position">

                            </div>
                            <div class="ball">

                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="bet-statistics">
                            <div class="main-column-1 FL">
                                <div class="bet-choose-total">您选择了共<span id="num" class="txt-red m-L m-R">0</span>注，
                                    <input type="button" value="-" class="bet-choose-ipt" id="times-reduce">
                                    <input type="text" class="ipt ipt-muliple" value="1" id="times">
                                    <input type="button" value="+" class="bet-choose-ipt" id="times-add">
                                    倍
                                </div>
                                <div class="bet-play-mode"> <span class="play-mode-name">模式：</span>
                                    <div class="btn-tab-list">
                                        <a href="javascript:;" class="btn-tab btn-effect btn-red tab-on" id="mode-y" v="1">元</a>
                                        <a href="javascript:;" class="btn-tab btn-effect btn-red" id="mode-j" v="0.1">角</a>
                                        <a href="javascript:;" class="btn-tab btn-effect btn-red" id="mode-f" v="0.01">分</a>
                                        @if( ($lottery->pattern=='digital' || $lottery->pattern=='digital3') && !$lottery->fastopen )
                                            <a href="javascript:;" class="btn-tab btn-effect btn-red" id="mode-l" v="0.001">厘</a>
                                        @endif
                                    </div>

                                </div>
                                <div class="bet-rebate-mode"> <span class="rebate-mode-name">返点：</span>
                                    <div class="data-slider-box" id="pointset">

                                    </div>
                                </div>
                            </div>

                            <div class="main-column-1 FR">
                                <div class="bet-add-box">
                                    <strong class="bet-total-money" id="cost">0.00</strong>元
                                    <a href="javascript:;" class="btn main-btn-fastadd  btn-effect" id="fast-add"><span class="ico-add"></span><span>一键投注</span></a>
                                    <a href="javascript:;" class="btn main-btn-add btn-effect" id="add"><span class="ico-add"></span><span>添加选号</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="main-bottom">
                    <div class="main-bottom-con"  id="project">
                        <div class="tabs-box-menu m-B">
                            <div class="tabs-r-txt" id="project-bar">
                                <p>当前总共<strong class="txt-red" id="project-num">1</strong>注，
                                    我要翻 <input type="text" class="ipt ipt-muliple" id="project-times">
                                    倍，总金额<strong class="txt-red" id="project-cost"> 2 </strong>元。</p>
                            </div>
                            <ul class="tabs-ul">
                                <li><a href="javascript:;" id="project-current">当前投注</a></li>
                                <li><a href="javascript:;" id="project-history">投注历史</a></li>
                            </ul>
                        </div>

                        <div class="bet-count-confirm" id="project-project">
                            <div class="bet-msg-pick-bd">
                                <div class="bet-pick-box">
                                    <a href="javascript:;" class="txt-clean" id="project-empty">清空选号</a>
                                    <div class="iptbox bet-pick-ipt-box">
                                        <table width="100%">
                                            <thead>
                                            <tr>
                                                <th><i>玩法</i></th>
                                                <th><i>号码</i></th>
                                                <th><i>注数</i></th>
                                                <th><i>倍数</i></th>
                                                <th><i>模式</i></th>
                                                <th><i>总额(元)</i></th>
                                                <th><i>操作</i></th>
                                            </tr>
                                            </thead>

                                            <tbody id="project-data">
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="">
                                @if (!$lottery->fastopen)
                                    <div class="bet-future-set">
                                        <a href="javascript:;" class="btn bet-future-num" id="trace-open">我&nbsp;&nbsp;要&nbsp;&nbsp;追&nbsp;&nbsp;号</a>
                                        <p>&nbsp;</p>
                                        <p class="bet-future-select-box">
                                            <select class="ipt bet-future-select" id="issues">
                                            </select>
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="main-btn-confirm-box">
                                @if (!$lottery->fastopen)
                                    <a href="javascript:;" class="btn main-btn-confirm" id="project-submit"><span class="ico-confirm"></span><span>确认投注</span></a>
                                @else
                                    <a href="javascript:;" class="btn main-btn-confirm" id="project-submit"><span class="ico-confirm"></span><span>马上开奖</span></a>
                                @endif
                            </div>
                        </div>

                        <div class="bet-count-confirm"  id="project-order" style="display:none">
                            <div class="bet-pick-his-box">
                                <div class="iptbox bet-history-box">
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th><i>编号</i></th>
                                            <th><i>奖期</i></th>
                                            <th><i>时间</i></th>
                                            <th><i>玩法</i></th>
                                            <th><i>号码</i></th>
                                            <th><i>总额(元)</i></th>
                                            <th><i>奖金</i></th>
                                            <th><i>模式</i></th>
                                            <th><i>倍数</i></th>
                                            <th><i>状态</i></th>
                                        </tr>
                                        </thead>
                                        <tbody style="cursor: pointer;" id="order-data">
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div id="trace" class="main-bottom-con" style="display:none">
                        <div class="bet-count-confirm">
                            <div class="tabs-box pop-tabs-box">
                                <div class="cancel-future">
                                    <label><input type="checkbox" id="trace-stop">中奖后停止追号</label>
                                    <label class="tooltipped" data-tooltip="若为选中状态，则在出现官方未开、跳开或其他异常情况时，系统自动停止追号计划."><input type="checkbox" id="trace-except">异常后停止追号</label>
                                </div>
                                <div class="tabs-box-menu">
                                    <ul class="tabs-ul">
                                        <li><a href="javascript:;" id="trace-type0">同倍追号</a></li>
                                        <li><a href="javascript:;" id="trace-type1">翻倍追号</a></li>
                                        <li><a href="javascript:;" id="trace-type2">利润率追号</a></li>
                                    </ul></div>
                                <div class="tabs-detail">
                                    <div class="form-row-1 pop-row-1">
                                        <div class="form-column-1">
                                            <span class="form-column-2">连续追：</span>
                                            <div class="btn-tab-list form-column-2">
                                                <a href="javascript:;" class="btn-tab btn-red trace-scount" v="5">5</a>
                                                <a href="javascript:;" class="btn-tab btn-red trace-scount" v="10">10</a>
                                                <a href="javascript:;" class="btn-tab btn-red trace-scount" v="15">15</a>
                                                <a href="javascript:;" class="btn-tab btn-red trace-scount" v="20">20</a>
                                            </div>
                                            <span class="form-column-2 m-L"><input type="text" value="1" class="ipt ipt30" id="trace-count"></span>
                                            <span class="form-column-2">期</span>
                                            <span class="form-column-2">起始倍数：</span>
                                            <span class="form-column-2 m-L"><input type="text" class="ipt ipt30" id="trace-first"> 倍</span>
                                        </div>

                                        <div class="form-column-1">
                                            <span class="form-column-2 m-L" style="display:none">每隔<input type="text" value="1" class="ipt ipt30" id="trace-range"> 期</span>
                                            <span class="form-column-2 m-L" style="display:none">倍X <input type="text" value="2" class="ipt ipt30"  id="trace-duplicate"></span>
                                            <span class="form-column-2 m-L" style="display:none">最低收益率：<input type="text" value="50" class="ipt ipt30" id="trace-profit">%</span>
                                        </div>

                                        <div class="form-column-1">
                                            <a href="javascript:;" class="btn btn-green" id="trace-gen">生成追号</a>
                                        </div>
                                    </div>
                                    <div class="form-row-1">
                                        <div class="form-column-1">
                                            <p class="pop-confirm-txt">
                                                共追号<strong class="txt-red" id="trace-total-count"></strong> 期，
                                                共<strong class="txt-red" id="trace-total-num">10</strong>个投注项，
                                                追号总金额<strong class="txt-red" id="trace-total-cost"> 20.00</strong> 元
                                            </p>
                                        </div>
                                        <div class="form-column-3">
                                            <a href="javascript:;" class="btn main-btn-cancel" id="trace-close"><span>正常投注</span></a>
                                            <a href="javascript:;" class="btn main-btn-confirm" id="trace-submit"><span class="ico-confirm"></span><span>追号投注</span></a>
                                        </div>
                                    </div>
                                    <div class="pop-row-2">
                                        <div class="table-box">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-body">
                                                <tr>
                                                    <td class="table-th" >序号</td>

                                                    <td class="table-th">追号期号</td>

                                                    <td class="table-th">倍数</td>

                                                    <td class="table-th">金额（元）</td>

                                                    <td class="table-th">预计开奖时间</td>
                                                </tr>
                                                <tbody id="trace-data">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection