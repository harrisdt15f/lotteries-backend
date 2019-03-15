
import config from '../config';

const rxs = {'任选二': true, '任选三': true, '任选四': true};

// 玩法缓存
const lottery_methods = {};


export function getLottery(lotteryid) {

    const lottery = config.lotteries[lotteryid];
    lottery.id = lotteryid;
    lottery.positions = lottery.positions ? lottery.positions : {};
    return lottery;
}

export function getLotteries(user) {
    const lotteries = {};
    for (let lotteryid of Object.keys(config.lotteries)) {
        lotteries[lotteryid] = this.getLottery(lotteryid);
    }

    return lotteries;
}

export function getMethod(lotteryid, _methodid) {
    if (!lottery_methods[lotteryid]) {
        lottery_methods[lotteryid] = {};
    }

    if (lottery_methods[lotteryid][_methodid]) {
        return lottery_methods[lotteryid][_methodid];
    }

    const lottery = this.getLottery(lotteryid);
    const methods = config.methods[lottery.pattern];

    for (let menuid of Object.keys(methods)) {
        const val1 = methods[menuid];
        for (let menu2id of Object.keys(val1)) {
            const val2 = val1[menu2id];
            for (let methodid of Object.keys(val2)) {
                if (methodid === _methodid) {
                    //  初始化
                    const method = val2[methodid];

                    method.lotteryid = lottery.id;
                    method.pattern = lottery.pattern;
                    method.menuid = menuid;
                    method.menu2id = menu2id;
                    method.id = method.methodid = methodid;

                    const pg = config.prizes[method.pattern][method.method];
                    method.__count = pg.count;
                    method.__total = pg.total;
                    method.__prize = pg.prize;

                    method.rx = (rxs[menuid] && lottery.hasrx) ? true : false;
                    method.pc = method.pc ? method.pc : [];

                    const __choices = [];
                    const __quicks = [];
                    if (method.type === 'multi') {
                        for (let [row,key] of Object.keys(method.layout).entries()) {
                            __choices[row] = [];
                            __quicks[row] = [];
                            method.layout[key].forEach(function (val, col) {
                                __choices[row][col] = false;
                            });
                            method.buttons.forEach(function (val, col) {
                                __quicks[row][col] = false;
                            });
                        }
                    }

                    const __position = {};
                    let __positionDesc = [];
                    const __hasPosition = (method.pc.length > 0);
                    if (method.rx) {
                        for (let key of Object.keys(lottery.positions)) {
                            __position[key] = (method.pc.indexOf(key) > -1);
                        }
                    }

                    if (__hasPosition) {
                        __positionDesc = [method.pc.length, 1];
                    } else {
                        __positionDesc = [0, 0];
                    }

                    // method.__choices = JSON.stringify(__choices);
                    // method.__quicks = JSON.stringify(__quicks);
                    // method.__position = JSON.stringify(__position);
                    // method.__positionDesc = JSON.stringify(__positionDesc);
                    method.__hasPosition = __hasPosition;

                    const opts = {
                        'choices': __choices,
                        'quicks': __quicks,
                        'position': __position,
                        'positionDesc': __positionDesc
                    };

                    method.__opts = JSON.stringify(opts);

                    lottery_methods[lottery.id][methodid] = method;
                    return lottery_methods[lottery.id][methodid];
                }
            }
        }
    }

    return {};

}

export function getCrowds(lotteryid) {
    const lottery = this.getLottery(lotteryid);
    const methods = config.methods[lottery.pattern];
    return Object.keys(methods);
}

export function getCrowdChilds(lotteryid, crowd) {
    const lottery = this.getLottery(lotteryid);
    return config.methods[lottery.pattern][crowd];
}

export function getDefaultMethodIdCrowd(pattern, menuid) {
    const methods = config.methods[pattern];
    const menu2id = Object.keys(methods[menuid])[0];
    return Object.keys(methods[menuid][menu2id])[0];
}

export function isRxCrowd(menuid) {
    return (rxs[menuid]) ? true : false;
}

export function getPositions(lotteryid) {
    const lottery = this.getLottery(lotteryid);
    return lottery.positions || {};
}

export function getPointOpts(method, user_point, user_maxpoint) {
    const result = [];

    // 返点 最大奖金  最大返点
    let _diff = +user_point;
    let _prize = method.__prize + (method.__total * 2 * (_diff / 100) ) / method.__count;
    const _point1 = (+user_maxpoint - +user_point).toFixed(1);
    const _prize1 = Math.round(_prize * 100) / 100;

    result.push([_point1, _prize1]);

    _diff = 0;
    _prize = method.__prize + (method.__total * 2 * (_diff / 100) ) / method.__count;
    const _point2 = user_maxpoint;
    const _prize2 = Math.round(_prize * 100) / 100;

    if (_prize2 != _prize1) {
        result.push([_point2, _prize2]);
    }

    return result;

}
