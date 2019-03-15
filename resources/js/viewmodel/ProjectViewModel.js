import {calculate} from "../game/index"
import {compress,uncompress} from "../common/zip/index"
import {changeMoneyToFixed,Bconvert} from "../common/common"
import * as func from '../game/funs'

export function ProjectViewModel (opt, app) {

    this.opt = opt;
    this.app = app;
    const self = this;

    this.tab = '';

    this.items = [];
    this.num = 0;
    this.cost = 0;
    this.prize = 0;
    this.single = true;

    //加倍
    this.times = 1;

    const convertMode = function (mode) {
        switch (mode) {
            case 1:
                return 0;
            case 0.1:
                return 1;
            case 0.01:
                return 2;
            case 0.001:
                return 3;
        }
    };

    const convertCodes = function (__choice) {
        const {state} = self.app.method;
        //选球类型
        if (state.type === 'multi') {
            //与实际layout进行匹配
            const codes = [];
            const iterable = Object.keys(state.layout);
            for (let i = 0; i < iterable.length; i++) {
                const name = iterable[i];
                const layout = state.layout[name];
                const col = [];
                for (let j = 0; j < layout.length; j++) {
                    const number = layout[j];
                    if (__choice[i][j]) {
                        col.push(number);
                    }
                }
                codes.push(col.join('&'));
            }

            return codes.join('|');
        }
    };

    const formatInputCodes = function (code) {
        const {state} = self.app.method;
        const {pattern} = self.app;
        if (state.type === 'multi') {
            if ((pattern === 'digital') || (pattern === 'digital3') || (pattern === 'p3p5')) {
                if (Array.from(code).includes('|') || (state.method === 'DWD')) {
                    return code.replace(/&/g, '');
                } else {
                    return code.replace(/&/g, ',');
                }
            } else if (pattern === 'lotto') {
                if (Array.from(code).includes('|') || (state.method === 'LTDWD')) {
                    return code.replace(/&/g, ' ');
                } else {
                    return code.replace(/&/g, ',');
                }
            } else if (pattern === 'pk10') {
                if (Array.from(code).includes('|') || (state.method === 'PKDWD')) {
                    return code.replace(/&/g, ' ');
                } else {
                    return code.replace(/&/g, ',');
                }
            } else if (pattern === 'ks') {
                if (Array.from(code).includes('|')) {
                    return code.replace(/&/g, '');
                } else {
                    return code.replace(/&/g, ',');
                }
            }
        }
        return code;
    };

    const formatPosition = function (positions) {
        const {state} = self.app.method;
        if (!state.rx) {
            return [];
        }
        const c = [];
        for (let k in positions) {
            const item = positions[k];
            if (item) {
                c.push(k);
            }
        }
        return c;
    };


    this.init = function () {
        $('#project-num').text(self.num);
        $('#project-cost').text(self.cost);
        $('#project-times').val(self.times);

        $('#project-empty').off().click(() => self.empty());
        $('#project-times').off().change(function () {
            const times = +$(this).val();
            if (!(0 < times && times < 100000)) {
                return self.times = 1;
            }
            self.times = times;
            return self.calculate();
        });

        return $('#project-submit').off().click(() =>
            self.app.submit(() => self.empty())
        );
    };

    this.add = function () {
        let item;
        if (self.app.trace.visible) {
            return false;
        }  //追号中

        if (self.tab === 'history') {
            self.switch_project();
        }

        const {state} = self.app.method;
        if (state.num < 1) {
            return $.alert("号码选择不完整，请重新选择");
        }
        const {mode} = self.app;
        const {times} = self.app;

        if (state.type === 'multi') {
            item = {
                methodid: self.app.crowd.methodid,
                name: self.app.crowd.menuid + '_' + state.name,
                codes: convertCodes(state.choices),
                num: state.num,
                times,
                cost: changeMoneyToFixed(state.cost * mode),
                mode: convertMode(mode),
                point: state.point,
                prize: state.prize * mode
            };

            item._codes = formatInputCodes(item.codes);

        } else {
            //提示删除重复项
            let _input;
            const tmp = (state.inputcodes || '').split(',');
            const temp = func.array_unique3(tmp);
            if ((tmp.length - temp.length) > 0) {
                $.alert(`投注内容包含重复项，已自动删除${tmp.length - temp.length}个重复项`);
                state.input = temp.join(",");
                calculate(state,state);
            }

            state.input = state.inputcodes;
            if (state.num < 1) {
                return $.alert("号码选择不完整，请重新选择");
            }

            //优化单式//需要压缩
            if (state.b64 && (temp.length > 100)) {
                _input = `base64:${compress(Bconvert(temp.sort()))}`;
            } else {
                _input = state.inputcodes;
            }

            item = {
                methodid: self.app.crowd.methodid,
                name: self.app.crowd.menuid + '_' + state.name,
                codes: _input,
                num: state.num,
                times,
                cost: changeMoneyToFixed(state.cost * mode),
                mode: convertMode(mode),
                point: state.point,
                prize: state.prize * mode
            };

            item._codes = formatInputCodes(state.input);
        }

        //任选
        item.position = formatPosition(state.__position);

        if (item) {
            if (self.items.length >= 50) {
                return $.alert("投注列表已满，请先投注后再购买新的注单");
            }
            self.items.unshift(item);
        }

        self.render();

        return true;
    };

    this.remove = function (index) {
        self.items.splice(+index, 1);
        return self.render();
    };

    this.empty = function () {
        self.items = [];
        self.num = 0;
        self.cost = 0;
        self.prize = 0;
        self.times = 1;

        return self.render();
    };

    this.render = function () {
        self.calculate();
        return self.render_data();
    };

    this.render_data = function () {
        const $view = $('#project-data');

        let html = "";

        for (let $i = 0; $i < self.items.length; $i++) {
            const $data = self.items[$i];
            let mode = '';
            switch ($data.mode) {
                case 0:
                    mode = '元';
                    break;
                case 1:
                    mode = '角';
                    break;
                case 2:
                    mode = '分';
                    break;
                case 3:
                    mode = '厘';
                    break;
            }
            const cost = changeMoneyToFixed($data.cost * $data.times);
            html += `\
<tr>
    <td><i>${$data.name}</i></td>
    <td><i>${$data._codes}</i></td>
    <td><i>${$data.num}</i></td>
    <td><i>${$data.times}</i></td>
    <td><i>${mode}</i></td>
    <td><i>${cost}</i></td>
    <td width="5"><i><a href="javascript:;" class="del" v="${$i}">删除</a></i></td>
</tr>\
`;
        }
        $view.off().empty();
        $(html).appendTo($view);
        $view.off();
        return $view.delegate("td a.del", "click", function () {
            return self.remove($(this).attr('v'));
        });
    };


    //计算project
    this.calculate = function () {
        let single = true;
        let _flag = '';
        let cost = 0;
        let prize = 0;
        let num = 0;

        for (let item of Array.from(self.items)) {
            cost += +item.cost * +item.times;
            prize += +item.prize;
            num += +item.num * +item.times;
            if ((_flag !== "") && (_flag !== item.methodid)) {
                single = false;
            }
            if (_flag === "") {
                _flag = item.methodid;
            }
        }

        self.single = single;
        self.num = num;
        self.cost = cost;
        self.prize = prize;

        $('#project-num').text(self.num);
        return $('#project-cost').text(changeMoneyToFixed(self.cost * self.times));
    };

    this.switch_project = function () {
        if (self.tab === 'project') {
            return;
        }
        $('#project-current').parent().siblings().removeClass('on');
        $('#project-current').parent().addClass('on');

        $('#project-bar').show();
        $('#project-project').show();
        $('#project-order').hide();
        return self.tab = 'project';
    };

    this.switch_history = function () {
        if (self.tab === 'history') {
            return;
        }
        $('#project-history').parent().siblings().removeClass('on');
        $('#project-history').parent().addClass('on');

        $('#project-bar').hide();
        $('#project-project').hide();
        $('#project-order').show();
        return self.tab = 'history';
    };

    return this;
};