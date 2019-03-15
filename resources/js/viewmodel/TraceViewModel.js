import {changeMoneyToFixed} from "../common/common"

export function TraceViewModel (opt, app) {

    this.opt = opt;
    this.app = app;
    const self = this;

    this.items = [];
    this.total_cost = 0;
    this.total_count = 0;
    this.total_num = 0;

    this.type = 0;
    this.visible = false;
    this.stop = true;
    this.except = false;

    this.count = 10;
    this.first = 1;
    this.range = 1;
    this.profit = 50;
    this.duplicate = 2;

    this.init = function () {
        $('#trace-close').off().click(() => self.close());
        return $('#trace-open').off().click(function () {
            if (self.app.project.num < 1) {
                return $.alert('请先添加投注项!');
            }
            return self.open();
        });
    };

    this.render = function () {
        $('#trace-type0,#trace-type1,#trace-type2').parent().removeClass('on');
        $(`#trace-type${self.type}`).parent().addClass('on');

        $('#trace-stop').prop('checked', self.stop ? true : false);
        $('#trace-except').prop('checked', self.except ? true : false);

        $('#trace-count').val(self.count);
        $('#trace-first').val(self.first);
        $('#trace-range').val(self.range).parent().hide();
        $('#trace-profit').val(self.profit).parent().hide();
        $('#trace-duplicate').val(self.duplicate).parent().hide();
        if (self.type === 1) {
            $('#trace-range').val(self.range).parent().show();
            $('#trace-duplicate').val(self.duplicate).parent().show();

        } else if (self.type === 2) {
            $('#trace-profit').val(self.profit).parent().show();
        }

        $('#trace .trace-scount').removeClass('tab-on');
        $(`#trace .trace-scount[v="${self.count}"]`).addClass('tab-on');

        self.bind();

        //生成追号数据
        return self.render_data();
    };

    this.bind = function () {
        $('#trace-submit').off().click(() =>
            self.app.submit(() => self.empty())
        );

        $('#trace-stop').off().click(function () {
            self.stop = $(this).prop('checked');
            return true;
        });
        $('#trace-except').off().click(function () {
            self.except = $(this).prop('checked');
            return true;
        });

        $('#trace-type0').off().click(function () {
            self.type = 0;
            return self.render();
        });
        $('#trace-type1').off().click(function () {
            self.type = 1;
            return self.render();
        });
        $('#trace-type2').off().click(function () {
            self.type = 2;
            return self.render();
        });

        if (!self.app.project.single) {
            $('#trace-type2').hide();
        }

        $('#trace .trace-scount').off().click(function () {
            $(this).siblings().removeClass('tab-on');
            $(this).addClass('tab-on');
            return $('#trace-count').val($(this).attr('v'));
        });

        //生成计划
        return $('#trace-gen').off().click(function () {
            self.count = $('#trace-count').val();
            self.first = $('#trace-first').val();
            self.range = $('#trace-range').val();
            self.profit = $('#trace-profit').val();
            self.duplicate = $('#trace-duplicate').val();
            return self.render_data();
        });
    };

    this.render_data = function () {
        //计算追号
        let i;
        let index;
        self.genPlan();

        let html = "";

        for (i = 0, index = i; i < self.items.length; i++, index = i) {
            const item = self.items[index];
            let checked = '';
            if (item.selected) {
                checked = 'checked';
            }
            let current = '';
            if (self.app.issue.current_no === item.no) {
                current = '<span>[当前]</span>';
            }
            let disabled = '';
            if (!item.selected) {
                disabled = 'disabled';
            }

            let _cost_html = '<span>--</span>';
            if (item.selected) {
                const _cost = +self.app.project.cost;
                item.cost = changeMoneyToFixed(_cost * item.times);
                _cost_html = `\
<span class="cost" v="${index}">${item.cost}</span>元\
`;
            }

            html += `\
<tr>
    <td>${index}</td>
    <td align="left">
        <label>
            <input type="checkbox" ${checked} class="issueno" v="${index}">
            <span data-bind="text: no">${item.no}</span>
            ${current}
        </label>
    </td>
    <td>
      <input type="text" value="${item.times}" size="2" ${disabled} class='times'  v="${index}">
    </td>
    <td>
        ${_cost_html}
    </td>
    <td>${item.date}</td>
</tr>\
`;
        }

        const $view = $('#trace-data');
        $view.off().empty();
        $(html).appendTo($view);

        //bind

        $view.off();
        $view.delegate("input.issueno", "change", function () {
            index = $(this).attr('v');
            let times = 0;
            if ($(this).prop('checked')) {
                self.items[index].select = true;
                times = 1;
            } else {
                self.items[index].select = false;
            }

            return $view.find(`input.times[v='${index}']`).val(times).trigger('change');
        });

        return $view.delegate("input.times", "change", function () {
            let times = parseInt($(this).val());
            if (times < 1) {
                times = 0;
            }

            index = $(this).attr('v');
            self.items[index].times = times;

            if (times < 1) {
                $(this).prop('disabled', true);
            }
            if (times > 0) {
                $(this).prop('disabled', false);
            }

            //计算总数
            $view.find(`span.cost[v='${index}']`).text(changeMoneyToFixed(+self.app.project.cost * times));
            return self.calculateTotal();
        });
    };

    this.close = function () {
        self.items = [];
        self.total_cost = 0;
        self.total_count = 0;
        self.total_num = 0;
        self.visible = false;

        $('#trace').hide();
        return $('#project').show();
    };

    this.open = function () {
        $('#trace').show();
        $('#project').hide();
        self.visible = true;
        self.render();

        return window.scrollTo(0, document.body.scrollHeight);
    };

    this.gen = () => self.render();

    this.genPlan = function () {
        let _times, first, index, total;
        if (!self.visible) {
            return;
        }

        self.refreshIssues();

        //全部清空
        for (var item of Array.from(self.items)) {
            item.select = false;
            item.times = 0;
        }

        if (self.type === 0) {
            //同倍追号 first , total
            ({first} = self);
            total = self.count;
            for (index = 0; index < self.items.length; index++) {
                item = self.items[index];
                if (index < total) {
                    item.times = first;
                    item.selected = true;
                } else {
                    item.selected = false;
                }
            }

        } else if (self.type === 1) {
            //翻倍追号 total ,range ,duplicate
            first = +self.first || 1;
            total = self.count;
            const {range} = self;
            const {duplicate} = self;
            _times = 0;
            for (index = 0; index < self.items.length; index++) {
                item = self.items[index];
                if (index === 0) {
                    _times = 0;
                } else if ((index % range) === 0) {
                    _times++;
                }

                if (index < total) {
                    item.selected = true;
                    item.times = first * (Math.pow(duplicate, _times));
                } else {
                    item.selected = false;
                }
            }

        } else if (self.type === 2) {
            //利润率追号 first , profit, total
            first = +self.first;
            total = +self.count;
            const profit = +self.profit;

            if ((first <= 0) || (total <= 0) || (profit <= 0)) {
                return;
            }

            const cost = +self.app.project.cost;
            const prize = +self.app.project.prize;

            if ((cost <= 0) || (prize <= 0)) {
                return;
            }

            let totalCost = 0;

            if (profit >= (((prize * 100) / cost) - 100)) {
                return false;
            }

            for (index = 0; index < self.items.length; index++) {
                item = self.items[index];
                _times = index === 0 ? first : Math.ceil((((profit / 100) + 1) * totalCost) / (prize - (cost * ((profit / 100) + 1))));
                if (_times < first) {
                    _times = first;
                }

                if (index < total) {
                    totalCost += _times * cost;
                    item.selected = true;
                    item.times = _times;
                } else {
                    item.selected = false;
                }
            }
        }

        return self.calculateTotal();
    };

    this.calculateTotal = function () {
        if (!self.visible) {
            return;
        }

        const {project} = self.app;
        const betNum = project.num;

        const _cost = +project.cost;
        let cost = 0;
        let count = 0;
        let num = 0;

        for (let item of Array.from(self.items)) {
            const times = +item.times;

            if (times > 0) {
                count++;
                num += (betNum * times);
                cost += (_cost * times);
            }
        }

        self.total_cost = cost;
        self.total_count = count;
        self.total_num = num;

        $('#trace-total-count').text(count);
        $('#trace-total-num').text(self.app.project.items.length);
        return $('#trace-total-cost').text(changeMoneyToFixed(cost));
    };

    //获得&刷新追号奖期
    this.refreshIssues = function () {
        self.items = [];
        const {issues} = self.app.issue;
        const _current = self.app.issue.current_no;
        const _select = self.app.issue.select_no;

        return (() => {
            const result = [];
            for (let row of Array.from(issues)) {
                if ((row[0] >= _select) && (row[0] >= _current)) {
                    const issue = row[0];

                    let has = false;
                    for (let _row of Array.from(self.items)) {
                        if (_row.no === issue) {
                            has = true;
                        }
                    }

                    if (has) {
                        continue;
                    }

                    //增加
                    result.push(self.items.push({
                        no: issue,
                        selected: false,
                        times: 0,
                        cost: '0.00',
                        date: row[2]
                    }));
                }
            }
            return result;
        })();
    };

    return this;
};