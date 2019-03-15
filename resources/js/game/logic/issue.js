const issues = {};

var _diff = function (t) {
    if (t > 0) {
        return {
            day: Math.floor(t / 86400),
            hour: Math.floor(t % 86400 / 3600),
            minute: Math.floor(t % 3600 / 60),
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

var fftime = function (n) {
    if (Number(n) < 10) {
        return "0" + Number(n);
    } else {
        return Number(n);
    }
};

var daytimeToStap = function (daytime) {
    let timestamp = Math.round(new Date(daytime.replace(/[\-\u4e00-\u9fa5]/g, "/")).getTime() / 1000);
    return timestamp;
}

var getNow = function () {
    const d = new Date();
    let now = Math.round(d.getTime() / 1000);
    return now;
}

// export function formatTime(remainTime) {
//     let _remainTime;
//     const cf = _diff(remainTime);
//     if (cf.hour === 0) {
//         _remainTime = fftime(cf.minute) + ':' + fftime(cf.second);
//     } else {
//         _remainTime = fftime(cf.hour) + ':' + fftime(cf.minute) + ':' + fftime(cf.second);
//     }
//
//     return _remainTime;
// }

export function isIssuesLoaded(lotteryid) {
    return issues[lotteryid] && issues[lotteryid].lotteryid;
}

/**
 * 根据彩种获取奖期数据,根据时间计算后返回
 * @param lotteryid
 * @returns {*}
 */
export function getIssues(lotteryid) {
    let issue = issues[lotteryid];
    if (issue) {
        let before = issue.before;
        let current = issue.issues[0];
        if (daytimeToStap(current[2]) <= getNow()) {
            //销售截止了
            issue.last.unshift({issue: current[0], code: current[4]});
            if (issue.last.length > 10) {
                issue.last.pop();
            }
            issue.before = Object.assign({}, current);
            issue.issues.shift();
            //todo:补充一期可追号数据
        }
        return {...issue};
    }
    return null;
}

export function setIssues(lotteryid, _issues) {
    issues[lotteryid] = {..._issues};
    if (lotteryid == "dfffc") {
        // console.log(issues);
    }

}
