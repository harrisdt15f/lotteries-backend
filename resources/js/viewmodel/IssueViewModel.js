

export function IssueViewModel (opt,app){
  this.opt = opt;
  this.app = app;
  const self = this;

  this.current_no='';
  this.issues=[];
  this.traceIssues=[];

  this.select_no='';

  this.current_remainTime='';

  this.before_no='';
  this.before_remainTime='';
  this.before_state=0;
  this.before_opencode=[];

  this.fetchNumberInterval = 10000;        //抓号间隔 ms

  this.open_list_first=false;

  const _timestamp=d=> Math.round(new Date(d.replace(/[\-\u4e00-\u9fa5]/g, "/")).getTime()/1000);

  const _diff=function(t){
    if (t>0) {
      return {
      day: Math.floor(t / 86400),
      hour: Math.floor((t % 86400) / 3600),
      minute: Math.floor((t % 3600) / 60),
      second: Math.floor(t % 60)
      };
    } else {
      return {
      day: 0,
      hour: 0,
      minute: 0,
      second: 0
      };
    }
  };

  const fftime=function(n){
    if (Number(n)<10) { return `0${Number(n)}`; } else { return Number(n); }
  };

  //初始化
  this.init=function(){
    self.sel_current_no=$('#current_no');
    self.sel_current_remainTime=$('#current_remainTime');

    self.sel_before_no=$('#before_no');
    self.sel_before_remainTime=$('#before_remainTime');

    self.sel_before_desc=$('#before_desc');
    //0 第 <i id="before_no"></i> 期开奖号码
    //1 开奖倒计时: <i style="color:#ff0000" id="before_remainTime">00:14</i>
    //2 开奖中

    self.sel_before_opencode=$('#before_opencode');
    //0 <li>?</li>
    //1 <li class="open-num"></li>
    //2 <li></li>

    if (self.opt.issues.datas) { self.setIssues(self.opt.issues.datas); }

    return setTimeout(function() {
      if (!self.open_list_first) { return self.refresh_history(); }
    }
    ,3000);
  };

  //初始化渲染
  this.render=function(){};


  this.setIssues =function(data){
    clearTimeout(self.refreshIssuesTimer);
    clearTimeout(self.refreshIssuesSecTimer);

    clearTimeout(self.refreshCurrentIssueTimer);
    clearTimeout(self.refreshBeforeIssueTimer);
    clearTimeout(self.fetchNumberTimer);
    self.fetchNumberIssue=undefined;
    self.issues=data.issues;

    const _now=data.now;
    let _before=data.before;
    let _current=self.issues[0];
    let _next=self.issues[1];

    const _pool=self.opt.pool || function() {};
    //更新奖池
    if (self.app.lottery.pool && (data.pool != null)) {
       _pool(self.app._before_pool,data.pool || 0);
       self.app._before_pool=data.pool;
     }

    //0 no
    //1 saleStartTime
    //2 saleEndTime
    //3 waitInputStartTime
    //4 code

    const offset = Math.round(new Date().getTime()/1000) - _timestamp(_now);

    self.setBeforeIssue(_before,_current,offset);
    self.setCurrentIssue(_current,_before,offset);

    var timer =function() {
      //每秒刷新
      const _remainTime= _timestamp(_current[2]) - (Math.round(new Date().getTime()/1000)-offset);

      if (+_remainTime <= 0) {
        if (self.refreshIssuesTimer) { clearTimeout(self.refreshIssuesTimer); }
        self.refreshIssuesTimer = setTimeout(self.refreshIssues,30000);  //10秒后重新刷新奖期
        self.issues.shift();
        _before=_current;
        _current=self.issues[0];
        _next=self.issues[1];
        self.setBeforeIssue(_before,_current,offset);
        self.setCurrentIssue(_current,_before,offset);
      }

      if (self.refreshIssuesSecTimer) { clearTimeout(self.refreshIssuesSecTimer); }
      return self.refreshIssuesSecTimer=setTimeout(timer,1000);
    };
    return timer();
  };


  this.refreshIssuesTimer=undefined;
  this.refreshIssuesSecTimer=undefined;

  this.refreshCurrentIssueTimer=undefined;
  this.refreshBeforeIssueTimer=undefined;
  this.fetchNumberTimer=undefined;
  this.fetchNumberIssue=undefined;

  this.setOpencode=function(){
    let i;
    let html='';
    if (self.before_state===0) {
      for (i of Array.from(self.before_opencode)) { html+='<li>?</li>'; }
    } else if (self.before_state===1) {
      self.sel_before_desc.html('开奖中');
      for (i of Array.from(self.before_opencode)) { html+='<li class="open-num"></li>'; }
    } else if (self.before_state===2) {
      self.sel_before_desc.html('');
      for (i = 0; i < self.before_opencode.length; i++) { const v = self.before_opencode[i]; html+=`<li>${v}</li>`; }
    }

    return self.sel_before_opencode.html(html);
  };

  this.warning_bar=undefined;
  this.setCurrentIssue = function(issue,before,offset){
    const select=self.select_no;

    if (before[0] === select) {
      if (!self.app.lottery.fastopen) { $.alert(`<i class='txt-red'>${before[0]}</i>期已结束,当前期为<i class='txt-green'>${issue[0]}</i><br>投注时请注意期号!!!`); }
    }

    //if self.app.project.items.length > 0 && before[0] == select
    //  $.alert(before[0]+"期已结束,当前期为"+issue[0]+"<br>投注时请注意期号!!!") if not self.app.lottery.fastopen

    clearTimeout(self.refreshCurrentIssueTimer);

    //
    self.current_no= issue[0];
    self.sel_current_no.text(self.current_no);
    if (!select || (issue[0] >= select)) {
      self.select_no=issue[0];
    }

    //刷新追号
    self._setIssues();

    var timer =function() {
      let remainTime;
      const _remainTime= _timestamp(issue[2]) - (Math.round(new Date().getTime()/1000)-offset);
      const df=_diff(_remainTime);
      if (df.hour===0) {
        remainTime = fftime(df.minute)+':'+fftime(df.second);
      } else {
        remainTime = fftime(df.hour)+':'+fftime(df.minute)+':'+fftime(df.second);
      }

      self.current_remainTime=remainTime;
      self.sel_current_remainTime.text(self.current_remainTime);
      self.refreshCurrentIssueTimer=setTimeout(timer,1000);

      //倒数20秒时提醒
      if (_remainTime<=20) {
        if (!self.warning_bar) {
          return $.nearWarning(`投注:<span style="color:red" id="near_warning">${self.current_remainTime}<span>`,20*1000, (layero,index)=> self.warning_bar=layero
          ,() => self.warning_bar=undefined);
        } else {
          return $(self.warning_bar).find('#near_warning').text(self.current_remainTime);
        }
      }
    };

    return timer();
  };

  this.setBeforeIssue = function(issue,current,offset){
    clearTimeout(self.refreshBeforeIssueTimer);

    self.before_state=0;
    self.before_no=issue[0];
    self.sel_before_no.text(self.before_no);
    if (self.app.lottery['len']===3) {
      self.before_opencode=['','',''];
    } else if (self.app.lottery['len']===10) {
      self.before_opencode=['','','','','','','','','',''];
    } else {
      self.before_opencode=['','','','',''];
    }

    const isopen=self.onFetchCode(issue[0],issue[4]);

    var timer =function() {
      const _remainTime= _timestamp(issue[3]) - (Math.round(new Date().getTime()/1000)-offset);
      if  (((+_remainTime) > 0) && (self.before_state===0)) {
        if (self.app.lottery['fastopen']) {
          self.setOpencode();
          return;
        }

        const df=_diff(_remainTime);
        const remainTime = fftime(df.minute)+':'+fftime(df.second);
        self.before_remainTime=remainTime;
        self.before_state=0;
        self.setOpencode();
        //倒计时
        if (!self.sel_before_remainTime.length>0) {
          self.sel_before_desc.html('开奖倒计时: <i style="color:#ff0000" id="before_remainTime">00:14</i>');
          self.sel_before_remainTime=$('#before_remainTime');
        }

        self.sel_before_remainTime.text(self.before_remainTime);

      //已开奖
      } else if (isopen || (self.before_state===2)) {
        //已开奖
        clearTimeout(self.refreshBeforeIssueTimer);
        self.before_state=2;

        self.setOpencode();

        return;

      //开奖中
      } else {
        self.before_state=1;
        if (!self.fetchNumberTimer && (self.fetchNumberIssue!==issue[0])) { self.fetchNumber(issue); }

        self.setOpencode();
        return;
      }

      return self.refreshBeforeIssueTimer=setTimeout(timer,1000);
    };
    return timer();
  };

  this.onFetchCode = function(issueno,code){
    //开奖号码
    if ($.trim(code).length > 0) {
      self.before_opencode=code.split(',');
      if (self.fetchNumberTimer) { clearTimeout(self.fetchNumberTimer); }
      self.fetchNumberTimer=undefined;
      self.fetchNumberIssue=undefined;
      self.before_state=2;
      self.setOpencode();
      setTimeout(() => self.fetchOtherList()
      ,0);

      return true;
    }
  };

  this._setIssues = function() {
    self.render_issues();
    if (self.app.trace.visible) { return self.app.trace.render_data(); }
  };

  this.render_issues=function(){
    const { select_no }=self;
    const $view=$('#issues');

    let html='';
    for (let item of Array.from(self.issues)) {
      if (item[0] >= self.current_no) {
        const issue_no=item[0];
        let select='';
        if (issue_no===select_no) { select='selected'; }
        html+=`\
<option value='${issue_no}' ${select}>${issue_no}</option>\
`;
      }
    }

    $view.off().empty();
    $(html).appendTo($view);

    return $view.off().change(function() {
      return self.select_no=$(this).val();
    });
  };
      //处理追号那里

  //刷新奖期 返回的是处理方式
  this.refreshIssues = ()=>
    $.get(self.opt['apis']['issue'],{kind:self.app.lotteryid},data=> self.setIssues(data.data.datas)
    ,'json')
  ;


  this.fetchOtherListTimer=undefined;
  this.fetchOtherList = function(){
    if (self.fetchOtherListTimer) { return; }

    clearTimeout(self.fetchOtherListTimer);
    self.fetchOtherListTimer = setTimeout(function() {
      self.app.order.refresh();
      self.refresh_history();
      return self.fetchOtherListTimer=undefined;
    }
    ,100);
     
  };

  //抓号 返回的是处理方式
  this.fetchNumber = function(issue){
    clearTimeout(self.fetchNumberTimer);
    self.fetchNumberIssue = issue[0];
    var timer =function() {
      $.get(self.opt['apis']['code'],{kind:self.app.lotteryid,issueno:self.before_no},data => self.onFetchCode(issue[0],data.data.code)
      ,'json');
      return self.fetchNumberTimer=setTimeout(timer,self.fetchNumberInterval);
    };

    return setTimeout(timer,5000);
  };


  //刷新开奖历史
  this.refresh_history_end=true;
  this.refreshTimer=undefined;
  this.refresh_history = function(){
    //获取投注历史 防止刷新太过频繁1
    if (!self.refresh_history_end) { return; }
    self.refresh_history_end=false;

    return self.refreshTimer=setTimeout(() =>
      $.get(self.app.opt['apis']['openList'],{kind:self.app.lotteryid,count:10},function(data){
        self.refreshTimer=undefined;
        self.open_list_first=true;

        setTimeout(() => self.refresh_history_end=true
        ,2000);

        if ((data.errno % 100) === 0) {
          const history=[];
          for (let i = 0; i < data.data.length; i++) {
            const item = data.data[i];
            history.push(item);
          }

          return self.render_history(history);
        }
      }
      ,'json')
    
    ,100);
  };

  this.render_history=function(history){
    let html='';
    for (let $data of Array.from(history)) {
      let ccss='';
        for (let $v of Array.from($data.code.split(' '))) {
            ccss +=`<i>${$v}</i>`;
        }

      html+=`\
<li>
    <span class="main-lottery-issue">${$data.issue}</span>
    <span class="main-lottery-issueNum">
        ${ccss}
    </span>
</li>\
`;
    }

    const $view=$('#open-list');
    $view.off().empty();
    return $(html).appendTo($view);
  };


  return this;
};