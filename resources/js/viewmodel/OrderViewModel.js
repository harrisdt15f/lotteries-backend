

export function OrderViewModel (opt, app) {

    this.opt = opt;
    this.app = app;
    const self = this;
    self.first_time = false;

    this.items = [];

    this.init = function () {
        //如果3秒没刷新
        setTimeout(function () {
            if (!self.first_time) {
                return self.refresh(true);
            }
        });
        return 3000;
    };

    //刷新投注历史
    this.refresh_end = true;
    this.refreshOrdersTimer = undefined;
    this.refresh = function () {
        //获取投注历史 防止刷新太过频繁
        if (!self.refresh_end) {
            return;
        }
        if (self.refreshOrdersTimer) {
            return;
        }
        self.refresh_end = false;

        return self.refreshOrdersTimer = setTimeout(function () {
                self.refreshOrdersTimer = undefined;
                return $.get(self.app.opt['apis']['order'], {
                        lotteryid: self.app.lotteryid,
                        pagesize: 10,
                        isFront: 1
                    }, function (data) {

                        self.first_time = true;

                        setTimeout(() => self.refresh_end = true
                            , 2000);

                        const orders = [];
                        for (let i = 0; i < data.data.length; i++) {
                            const item = data.data[i];
                            orders.push(item);
                        }
                        self.items = orders;

                        return self.render();
                    }
                    , 'json');
            }
            , 1000);
    };

    this.render = function () {

        let html = '';
        for (let $data of Array.from(self.items)) {
            html += `\
<tr v="${$data.hashId}">
    <td><i>${$data.hashId}</i></td>
    <td><i>${$data.issue}</i></td>
    <td><i>${$data.addDate}</i></td>
    <td><i>${$data.methodName}</i></td>
    <td><i>${$data.playAllCode}</i></td>
    <td><i>${$data.cost}</i></td>
    <td><i>${$data.bonus}</i></td>
    <td><i>${$data.mode}</i></td>
    <td><i>${$data.times}</i></td>
    <td><i class="${$data.status_class}">${$data.status}</i></td>
</tr>\
`;
        }

        const $view = $('#order-data');
        $view.off().empty();
        $(html).appendTo($view);

        $view.off();
        return $view.delegate("tr", "click", function () {
            return self.showOrderDetail($(this).attr('v'));
        });
    };

    this.showOrderDetail = function (hashId) {
        let order = undefined;
        for (let k = 0; k < self.items.length; k++) {
            const item = self.items[k];
            if (item['hashId'] === hashId) {
                order = item;
            }
        }

        return $.get(self.app.opt['apis'].orderDetail, {hashId}, function (data) {
                if (data.errno && ((data.errno % 100) !== 0)) {
                    return $.alert(data.error);
                } else {
                    return $.confirmDetail(data.data
                        , () => self.cancelOrder(hashId)
                        , () => self.rebetOrder(hashId));
                }
            }
            , 'json');
    };

    //撤单
    this.cancelOrder = hashId =>
        $.get(self.app.opt['apis'].orderCancel, {'tasks': hashId}, function (data) {
            if (data.errno && ((data.errno % 100) !== 0)) {
                return $.alert(data.error);
            } else {
                return self.refresh();
            }
        })
    ;

    //重投
    this.rebetOrder = hashId =>
        $.get(self.app.opt['apis'].orderRebet, {hashId}, function (data) {
            if (data.errno && ((data.errno % 100) !== 0)) {
                return $.alert(data.error);
            } else {
                if (self.app.lottery.fastopen) {
                    self.app.issue.before_state = 1;
                    return self.app.issue.setOpencode();
                } else {
                    return self.refresh();
                }
            }
        })
    ;

    return this;
};