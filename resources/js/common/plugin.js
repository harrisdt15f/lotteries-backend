import {CountUp} from "./countUp"

$.ajaxSetup( {
    complete: function( jqXHR, status ){
        if (status == "parsererror") {
            var data = jqXHR.responseText;
            var regexp = /iamloginpage/;
            if (regexp.test(data)) {
                top.location.href = "/login";
                return;
            }
        }

        if(jqXHR.status==401) {
            top.location.href = "/login";
        }else if(jqXHR.status==402){
            top.location.href = "/login?other=1";
        }else if(jqXHR.status==306){
            top.location.href = "/login";
        }else if(jqXHR.status==404){
            top.location.href = "/login";
        }else if(jqXHR.status==500){
            //top.location.href = "/login";
        }else if(jqXHR.status==503){
            //top.location.href = "/login";
        }else if (status == "error") {
            //top.location.href = "/login";
        }
    },
    headers: {
        'X-XSRF-TOKEN': $.cookie("XSRF-TOKEN")
    }
} );

// 公告显示
$.bulletin = function( sHtml, onClose, title, width) {
    var title   = title || '活动公告';
    onClose = onClose || function(){};
    width   = width || 1000;
    var cHtml = '';
    cHtml +='<div id="modal1"  class="modal2 pop-common" style="display: block; opacity: 1; top: 18%;">';

    cHtml += sHtml;

    cHtml +='</div>';

    layer.open({
        type: 1, //page层
        area: [width + 'px', '455px'],
        title: title,
        shade: 0.6,     // 遮罩透明度
        moveType: 1,    // 拖拽风格，0是默认，1是传统拖动
        shift: 2,       // 0-6的动画形式，-1不开启
        content: cHtml,
        success: function(layero, index){
            var that = this;
            layero.find('.modal-close').off().click(function(){
                layer.close(index);
                onClose();
            });
        }
    });
};

// 确认
$.confirm = function( sHtml, onYes, onNo, type) {
    $.confirm = function( sHtml, onYes, onNo, type) {
        var onYes   = onYes || function(){};
        var onNo    = onNo  || function(){};
        var iType   = type || 4;
        layer.alert(
            sHtml,
            {
                btn: ['确定','取消'],
                shadeClose:true,
                shift: 2,
                icon: iType,
                area: ['450px', '200px'],
                offset: '150px',
                yes: function () {
                    onYes();
                    return true;
                },
                cancel: function () {
                    onNo();
                    return true;
                }
            }
        );
    };
};

// 警告
$.alert = function(msg, onClose, type) {
    var onClose = onClose || function(){};
    var iType   = type || 4;
    layer.alert(
        msg,
        {
            shadeClose:true,
            shift: 2,
            icon: iType,
            area: ['450px', '200px'],
            offset: '150px',
            end: function () {
                onClose();
                return true;
            }
        }
    );

};

//  内容框
$.contentBox = function( sHtml, onClose, title, width) {
    var title   = title || '温馨提示';
    onClose = onClose || function(){};

    var cHtml = '';
    cHtml +='<div>';
    cHtml +='    <div class="pop-common-broad">';
    cHtml +='        <a href="javascript:;"></a>';
    cHtml +='        <div class="pop-hd"><h1 class="title">'+title+'</h1></div>';
    cHtml +='        <div class="pop-bd pop-row-3 content">'+sHtml;
    cHtml +='        </div>';
    cHtml +='    </div>';
    cHtml +='</div>';

    width = width || 800;

    layer.open({
        type: 1, //page层
        area: ['800px'],
        title: title,
        shade: 0.6,
        moveType: 1,
        shift: 2,
        content: cHtml,
        success: function(layero, index){
            var that = this;
            layero.find('.modal-close').off().click(function(){
                layer.close(index);
                onClose();
            });
        }
    });
};



$.nearWarning = function(html,_time,cb,_cb){
    var fn=cb || function(){};
    var fn2=_cb || function(){};
    var time=_time||5000;

    layer.msg(html, {
            icon: 6,
            shift: 6,
            offset:['150px','1px'],
            time:time,
            success: function(layero, index){
                fn(layero,index);
            }
        },
        function(){
            fn2();
        });
};

$.confirmBet = function( views, onYes, onNo) {
    var content=[];
    for(var i in views.projects){
        var p =views.projects[i];
        content.push('<li><span>'+p['name']+' : </span><span>'+p['codes']+'</span></li>');
    }

    var title=views['trace'] ? '追号确认' : '投注确认';
    var desc = views['trace'] ? '追号总金额' : '投注总金额';

    //追号内容
    var sHtml='';
    sHtml +='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
    sHtml +='    <tbody>';
    sHtml +='    <tr>';
    sHtml +='        <td><p>彩种：<strong class="txt-red">'+views['lottery']+'</strong></p></td>';
    sHtml +='        <td><p>奖期：<strong class="txt-red">'+views['issue_desc']+'</strong></p></td>';
    sHtml +='        <td><p>总<strong class="txt-red">'+views['count']+'</strong>期</p></td>';
    sHtml +='    </tr>';
    sHtml +='    <tr>';
    sHtml +='        <td><p>投注项：<strong class="txt-red">'+views['pcnt']+'</strong>项</p></td>';
    sHtml +='        <td><p>'+desc+'：<strong class="txt-red">'+views['cost']+'</strong>元</p></td>';
    sHtml +='        <td></td>';
    sHtml +='    </tr>';
    sHtml +='    <tr>';
    sHtml +='        <td colspan="3">';
    sHtml +='            <div class="pop-msg-box">';
    sHtml +='                <ul>';
    sHtml += content.join('');
    sHtml +='                </ul>';
    sHtml +='            </div>';
    sHtml +='        </td>';
    sHtml +='    </tr>';
    sHtml +='    </tbody>';
    sHtml +='</table>';

    var cHtml='';
    cHtml +='<div>';
    cHtml +='    <div class="pop-common-broad">';
    cHtml +='        <div class="pop-bd pop-row-3 content">'+sHtml;
    cHtml +='        </div>';
    cHtml +='        <div class="pop-fd">';
    cHtml +='            <a href="javascript:;" class="btn btn-blue modal-ok">确定投注</a>';
    cHtml +='            <a href="javascript:;" class="btn btn-raye modal-close">取消投注</a>';
    cHtml +='        </div>';
    cHtml +='    </div>';
    cHtml +='</div>';

    onYes = onYes || function(){};
    onNo = onNo || function(){};

    layer.open({
        type: 1, //page层
        area: ['800px', '320px'],
        title: title,
        shade: 0.6, //遮罩透明度
        moveType: 1, //拖拽风格，0是默认，1是传统拖动
        content: cHtml,
        success: function(layero, index){
            var that=this
            layero.find('.modal-ok').off().click(function(){
                layer.close(index);
                onYes();
            });
            layero.find('.modal-close').off().click(function(){
                layer.close(index);
                onNo();
            });
        }
    });

};

$.confirmDetail = function( views, cancel, rebet, title, width) {
    var title=title || '订单详情';
    //追号内容
    var sHtml='';
    sHtml +='<table width="100%" style=" line-height: 30px;">';
    sHtml +='            <tr>';
    sHtml +='                <td align="left" width="400">注单编号：'+views['hashId']+'</td>';
    sHtml +='                <td align="left">游戏名称：<strong class="txt-red">'+views['lotteryName']+'</strong></td>';
    sHtml +='            </tr>';
    sHtml +='            <tr>';
    sHtml +='                <td align="left">投注奖期：'+views['issue']+'</td>';
    sHtml +='                <td align="left">投单时间：'+views['playTime']+'</td></tr>';
    sHtml +='            <tr>';
    sHtml +='                <td align="left">玩法名称：'+views['methodName']+'</td>';
    sHtml +='                <td align="left">投注金额：<strong class="txt-red">'+views['totalCost']+'</strong></td>';
    sHtml +='            </tr>';
    sHtml +='            <tr>';
    sHtml +='                <td align="left">投注模式：'+views['mode']+'</td>';
    sHtml +='                <td align="left">注单倍数：'+views['times']+'倍</td></tr>';
    sHtml +='            <tr>';
    sHtml +='                <td align="left">注单状态：<strong class="txt-blue">'+views['status']+'</strong></td>';
    sHtml +='                <td align="left">注单奖金：<strong class="txt-red">'+views['bonus']+'</strong></td>';
    sHtml +='            </tr>';
    sHtml +='            <tr><td colspan="2" align="left">开奖号码：'+views['officialCode']+'</td>';
    sHtml +='            </tr>';
    sHtml +='            <tr><td colspan="2" align="left">&nbsp;&nbsp;</td>';
    sHtml +='            </tr>';
    sHtml +='            <tr>';
    sHtml +='                <td colspan="2" style="border-bottom: none;"  align="left">';
    sHtml +='                    <div class="FL">投注内容：</div>';
    sHtml +='                    <textarea class="iptbox" style="width:600px;height: 70px;">'+views['playCode']+'</textarea>';
    sHtml +='                </td>';
    sHtml +='            </tr>';
    sHtml +='</table>';


    var cHtml='';
    cHtml +='<div>';
    cHtml +='    <div class="pop-common-broad">';
    cHtml +='        <div class="pop-bd pop-row-3 content">'+sHtml;
    cHtml +='        </div>';
    cHtml +='        <div class="pop-fd">';
    if(views['isAllowCancel']){
        cHtml +='            <a href="javascript:;" class="btn btn-raye modal-cancel">撤单</a>';
        cHtml +='            &nbsp;&nbsp;';
    }
    //cHtml +='            <a href="javascript:;" class="btn btn-blue modal-rebet">重复投注</a>';
    cHtml +='        </div>';
    cHtml +='    </div>';
    cHtml +='</div>';

    layer.open({
        type: 1, //page层
        area: ['800px', '440px'],
        title: title,
        shade: 0.6, //遮罩透明度
        moveType: 1, //拖拽风格，0是默认，1是传统拖动
        content: cHtml,
        success: function(layero, index){
            var that=this
            layero.find('.modal-rebet').off().click(function(){
                layer.close(index);
                rebet();
            });
            layero.find('.modal-cancel').off().click(function(){
                layer.close(index);
                cancel();
            });
        }
    });
};

$.showMoneyAnimate = function(before,now,callback) {
    var options = {
        useEasing : true,
        useGrouping : true,
        separator : '',
        decimal : '.'
    };

    callback=callback || function(){};

    var $el=$('#balance');
    $el.css({'background-color':'#ff5237','color':'white'});
    var demo = new CountUp($el.get(0), before, now, 4, 1, options);
    demo.start(function(){
        $el.delay(2000).css({'background-color':'','color':''});
        callback();
    });
};

//uploadFile