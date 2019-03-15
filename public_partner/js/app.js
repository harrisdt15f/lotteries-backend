
// 弹窗提示
var _alert = function (sMsg, callbackFn) {

    var htmlMsg = '<div  style="padding: 20px; line-height: 22px; font-weight: 700;">';

    htmlMsg     += sMsg;
    htmlMsg     += "</div>";

    layui.use('layer', function() {
        layer.open({
            type        : 1,
            title       : "提示信息",
            offset      : "120px",
            shade       : 0.2,
            id          : 'alert_box',
            moveType    : 1,
            content     : htmlMsg,
            btn: ['确定'],
            yes: function(index, layero) {
                callbackFn;
                layer.close(index);
            }
        });
    });
};


// 确认框
var _confirm = function (sMsg, callbackFn) {
     layui.use('layer', function() {
        layer.open({
            content: sMsg
            ,offset      : "120px"
            ,btn: ['确认', '取消',]
            ,yes: function(index, layero){
                callbackFn(index)
            }
            ,btn2: function(index, layero){

            }
            ,cancel: function(){

            }
        });

    });
};


(function (jq) {  //jq就相当于$
    jq.extend({
        "_content": function (sHtml, onClose, title, width) {

            title   = title || '温馨提示';
            onClose = onClose || function(){};

            var cHtml = '';
            cHtml +='<div>';
            cHtml +='    <div class="pop-common-broad">';
            cHtml +='        <div class="pop-bd pop-row-3 content">'+sHtml;
            cHtml +='        </div>';
            cHtml +='    </div>';
            cHtml +='</div>';

            width = width || 800;

            layui.use('layer', function() {
                layer.open({
                    type: 1,
                    area: ['800px', ''],
                    title: title,
                    shade: 0.4,
                    shadeClose:true,
                    offset: '160px',
                    moveType: 1,
                    shift: 2,
                    content: cHtml,
                    end: function () {
                        onClose();
                        return true;
                    }
                });
            });
        }
    });
})(jQuery);