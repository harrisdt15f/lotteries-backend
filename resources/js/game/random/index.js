import {array_rand} from '../funs.js'

const arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
const arr1 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
const arr2 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];

const arr11 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
const arr22 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];

const ks_arr = [1, 2, 3, 4, 5, 6];

const LTCODES = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11'];

const PKCODES = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'];

export default {
    ZX5 (method) {
        return array_rand(arr, 5).join('|');
    },
    ZX5_S (method) {
        return array_rand(arr, 5).join('');
    },
    ZH5 (method) {
        return array_rand(arr, 5).join('|');
    },
    WXZU120 (method) {
        return array_rand(arr, 5).join('&');
    },
    WXZU60 (method) {
        let temp = array_rand(arr, 4);
        let first = temp.shift();
        return first + '|' + temp.join('&');
    },
    WXZU30 (method) {
        let temp = array_rand(arr, 3);
        let first = temp.shift();
        let second = temp.shift();
        return first + '&' + second + '|' + temp.join('&');
    },
    WXZU20 (method) {
        let temp = array_rand(arr, 3);
        let first = temp.shift();
        return first + '|' + temp.join('&');
    },
    WXZU10 (method) {
        let temp = array_rand(arr, 2);
        return temp.join('|');
    },
    WXZU5 (method) {
        let temp = array_rand(arr, 2);
        return temp.join('|');
    },
    YFFS (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    HSCS (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    SXBX (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    SJFC (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    ZX4(method){
        return array_rand(arr, 4).join('|');
    },
    ZX4_S(method){
        return array_rand(arr, 4).join('');
    },
    ZH4(method){
        return array_rand(arr, 4).join('|');
    },
    SXZU24(method){
        return array_rand(arr, 4).join('&');
    },
    SXZU12(method){
        var temp = array_rand(arr, 4);
        var first = temp.shift();
        return first + '|' + temp.join('&');
    },
    SXZU6(method){
        return array_rand(arr, 2).join('&');
    },
    SXZU4(method){
        return array_rand(arr, 2).join('|');
    },

    ZX3 (method) {
        return array_rand(arr, 3).join('|');
    },
    ZX3_S (method) {
        return array_rand(arr, 3).join('');
    },
    ZH3 (method) {
        return array_rand(arr, 3).join('|');
    },
    ZXHZ (method) {
        return arr1[Math.floor(Math.random() * arr1.length)];
    },
    ZXKD (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    ZUS (method) {
        return array_rand(arr, 2).join('&');
    },
    ZUS_S (method) {
        let temp = array_rand(arr, 2);
        temp.push(temp[0]);
        return temp.join('');
    },
    ZUL (method) {
        return array_rand(arr, 3).join('&');
    },
    ZUL_S (method) {
        return array_rand(arr, 3).join('');
    },
    HHZX (method) {
        if (Math.floor(Math.random() * 1))
            return this.ZUS_S();
        else
            return this.ZUL_S();
    },
    ZUHZ (method) {
        return arr2[Math.floor(Math.random() * arr2.length)];
    },
    ZU3BD (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    HZWS (method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    TS3 (method) {
        let rand = Math.floor(Math.random() * 3);
        if (rand == 0)
            return '豹子';
        else if (rand == 1)
            return '顺子';
        else
            return '对子';
    },
    ZX2(method) {
        return array_rand(arr, 2).join('|');
    },
    ZX2_S(method) {
        return array_rand(arr, 2).join('');
    },
    ZXHZ2(method) {
        return arr11[Math.floor(Math.random() * arr11.length)];
    },
    ZXKD2(method) {
        return arr[Math.floor(Math.random() * arr.length)]
    },
    ZU2(method) {
        return array_rand(arr, 2).join('&');
    },
    ZU2_S(method) {
        return array_rand(arr, 2).join('');
    },
    ZUHZ2(method) {
        return arr22[Math.floor(Math.random() * arr22.length)];
    },
    ZU2BD(method) {
        return arr[Math.floor(Math.random() * arr.length)];
    },
    DWD(method){
        let n = Object.keys(method.layout).length;
        let rand = Math.floor(Math.random() * n);
        return new Array(rand + 1).join('|') + arr[Math.floor(Math.random() * arr.length)];
    },

    BDW1(method){
        return arr[Math.floor(Math.random() * arr.length)];
    },
    BDW2(method){
        return array_rand(arr, 2).join('&');
    },
    BDW41(method){
        return arr[Math.floor(Math.random() * arr.length)];
    },
    BDW42(method){
        return array_rand(arr, 2).join('&');
    },
    BDW52(method){
        return array_rand(arr, 2).join('&');
    },
    BDW53(method){
        return array_rand(arr, 3).join('&');
    },
    DXDS(method){
        let data = ['大', '小', '单', '双'];
        let len = data.length;
        return data[Math.floor(Math.random() * len)] + '|' + data[Math.floor(Math.random() * len)];
    },
    DXDS3(method){
        let data = ['大', '小', '单', '双'];
        let len = data.length;
        return data[Math.floor(Math.random() * len)] + '|' + data[Math.floor(Math.random() * len)] + '|' + data[Math.floor(Math.random() * len)];
    },


    RZX2(method){
        const temp = ['', '', '', '', ''];
        let d = this.ZX2(method).split('|');
        for (var [k, v] of array_rand(temp, 2)) {
            temp[v] = d[k];
        }
        return temp.join('|');
    },
    RZX2_S(method){
        return this.ZX2_S(method);
    },
    RZXHZ2(method){
        return this.ZXHZ2(method);
    },
    RZU2(method){
        return this.ZU2(method);
    },
    RZU2_S(method){
        return this.ZU2_S(method);
    },
    RZUHZ2(method){
        return this.ZUHZ2(method);
    },
    RZX3(method){
        const temp = ['', '', '', '', ''];
        let d = this.ZX3(method).split('|');
        for (var [k,v] of array_rand(temp, 3)) {
            temp[v] = d[k]
        }
        return temp.join('|');
    },
    RZX3_S(method){
        return this.ZX3_S(method);
    },
    RZXHZ(method){
        return this.ZXHZ(method);
    },
    RZUS(method){
        return this.ZUS(method);
    },
    RZUS_S(method){
        return this.ZUS_S(method);
    },
    RZUL(method){
        return this.ZUL(method);
    },
    RZUL_S(method){
        return this.ZUL_S(method);
    },

    RHHZX(method){
        return this.HHZX(method);
    },
    RZUHZ(method){
        return this.ZUHZ(method);
    },
    RZX4(method){
        const temp = ['', '', '', '', ''];
        let d = this.ZX4(method).split('|');
        for (var [v, k] of array_rand(temp, 4)) {
            temp[v] = d[k];
        }
        return temp.join('|');
    },
    RZX4_S(method){
        return this.ZX4_S(method);
    },
    RSXZU24(method){
        return this.SXZU24(method);
    },
    RSXZU12(method){
        return this.SXZU12(method);
    },
    RSXZU6(method){
        return this.SXZU6(method);
    },
    RSXZU4(method){
        return this.SXZU4(method);
    },

    KSHZ(method){
        const data = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
        return data[Math.floor(Math.random() * data.length)];
    },
    STHTX(method){
        return '通选';
    },
    STHDX(method){
        const data = ['111', '222', '333', '444', '555', '666'];
        return data[Math.floor(Math.random() * data.length)];
    },
    ETHFX(method){
        const data = ['11*', '22*', '33*', '44*', '55*', '66*'];
        return data[Math.floor(Math.random() * data.length)];
    },
    ETHDX(method){
        const data = ks_arr;
        const temp = array_rand(data, 2);
        return data[temp[0]] + '' + data[temp[0]] + '|' + data[temp[1]];
    },
    ETHDX_S(method){
        const data = ks_arr;
        const temp = array_rand(data, 2);
        return data[temp[0]] + '' + data[temp[0]] + '' + data[temp[1]];
    },
    SBTH(method){
        const data = ks_arr;
        const temp = [];
        for (var i in array_rand(data, 3)) {
            temp.push(data[i])
        }
        return temp.join('&');
    },
    SBTH_S(method){
        const data = ks_arr;
        const temp = [];
        for (var i in array_rand(data, 3)) {
            temp.push(data[i])
        }
        return temp.join('');
    },
    SBTHDT(method){
        const data = ks_arr;
        const temp = array_rand(data, 3);
        return data[temp[0]] + '|' + data[temp[1]] + '&' + data[temp[2]];
    },
    SBTHHZ(method){
        const data = ['6', '7', '8', '9', '10', '12', '13', '14', '15'];
        return data[Math.floor(Math.random() * data.length)];
    },
    EBTH(method){
        const data = ks_arr;
        const temp = [];
        for (var i in array_rand(data, 2)) {
            temp.push(data[i])
        }
        return temp.join('&');
    },
    EBTH_S(method){
        const data = ks_arr;
        const temp = [];
        for (var i in array_rand(data, 2)) {
            temp.push(data[i])
        }
        return temp.join('');
    },
    EBTHDT(method){
        const data = ks_arr;
        const temp = array_rand(data, 2);
        return data[temp[0]] + '|' + data[temp[1]];
    },
    SLTHTX(method){
        return '通选';
    },

    LTZX3 (method) {
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join('|');
    },
    LTZX3_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTZU3(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTZU3_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTDTZU3(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    },
    LTZX2(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join('|');
    },
    LTZX2_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTZU2(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTZU2_S(method){
        return game.random.LTZX2_S();
    },
    LTDTZU2(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join('|');
    },
    LTBDW (method){
        return LTCODES[Math.floor(Math.random() * LTCODES.length)];
    },
    LTDWD (method) {
        const temp = [];
        for (var i in array_rand(LTCODES, 1)) {
            temp.push(LTCODES[i])
        }
        let code = temp.join('&');
        let rand = Math.floor(Math.random() * 3);
        return new Array(rand + 1).join('|') + code;
    },
    LTDDS(method){
        let data = ['5单0双', '4单1双', '3单2双', '2单3双', '1单4双', '0单5双'];
        return data[Math.floor(Math.random() * data.length)];
    },
    LTCZW(method){
        let data = ['3', '4', '5', '6', '7', '8', '9'];
        return data[Math.floor(Math.random() * data.length)];
    },
    LTRX1(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 1)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX1_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 1)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX2(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX2_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX3(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX3_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX4(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 4)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX4_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 4)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX5(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 5)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX5_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 5)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX6(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 6)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX6_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 6)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX7(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 7)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX7_S(method){
        const temp = [];
        for (var i in array_rand(LTCODES, 7)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    LTRX8(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 8)) {
            temp.push(LTCODES[i])
        }
        return temp.join('&');
    },
    LTRX8_S(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 8)) {
            temp.push(LTCODES[i])
        }
        return temp.join(' ');
    },
    //胆拖
    LTRXDT2(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 1)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    },
    LTRXDT3(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 2)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    }
    ,
    LTRXDT4(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 3)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    }
    ,
    LTRXDT5(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 4)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    }
    ,
    LTRXDT6(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 5)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    }
    ,
    LTRXDT7(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 6)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    }
    ,
    LTRXDT8(method)
    {
        const temp = [];
        for (var i in array_rand(LTCODES, 7)) {
            temp.push(LTCODES[i])
        }
        let first = temp.shift();
        return first + '|' + temp.join('&');
    },


    PKZX1(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 1)) {
            temp.push(PKCODES[i])
        }
        return temp.join('|');
    },
    PKZX2(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 2)) {
            temp.push(PKCODES[i])
        }
        return temp.join('|');
    },
    PKZX2_S(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 2)) {
            temp.push(PKCODES[i])
        }
        return temp.join(' ');
    },
    PKZX3(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 3)) {
            temp.push(PKCODES[i])
        }
        return temp.join('|');
    },
    PKZX3_S(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 3)) {
            temp.push(PKCODES[i])
        }
        return temp.join(' ');
    },
    PKDWD(method){
        const temp = [];
        for (var i in array_rand(PKCODES, 1)) {
            temp.push(PKCODES[i])
        }
        return temp.join('|');
    }
}
