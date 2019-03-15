import methods from "../game/config/method"
import disableMethods from "../game/config/disable"

export function CrowdViewModel (opt, app) {

    this.opt = opt;
    this.app = app;
    const self = this;

    this.methods = {};

    this.menuid = '';
    this.menu2id = '';
    this.methodid = '';

    this.isrx = false;
    this.view = $('#crowd-menu');
    this.view2 = $('#crowd-menu2');

    this.rx_view = $('#rx');

    this.init = function () {
        self.methods = methods[self.app.pattern];
        let gameSign = self.opt.lotteryid;
        if (disableMethods[gameSign]) {
            for (let menuid in self.methods) {
                if (disableMethods[gameSign][menuid]) {
                    if (disableMethods[gameSign][menuid] == "*") {
                        delete self.methods[menuid];
                    } else {
                        for (let menuId_2 in self.methods[menuid]) {
                            if (disableMethods[gameSign][menuid][menuId_2]) {
                                if (disableMethods[gameSign][menuid][menuId_2] == "*") {
                                    delete self.methods[menuid][menuId_2];
                                } else {
                                    for (let menuId_3 in self.methods[menuid][menuId_2]) {
                                        for(let i in disableMethods[gameSign][menuid]) {
                                            if(disableMethods[gameSign][menuid][i] == menuId_3){
                                                delete self.methods[menuid][menuId_2][menuId_3];
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
        return self.render();
    };

    this.render = function (rx) {
        let html = "";
        for (let menuid in self.methods) {
            //非任选
            const crowd = self.methods[menuid];
            if (!self.isrx && self.app.rxs[menuid]) {
                continue;
            }
            //任选
            if (self.isrx && !(self.app.rxs[menuid] && self.app.lottery['hasrx'])) {
                continue;
            }

            html += `\
<li menuid="${menuid}">
    <a href="javascript:;" menuid="${menuid}">
        <span class="bet-type-crow-name">${menuid}</span>
        <span class="bet-type-group-name"></span>
    </a>
</li>\
`;
        }

        //设置任选
        if (self.app.lottery['hasrx']) {
            self.rx_view.show();
            if (!self.isrx) {
                self.rx_view.html('<a href="javascript:;">任选</a>');
            }
            if (self.isrx) {
                self.rx_view.html('<a href="javascript:;">常规</a>');
            }
            self.rx_view.off().click(() => self.setRx());

        } else {
            self.rx_view.hide();
        }

        self.view.off().empty();
        $(html).appendTo(self.view);

        return self.bind();
    };


    //任选切换
    this.setRx = function () {
        self.isrx = !self.isrx;
        return self.render(self.isrx);
    };

    //切换玩法群
    this.bind = function (menuid, rx) {
        if (!menuid) {
            const fn = function () {
                let mid = self.app.lottery['default_methodid'];
                if (self.isrx) {
                    mid = 'RZX3';
                }
                for (menuid in self.methods) {
                    //非任选
                    const val1 = self.methods[menuid];
                    if (!self.isrx && self.app.rxs[menuid]) {
                        continue;
                    }
                    //任选
                    if (self.isrx && !(self.app.rxs[menuid] && self.app.lottery['hasrx'])) {
                        continue;
                    }

                    for (let menu2id in val1) {
                        const val2 = val1[menu2id];
                        for (let methodid in val2) {
                            const val3 = val2[methodid];
                            if (methodid === mid) {
                                return [menuid, menu2id, methodid];
                            }
                        }
                    }
                }
            };

            [self.menuid, self.menu2id, self.methodid] = Array.from(fn());

        } else {
            self.menuid = menuid;
            self.menu2id = Object.keys(self.methods[self.menuid])[0];
            self.methodid = Object.keys(self.methods[self.menuid][self.menu2id])[0];
        }

        //bind
        self.view.find('li').removeClass('on');
        self.view.off();
        self.view.delegate("li", "click", function () {
            return self.bind($(this).attr('menuid'));
        });
        self.view.find(`li[menuid="${self.menuid}"]`).addClass('on');

        self.render2(self.menuid, self.menu2id, self.methodid);

    };

    this.render2 = function () {
        let h1 = "";

        for (let menu2id in self.methods[self.menuid]) {
            let data = self.methods[self.menuid][menu2id];
            let h2 = "";
            for (let methodid in self.methods[self.menuid][menu2id]) {
                data = self.methods[self.menuid][menu2id][methodid];
                h2 += `\
<li methodid="${methodid}" menu2id="${menu2id}">
    <a href="javascript:;" class="btn-red">${data.name}</a>
</li>\
`;
            }

            let text = `<div class="group-name">${menu2id}</div>`;
            if (menu2id === 'default') {
                text = "";
            }

            h1 += `\
<div class="bet-type-group-list">
    ${text}
    <ul>
      ${h2}
    </ul>
</div>\
`;
        }

        const html = `\
<div class="bet-type-group" menuid="${self.menuid}">
  ${h1}
</div>\
`;

        self.view2.off().empty();
        $(html).appendTo(self.view2);
        return self.bind2();
    };

    this.bind2 = function () {
        //bind
        self.view2.off();
        self.view2.delegate("li", "click", function () {
            self.view2.find('li').removeClass('on');
            self.menu2id = $(this).attr('menu2id');
            self.methodid = $(this).attr('methodid');

            self.view2.find(`li[methodid="${self.methodid}"]`).addClass('on');

            return self.app.method.render(self.menuid, self.menu2id, self.methodid);
        });

        //触发
        return self.view2.find(`li[methodid="${self.methodid}"]`).trigger('click');
    };

    return this;
};