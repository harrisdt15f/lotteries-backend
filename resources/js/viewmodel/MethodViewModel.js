import methods from "../game/config/method"
import {calculate,random} from "../game"
import {changeMoneyToFixed} from "../common/common"
import * as func from '../game/funs'

export function MethodViewModel (opt, app) {
    this.opt = opt;
    this.app = app;
    const self = this;

    this.state = {};

    const rechoiceCodes = function (codes) {
        const {state} = self;

        //选球类型
        if (state.type === 'multi') {
            let i, j, row;
            const _choice = state.choices;
            for (i = 0; i < _choice.length; i++) {
                row = _choice[i];
                for (j = 0; j < row.length; j++) {
                    const col = row[j];
                    _choice[i][j] = false;
                }
            }

            const rows = codes.split("|");
            for (i = 0; i < rows.length; i++) {
                row = rows[i];
                const _cols = state.layout[Object.keys(state.layout)[i]];
                for (let v of Array.from(row.split("&"))) {
                    if (v === '') {
                        continue;
                    }
                    if ((state.pattern !== 'lotto') && !state.btnStr) {
                        v = +v;
                    }
                    j = _cols.indexOf(v);
                    _choice[i][j] = true;
                }
            }

            state.choices = _choice;
        }
        if (state.type === 'text') {
            return state.input = codes;
        }
    };

    this.init = function () {
    };

///******************************初始化玩法 **************************/
    this._init_method = function (keep) {
        let i, row;
        const pg = self.app.prizes[self.state.method];
        [self.state.__count, self.state.__total, self.state.__prize
        ] = Array.from([
            +pg['count'],
            +pg['total'],
            +pg['prize']
        ]);

        self.state.rx = !!self.state.pc;

        let _aider = [];
        const _quicks = [];
        const _choices = [];
        if (self.state.layout) {
            const iterable = Object.keys(self.state.layout);
            for (i = 0; i < iterable.length; i++) {
                row = iterable[i];
                _aider[i] = [];
                _choices[i] = [];
                _quicks[i] = '';
                for (let j = 0; j < self.state.layout[row].length; j++) {
                    const col = self.state.layout[row][j];
                    _choices[i][j] = false;
                }
            }
        } else {
            _aider = [[]];
        }

        //任选
        const _position = {};
        let _hasPosition = false;
        if (self.state.rx) {
            const iterable1 = Object.keys(self.app.lottery.positions);
            for (i = 0; i < iterable1.length; i++) {
                row = iterable1[i];
                if (Array.from(self.state.pc).includes(row)) {
                    _hasPosition = true;
                    _position[row] = true;
                } else {
                    _position[row] = false;
                }
            }
        }


        self.state.__hasPosition = _hasPosition;
        self.state.choices = _choices;
        self.state.__quicks = _quicks;

        if (!keep) {
            self.state.__position = _position;
            self.state.__positionDesc = self.state.rx ? [self.state.pc.length, 1] : [0, 0];
            //最大奖金
            self.state.maxtype = 0;
        }

        if ((self.state.layout == null)) {
            self.state.layout = [];
        }
        if ((self.state.lengthen == null)) {
            self.state.lengthen = false;
        }

        self.state.pattern = self.app.pattern;

        self.state.prize = 0;
        self.state.point = 0;

        self.state.num = 0;
        self.state.cost = 0;
        self.state.input = '';
        self.state.inputcodes = '';

        return ;
    };

    ///******************************输出玩法 **************************/
    this.render = function (menuid, menu2id, methodid, keep) {
        self.state = methods[self.app.pattern][menuid][menu2id][methodid];

        self._init_method(keep);

        $('#method-desc').html(self.state.desc);
        $('#method-help').html(self.state.help);
        $('#method-example').html(self.state.example);

        if (self.state.type === 'multi') {
            this.view = $('#ball-multi .ball');
            this.position_view = $('#ball-multi .position');
            $('#ball-text').hide();
            $('#ball-multi').show();
            self.render_multi();
        } else {
            this.view = $('#ball-text .ball');
            this.position_view = $('#ball-text .position');
            $('#ball-multi').hide();
            $('#ball-text').show();
            self.render_text();
        }


        $('#random1').off().click(() => self.random(1));

        $('#random5').off().click(() => self.random(5));

        self.render_position();
        self.render_point();

        self.render_statistics();

        return $('#add').off().click(function () {
            if (self.app.project.add()) {
                return self.render(menuid, menu2id, methodid, true);
            }
        });
    };

    ///******************************单式 **************************/
    this.optimize = function (t) {
        if (self.state.type === 'multi') {
            return;
        }
        if (+t === 2) { //错误项
            return self.state.input = self.state.inputcodes;
        } else if (+t === 1) { //重复项
            const tmp = self.state.inputcodes.split(',');
            return self.state.input = func.array_unique3(tmp).join(',');
        } else {
            return self.state.input = '';
        }
    };

    this.render_text = function () {
        const html = `\
<div class="main-single-entry">
  <div class="main-balls-import">
      <div href="javascript:;" id="singleUpload" class="btn btn-blue btn-ball-import">导入注单</div>
      <div class="btn-tab-list import-clean-list">
          <a href="javascript:;" class="btn-tab btn-red optimize" v="1">删除重复项</a>
          <a href="javascript:;" class="btn-tab btn-red optimize" v="2">删除错误项</a>
          <a href="javascript:;" class="btn-tab btn-red optimize" v="0">清空文本框</a>
      </div>
  </div>
  <div class="balls-import-box">
      <textarea class="balls-import-txt" id='ball-text-v' focucmsg="说明：
1、每一注号码之间的间隔符支持 回车 逗号[,] 分号[;] 每注内间隔使用空格即可。
2、文件格式必须是.txt格式。
3、导入文本内容后将覆盖文本框中现有的内容。"></textarea>
  </div>
</div>\
`;

        self.view.off().empty();
        $(html).appendTo(self.view);

        const $text = $('#ball-text-v');
        $text.off();
        $text.bind('input propertychange','textarea',function () {
            self.state.input = $.trim($(this).val());
            return self.calculate();
        });

        $text.val($text.attr("focucmsg")).css("color", "#fff");
        $text.focus(function () {
            if ($text.val() === $text.attr("focucmsg")) {
                return $text.val('').css("color", "#fff");
            }
        });

        $text.blur(function () {
            if (!$text.val()) {
                return $text.val($text.attr("focucmsg")).css("color", "#fff");
            }
        });

        self.view.find('.optimize').click(function () {
            self.optimize($(this).attr('v'));
            $text.val(self.state.input);
            return self.calculate();
        });

        return $("#singleUpload").off().uploadFile({
            url: self.app.opt.apis.upload,
            fileName: "fileToUpload",
            acceptFiles: "text/*",
            autoSubmit: true,
            returnType: "json",
            allowedTypes: "txt",
            showStatusAfterSuccess: false,
            maxFileSize: 1000 * 1024,
            dragDropStr: '',
            multiple: false,
            dragDrop: false,
            showCancel: false,
            showAbort: false,
            showDone: false,
            showDelete: false,
            showError: false,
            showStatusAfterError: false,
            showFileCounter: false,

            uploadStr: '<span class="ico-import"></span><span>导入注单</span>',
            onSuccess(files, data, xhr, pd) {
                if (data && ((data.errno % 100) === 0)) {
                    if (data && ((data.errno % 100) === 0)) {
                        return $text.val(data.data.content || '').trigger('change');
                    }
                } else {
                    return $.alert(data.error);
                }
            },
            onSelect(files) {
                if (files[0].size > (1000 * 1024)) {
                    $.alert("图片尺寸过大, 不能超过1M.");
                    return false;
                } else if (files[0].type && ("text/plain" !== files[0].type)) {
                    $.alert("无效的文件类型.");
                    return false;
                } else {
                    return true;
                }
            },

            onError(files, status, errMsg, pd) {
                $.alert(errMsg);
                return false;
            }
        });
    };


    ///******************************复式 **************************/
    this.render_multi = function () {
        let html = "";

        let $x = 0;
        for (let $index in self.state.layout) {
            var $b, $y;
            const $data = self.state.layout[$index];
            let ball = '';

            for ($y = 0; $y < $data.length; $y++) {
                $b = $data[$y];
                ball += `\
<li>
    <a href="javascript:;" class="ball" x="${$x}" y="${$y}">${$b}</a>
</li>\
`;
            }

            let quick = '';
            if ($index !== '胆码') {
                for ($y = 0; $y < self.state.buttons.length; $y++) {
                    $b = self.state.buttons[$y];
                    quick += `\
<li>
  <a href="javascript:;" class="quick" x="${$x}" y="${$y}">${$b}</a>
</li>\
`;
                }
            }

            html += `\
<div class="main-ball-list">
    <div class="ball-list-name"><span>${$index}</span></div>
    <ul class="main-ball-content">
    ${ball}
    </ul>
    <ul class="main-ball-control">
    ${quick}
    </ul>
</div>\
`;

            $x++;
        }

        self.view.off().empty();
        $(html).appendTo(self.view);
        return self.bind_multi();
    };

    ///******************************绑定复式 **************************/
    this.bind_multi = function () {
        self.view.off();
        self.view.delegate("li a.ball", "click", function () {
            const $this = $(this);
            $this.parent().toggleClass('ball-on');
            const x = +$this.attr('x');
            const y = +$this.attr('y');

            const _choice = self.state.choices;

            if (self.state.limitSelectedCount && (_choice[x][y] === false)) {
                let count = 0;
                for (let c = 0; c < _choice[x].length; c++) {
                    const col1 = _choice[x][c];
                    if (y !== c) {
                        if (col1) {
                            count++;
                        }
                        if ((count >= self.state.limitSelectedCount[x]) && col1) {
                            _choice[x][c] = false;
                            self.view.find(`li a.ball[x="${x}"][y="${c}"]`).parent().removeClass('ball-on');
                        }
                    }
                }
            }

            if (self.state.limitSelectedSomePosition) {
                for (let _row = 0; _row < _choice.length; _row++) {
                    const _rows = _choice[_row];
                    if (_row !== x) {
                        if (_choice[_row][y] === true) {
                            _choice[_row][y] = false;
                            self.view.find(`li a.ball[x="${_row}"][y="${y}"]`).parent().removeClass('ball-on');
                        }
                    }
                }
            }

            self.state.choices = _choice;
            self.state.choices[x][y] = !self.state.choices[x][y];

            return self.calculate();
        });

        return self.view.delegate("li a.quick", "click", function () {
            let _col, i, item;
            const $this = $(this);
            $this.parent().parent().children().removeClass('ball-on');
            $this.parent().toggleClass('ball-on');

            const x = +$this.attr('x');

            const _choice = self.state.choices;
            const rows = _choice[x];
            const button = $this.text();
            const row = x;

            self.view.find(`li a.ball[x="${x}"]`).parent().removeClass('ball-on');

            for (let col = 0; col < rows.length; col++) {
                item = rows[col];
                _choice[row][col] = false;
            }

            const {lottery} = self.app;

            if ((lottery.pattern === 'lotto') || (lottery.pattern === 'pk10')) {
                switch (button) {
                    case '全':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            _choice[row][i] = true;
                        }
                        break;
                    case '大':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (i >= (rows.length / 2)) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '小':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (i < (rows.length / 2)) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '奇':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (((i + 1) % 2) === 1) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '偶':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (((i + 1) % 2) === 0) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                }
            } else {
                switch (button) {
                    case '全':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            _choice[row][i] = true;
                        }
                        break;
                    case '大':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (i >= (rows.length / 2)) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '小':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if (i < (rows.length / 2)) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '奇':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if ((i % 2) === 1) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                    case '偶':
                        for (i = 0; i < rows.length; i++) {
                            item = rows[i];
                            if ((i % 2) === 0) {
                                _choice[row][i] = true;
                            }
                        }
                        break;
                }
            }

            if (self.state.limitSelectedSomePosition) {
                for (let _row = 0; _row < _choice.length; _row++) {
                    const _rows = _choice[_row];
                    if (_row !== row) {
                        for (_col = 0; _col < _rows.length; _col++) {
                            item = _rows[_col];
                            if ((item === true) && (_choice[row][_col] === true)) {
                                _choice[_row][_col] = false;
                                self.view.find(`li a.ball[x="${_row}"][y="${_col}"]`).parent().removeClass('ball-on');
                            }
                        }
                    }
                }
            }

            self.state.choices = _choice;

            //设为选中
            for (_col = 0; _col < self.state.choices[row].length; _col++) {
                item = self.state.choices[row][_col];
                if (item === true) {
                    self.view.find(`li a.ball[x="${row}"][y="${_col}"]`).parent().addClass('ball-on');
                }
            }

            return self.calculate();
        });
    };


    ///******************************输出任选位置 **************************/
    this.render_position = function () {
        let __position;
        let html = "";
        if (self.state.__hasPosition) {
            __position = self.app.lottery.positions;
            const position = self.state.__position;
            const positionDesc = self.state.__positionDesc;

            //任选位置
            let phtml = "";
            for (let $index in position) {
                const $data = position[$index];
                let c = '';
                if ($data) {
                    c = 'checked';
                }

                phtml += `\
<label>
<input type="checkbox" ${c} k="${$index}">
<span>${__position[$index]}</span>
</label>\
`;
            }

            html += `\
<div class="main-optional-txt">
${phtml}
<span>温馨提示：你选择了<strong class="txt-red" >${positionDesc[0]}</strong>个位置，系统自动根据位置组合成<strong class="txt-red" >${positionDesc[1]}</strong>个方案</span>
</div>\
`;
        }

        self.position_view.off().empty();
        $(html).appendTo(self.position_view);

        return self.position_view.find('input').click(function () {
            self.state.__position[$(this).attr('k')] = $(this).prop('checked');
            self.calculate();
            return self.render_position();
        });
    };


    ///******************************计算注数 **************************/
    this.calculate = function () {
         calculate(self.state,self.state);

        //刷新
        return self.render_statistics();
    };


    ///******************************输出统计信息 **************************/
    this.render_statistics = function () {
        $('#cost').text(changeMoneyToFixed(self.state.cost * self.app.times * self.app.mode));
        return $('#num').text(self.state.num);
    };

    //设置饭店奖金
    //设置饭店奖金
    this.render_point = function () {
        if (self.app.dyprize) {
//最大奖金
            let option2;
            let _diff = +self.app.user.point;
            let _prize = self.state.__prize + ((self.state.__total * 2 * (_diff / 100)) / self.state.__count);
            let _point = (+self.app.user.maxpoint - +self.app.user.point).toFixed(1);
            const _prize1 = Math.round(_prize * 100) / 100;

            let sel1 = '';
            if (self.state.maxtype === 0) {
                sel1 = 'selected';
            }
            const option1 = `\
<option value="${_point}" ${sel1}  prize="${_prize1}">${_prize1}-${_point}%</option>\
`;

            //最大返点
            _diff = 0;
            _prize = self.state.__prize + ((self.state.__total * 2 * (_diff / 100)) / self.state.__count);
            _point = self.app.user.maxpoint;
            const _prize2 = Math.round(_prize * 100) / 100;

            if (_prize1 !== _prize2) {
                let sel2 = '';
                if (self.state.maxtype === 1) {
                    sel2 = 'selected';
                }
                option2 = `\
<option value="${_point}" ${sel2} prize="${_prize2}">${_prize2}-${_point}%</option>\
`;
            } else {
                option2 = '';
            }

            const select = `<select>${option1}${option2}</select>`;

            $("#pointset").off().html(select);

        } else {
            $("#pointset").off().html('');
        }

        return self.bind_point();
    };

    this.bind_point = function () {
        const {lottery} = self.app;

        const $select = $('#pointset').find('select');
        $select.change(function () {
            self.state.maxtype = $(this)[0].selectedIndex;
            self.state.point = $(this).val();
            return self.state.prize = $select.find('option:selected').attr('prize');
        });

        $select.trigger('change');
    };


    this.random = function (times) {
        const {state} = self;
        self.render(self.app.crowd.menuid, self.app.crowd.menu2id, self.app.crowd.methodid);
        const results = random(state, times);
        for (let result of Array.from(results)) {
            rechoiceCodes(result + '');
            if (state.type === 'multi') {
                calculate(state,state);
            } else {
                calculate(state,state);
            }

            self.app.project.add();
        }

        rechoiceCodes('');
        self._init_method();


    };

    return this;
};