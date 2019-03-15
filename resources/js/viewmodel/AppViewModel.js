
import prizes from "../game/config/prizes";
import lotteries from "../game/config/lottery";
import setting from "../game/config/setting";

import {CrowdViewModel,IssueViewModel,MethodViewModel,OrderViewModel,ProjectViewModel,TraceViewModel} from "."
import {changeMoneyToFixed} from "../common/common"

export function AppViewModel (opt) {
    const self = this;

    ///******************************参数配置 **************************/
    const ps = {
        lotteryid: 'cqssc',
        user: {}
    };

    this.opt = $.extend({}, ps, opt || {});

    ///******************************模型 **************************/
    this.issue = new IssueViewModel(this.opt, this);
    this.crowd = new CrowdViewModel(this.opt, this);
    this.method = new MethodViewModel(this.opt, this);
    this.project = new ProjectViewModel(this.opt, this);
    this.trace = new TraceViewModel(this.opt, this);
    this.order = new OrderViewModel(this.opt, this);
    this._before_pool = 0;

    ///******************************全局变量 **************************/

    this.times = 1;
    this.mode = 1;
    this.point = 0;

    this.user = {
        id: this.opt['user']['id'],
        balance: this.opt['user']['balance'],
        point: this.opt['user']['point'],
        maxpoint: this.opt['user']['maxpoint']
    };

    this.lotteryid = this.opt['lotteryid'];
    this.lottery = lotteries[this.lotteryid];
    this.pattern = this.lottery['pattern'];
    this.prizes = prizes[this.pattern];
    this.trend = this.lottery['trend'];
    this.dyprize = !!this.lottery['dyprize'];

    this.rxs = {'任选二': true, '任选三': true, '任选四': true};

    ///******************************初始化 **************************/
    //初始化
    this.init = function () {
        //初始化绑定
        //初始化奖期区
        self.issue.init();
        if ((self.lottery.custom == null)) {
            //初始化玩法区
            self.crowd.init();
            //初始化投注区
            self.method.init();
            //初始化投注区
            self.project.init();
            //初始化追号区
            self.trace.init();
            //初始化投注历史区
            self.order.init();
            self.render();
        }
        return self.listen();
    };

    this.listen = function () {
        window.Echo.private('User.' + self.user.id)
        .listen('.userInfo', function(info) {
            return self.setUser(info);
        })
        .listen('.issueOpen', function(e) {
            if (e.datas != null) {
                self.issue.setIssues(e.datas);
            }
        })
        .listen('.betFinish', function(e) {
            return self.order.refresh(e.lotteryid);
        });

        window.Echo.channel('Lottery.' + self.lotteryid)
        .listen('.issueOpen', function(e) {
            if (e.datas != null) {
                self.issue.setIssues(e.datas);
            }
        })
        .listen('.betFinish', function(e) {
            return self.order.refresh(e.lotteryid);
        });
    };

    this.setUser = function (info) {
        if (info.balance != null) {
            self.user.balance = info.balance;
        }
        if (info.point != null) {
            self.user.maxpoint = self.getMaxPoint(info.point);
            self.user.point = self.getUserPoint(info.point);
            //更新返点变化
            return self.method.render_point();
        }
    };

    this.getMaxPoint = function (point) {
        const {lottery} = self;
        const datum = +setting['point'] - +lottery['point'];
        const $point = point - datum;
        return $point.toFixed(2);
    };

    this.getUserPoint = function (point) {
        const {lottery} = self;
        point = self.getMaxPoint(point);
        if (point > +lottery['point']) {
            point = +lottery['point'];
        }
        if (point <= 0) {
            point = 0;
        }
        return point;
    };

    this.render = function () {
        //投注历史切换
        $('#project-current').off().click(() => self.project.switch_project());

        $('#project-history').off().click(() => self.project.switch_history());

        $('#project-current').trigger('click');

        //初始化倍数  模式
        $('#times').val(self.times);

        //圆角分模式
        $('#mode-y,#mode-j,#mode-f,#mode-l').off().click(function () {
            const $this = $(this);
            $this.siblings().removeClass('tab-on');
            $this.addClass('tab-on');
            self.mode = +$this.attr('v');

            return self.method.calculate();
        });

        switch (self.mode) {
            case 1:
                $('#mode-y').trigger('click');
                break;
            case 0.1:
                $('#mode-j').trigger('click');
                break;
            case 0.01:
                $('#mode-f').trigger('click');
                break;
            case 0.001:
                $('#mode-l').trigger('click');
                break;
        }


        //倍数
        const fn = function (times) {
            times = parseInt(times);
            if ((times > 10000) || (times < 1)) {
                return;
            }
            self.times = times;
            $('#times').val(self.times);
            return self.method.calculate();
        };

        $('#times').change(() => fn($('#times').val()));
        $('#times-add').click(() => fn(self.times + 1));
        return $('#times-reduce').click(() => fn((self.times - 1) > 0 ? self.times - 1 : 1));
    };

    ///******************************提交投注**************************/
    //提交投注
    this.submit = function () {
        if (self.project.num < 1) {
            $.alert("请先添加投注项");
            return;
        }

        return self._submit();
    };

    this._submit = function () {
        let _cost, _num, issue_desc, item;
        const _projects = [];
        const __projects = [];
        for (let project of Array.from(self.project.items)) {
            item = {
                methodid: project.methodid,
                codes: project.codes,
                num: project.num,
                times: project.times,
                mode: project.mode,
                point: project.point
            };

            if (project.position != null) {
                item['position'] = project.position;
            }
            _projects.push(item);

            let v = project._codes.substr(0, 80);
            if (v !== project.codes) {
                v += '...';
            }
            __projects.push({
                name: project.name,
                codes: v
            });
        }

        let _count = 1;
        let _stop = false;
        let _except = false;
        const _trace = self.trace.visible;
        const _issuenos = {};
        if (_trace) {
            _count = +self.trace.total_count;
            _num = +self.trace.total_num;
            _cost = +self.trace.total_cost;
            _stop = self.trace.stop;
            _except = self.trace.except;
            for (item of Array.from(self.trace.items)) {
                if (item.times < 1) {
                    continue;
                }
                _issuenos[item.no] = item.times;
            }

            const array = Object.keys(_issuenos).sort(), first = array[0], last = array[array.length - 1];
            if (first !== last) {
                issue_desc = `从<strong class="txt_color_r">${first}</strong>期到<strong class="txt_color_r">${last}</strong>期`;
            } else {
                issue_desc = `第<strong class="txt_color_r">${first}</strong>期`;
            }
        } else {
            _num = +self.project.num * self.project.times;
            _cost = +self.project.cost * self.project.times;
            _issuenos[self.issue.select_no] = self.project.times;

            issue_desc = `第<strong class="txt_color_r">${self.issue.select_no}</strong>期`;
        }

        const bets = {
            lotteryid: self.lotteryid,
            trace: +_trace,
            tracewinstop: +_stop,
            traceexceptstop: +_except,
            issuenos: _issuenos,
            projects: _projects,
            totalnum: _num,
            totalCost: _cost
        };

        if (bets.totalCost > self.user.balance) {
            $.alert("您的余额不足，请确认！");
            return;
        }

        const title = _trace ? '追号确认' : '投注确认';

        return $.confirmBet({
                trace: _trace,
                issue_desc,
                lottery: self.lottery['name'],
                count: _count,
                num: _num,
                pcnt: self.project.items.length,
                cost: changeMoneyToFixed(_cost),
                projects: __projects
            }
            , () => $.post(self.opt.apis.bets, bets, self.onSubmit)
            , function () {
            });
    };

    //快速投注
    this.fastSubmit = function (project, times, onSubmit) {
        const _projects = [];
        const __projects = [];

        onSubmit = onSubmit || function () {
        };

        const item = {
            methodid: project.methodid,
            codes: project.codes,
            num: project.num,
            times: project.times,
            mode: project.mode,
            point: project.point
        };

        if (project.position != null) {
            item['position'] = project.position;
        }
        _projects.push(item);

        let v = project._codes.substr(0, 80);
        if (v !== project.codes) {
            v += '...';
        }
        __projects.push({
            name: project.name,
            codes: v
        });

        const _count = 1;
        const _stop = false;
        const _except = false;
        const _trace = false;
        const _issuenos = {};

        const _num = +project.num * times;
        const _cost = +project.cost * times;
        _issuenos[self.issue.select_no] = times;

        const issue_desc = `第<strong class="txt_color_r">${self.issue.select_no}</strong>期`;

        const bets = {
            lotteryid: self.lotteryid,
            trace: +_trace,
            tracewinstop: +_stop,
            traceexceptstop: +_except,
            issuenos: _issuenos,
            projects: _projects,
            totalnum: _num,
            totalCost: _cost
        };

        if (bets.totalCost > self.user.balance) {
            $.alert("您的余额不足，请确认！");
            return;
        }

        const title = _trace ? '追号确认' : '投注确认';

        return $.confirmBet({
                trace: _trace,
                issue_desc,
                lottery: self.lottery['name'],
                count: _count,
                num: _num,
                pcnt: 1,
                cost: changeMoneyToFixed(_cost),
                projects: __projects
            }
            , () => $.post(self.opt.apis.bets, bets, onSubmit)
            , function () {
            });
    };

    this.onSubmit = function (rst) {
        self.project.empty();
        self.trace.close();

        if ((rst.errno % 100) !== 0) {
            $.alert(rst.error);
            return;
        }

        self.project.switch_history();

        return setTimeout(function () {
                //切换到历史界面
                self.order.refresh();
                //如果是即开型 则设为开奖中
                if (self.lottery.fastopen) {
                    self.issue.before_state = 1;
                    return self.issue.setOpencode();
                }
            }
            , 0);
    };

    return this;
};