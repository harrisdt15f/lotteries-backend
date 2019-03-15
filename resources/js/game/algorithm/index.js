import * as cc from './calculate'

export default {
    //------------------数字型------------------
    ZX5(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3 * n4 * n5;
    },
    ZX5_S(method, state) {
        return cc.calculateByIuput(5, method, function () {
            return true;
        }, state);
    },
    ZH5(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3 * n4 * n5 * 5;
    },
    WXZU120(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 5);
    },
    WXZU60(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 3) - cc.C(h, 1) * cc.C(n - 1, 2);
    },
    WXZU30(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 2) * cc.C(n, 1) - cc.C(h, 2) * cc.C(2, 1) - cc.C(h, 1) * cc.C(m - h, 1);
    },
    WXZU20(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 2) - cc.C(h, 1) * cc.C(n - 1, 1);
    },
    WXZU10(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 1) - cc.C(h, 1);
    },
    WXZU5(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 1) - cc.C(h, 1);
    },
    YFFS(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1;
    },
    HSCS(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1;
    },
    SXBX(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1;
    },
    SJFC(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1;
    },

    //四星

    ZX4(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3 * n4;
    },
    ZX4_S(method, state) {
        return cc.calculateByIuput(4, method, function () {
            return true;
        }, state);
    },
    ZH4(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3 * n4 * 4;
    },
    SXZU24(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 4);
    },
    SXZU12(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 2) - cc.C(h, 1) * cc.C(n - 1, 1);
    },
    SXZU6(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 2);
    },
    SXZU4(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(m, 1) * cc.C(n, 1) - cc.C(h, 1);
    },

    //三星

    ZX3(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3;
    },
    ZX3_S(method, state) {
        return cc.calculateByIuput(3, method, function () {
            return true;
        }, state);
    },
    ZH3(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3 * 3;
    },
    ZXHZ(method, state) {
        let data;
        data = [1, 3, 6, 10, 15, 21, 28, 36, 45, 55, 63, 69, 73, 75, 75, 73, 69, 63, 55, 45, 36, 28, 21, 15, 10, 6, 3, 1];
        return cc.calculateByPosition(data, method, state);
    },
    ZXKD(method, state) {
        let data;
        data = [10, 54, 96, 126, 144, 150, 144, 126, 96, 54];
        return cc.calculateByPosition(data, method, state);
    },
    ZUS(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 2) * 2;
    },
    ZUS_S(method, state) {
        return cc.calculateByZuIuput(3, method, input => {
            let ref;
            if ((input[0] === (ref = input[1]) && ref === input[2])) {
                return false;
            }
            if (input[0] === input[1] || input[1] === input[2] || input[0] === input[2]) {
                return true;
            }
        }, state);
    },
    ZUL(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 3);
    },
    ZUL_S(method, state) {
        return cc.calculateByZuIuput(3, method, input => {
            if (input[0] === input[1] || input[1] === input[2] || input[0] === input[2]) {
                return false;
            }
            return true;
        }, state);
    },
    HHZX(method, state) {
        return cc.calculateByZuIuput(3, method, input => {
            let ref;
            if ((input[0] === (ref = input[1]) && ref === input[2])) {
                return false;
            }
            return true;
        }, state);
    },
    ZUHZ(method, state) {
        let data;
        data = [1, 2, 2, 4, 5, 6, 8, 10, 11, 13, 14, 14, 15, 15, 14, 14, 13, 11, 10, 8, 6, 5, 4, 2, 2, 1];
        return cc.calculateByPosition(data, method, state);
    },
    ZU3BD(method, state) {
        let data;
        data = [54, 54, 54, 54, 54, 54, 54, 54, 54, 54];
        return cc.calculateByPosition(data, method, state);
    },
    HZWS(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 1);
    },
    TS3(method, state) {
        let data;
        data = [1, 1, 1];
        return cc.calculateByPosition(data, method, state);
    },


    //两星
    ZX2(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2;
    },
    ZX2_S(method, state) {
        return cc.calculateByIuput(2, method, function () {
            return true;
        }, state);
    },
    ZXHZ2(method, state) {
        let data;
        data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10].concat([9, 8, 7, 6, 5, 4, 3, 2, 1]);
        return cc.calculateByPosition(data, method, state);
    },
    ZXKD2(method, state) {
        let data;
        data = [10, 18, 16, 14, 12, 10, 8, 6, 4, 2];
        return cc.calculateByPosition(data, method, state);
    },
    ZU2(method, state) {
        let h, m, n, ref;
        ref = cc.calculateMNH(method, state), m = ref[0], n = ref[1], h = ref[2];
        return cc.C(n, 2);
    },
    ZU2_S(method, state) {
        return cc.calculateByZuIuput(2, method, input => {
            if (input[0] !== input[1]) {
                return true;
            }
            return false;
        }, state);
    },
    ZUHZ2(method, state) {
        let data;
        data = [1, 1, 2, 2, 3, 3, 4, 4, 5, 4, 4, 3, 3, 2, 2, 1, 1];
        return cc.calculateByPosition(data, method, state);
    },
    ZU2BD(method, state) {
        let data;
        data = [9, 9, 9, 9, 9, 9, 9, 9, 9, 9];
        return cc.calculateByPosition(data, method, state);
    },


    //一星

    DWD(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 + n2 + n3 + n4 + n5;
    },

    //不定位
    BDW1(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 1);
    },
    BDW2(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 2);
    },
    BDW41(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 1);
    },
    BDW42(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 2);
    },
    BDW52(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 2);
    },
    BDW53(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return cc.C(n1, 3);
    },
    //大小单双
    DXDS(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2;
    },
    DXDS3(method, state) {
        let n1, n2, n3, n4, n5, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        return n1 * n2 * n3;
    },

    //任选
    RZX2(method, state) {
        let arr, cnt, i, j, len, n1, n2, ref;
        cnt = 0;
        arr = cc.Combine(cc.calculateN(method, state), 2);
        for (i = j = 0, len = arr.length; j < len; i = ++j) {
            ref = arr[i], n1 = ref[0], n2 = ref[1];
            cnt += n1 * n2;
        }
        return [cnt, arr.length];
    },
    RZX2_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 2);
        tmp = this.ZX2_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RZXHZ2(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 2);
        cnt = m * this.ZXHZ2(method, state);
        return [cnt, m];
    },
    RZU2(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 2);
        cnt = m * this.ZU2(method, state);
        return [cnt, m];
    },
    RZU2_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 2);
        tmp = this.ZU2_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RZUHZ2(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 2);
        cnt = m * this.ZUHZ2(method, state);
        return [cnt, m];
    },
    RZX3(method, state) {
        let arr, cnt, i, j, len, n1, n2, n3, ref;
        cnt = 0;
        arr = cc.Combine(cc.calculateN(method, state), 3);
        for (i = j = 0, len = arr.length; j < len; i = ++j) {
            ref = arr[i], n1 = ref[0], n2 = ref[1], n3 = ref[2];
            cnt += n1 * n2 * n3;
        }
        return [cnt, arr.length];
    },
    RZX3_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        tmp = this.ZX3_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RZXHZ(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        cnt = m * this.ZXHZ(method, state);
        return [cnt, m];
    },
    RZUS(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        cnt = m * this.ZUS(method, state);
        return [cnt, m];
    },
    RZUS_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        tmp = this.ZUS_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RZUL(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        cnt = m * this.ZUL(method, state);
        return [cnt, m];
    },
    RZUL_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        tmp = this.ZUL_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RHHZX(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        tmp = this.HHZX(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RZUHZ(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 3);
        cnt = m * this.ZUHZ(method, state);
        return [cnt, m];
    },
    RZX4(method, state) {
        let arr, cnt, i, j, len, n1, n2, n3, n4, ref;
        cnt = 0;
        arr = cc.Combine(cc.calculateN(method, state), 4);
        for (i = j = 0, len = arr.length; j < len; i = ++j) {
            ref = arr[i], n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3];
            cnt += n1 * n2 * n3 * n4;
        }
        return [cnt, arr.length];
    },
    RZX4_S(method, state) {
        let cnt, m, n, tmp;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 4);
        tmp = this.ZX4_S(method, state);
        cnt = m * tmp[0];
        return [cnt, m, tmp[1]];
    },
    RSXZU24(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 4);
        cnt = m * this.SXZU24(method, state);
        return [cnt, m];
    },
    RSXZU12(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 4);
        cnt = m * this.SXZU12(method, state);
        return [cnt, m];
    },
    RSXZU6(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 4);
        cnt = m * this.SXZU6(method, state);
        return [cnt, m];
    },
    RSXZU4(method, state) {
        let cnt, m, n;
        n = cc.calculatePositionCnt(method, state);
        m = cc.C(n, 4);
        cnt = m * this.SXZU4(method, state);
        return [cnt, m];
    },

    //------------------快三------------------
    STHTX(method, state) {
        return 1;
    },
    KSHZ(method, state) {
        return cc.calculateN(method, state)[0];
    },
    KSHZDXDS(method, state) {
        return cc.calculateN(method, state)[0];
    },
    STHDX(method, state) {
        return cc.calculateN(method, state)[0];
    },
    ETHFX(method, state) {
        return cc.calculateN(method, state)[0];
    },
    ETHDX(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        return n1 * n2;
    },
    ETHDX_S(method, state) {
        return cc.calculateByZuIuput(3, method, input => {
            let ref;
            if ((input[0] === (ref = input[1]) && ref === input[2])) {
                return false;
            }
            if (input[0] === input[1] || input[1] === input[2] || input[0] === input[2]) {
                return true;
            }
        }, state);
    },
    SBTH(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 3);
    },
    SBTH_S(method, state) {
        return cc.calculateByZuIuput(3, method, input => {
            if (input[0] !== input[1] && input[1] !== input[2]) {
                return true;
            }
            return false;
        }, state);
    },
    SBTHDT(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        return cc.C(n2, 3 - n1);
    },
    SBTHHZ(method, state) {
        let data;
        data = [1, 1, 2, 3, 3, 3, 3, 2, 1, 1];
        return cc.calculateByPosition(data, method, state);
    },
    EBTH(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 2);
    },
    EBTH_S(method, state) {
        return cc.calculateByZuIuput(2, method, input => {
            if (input[0] !== input[1]) {
                return true;
            }
            return false;
        }, state);
    },
    EBTHDT(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        return cc.C(n2, 2 - n1);
    },
    SLTHTX(method, state) {
        return 1;
    },


    //------------------乐透------------------

    LTZX3(method, state) {
        let A, AB, ABC, AC, B, BC, C, listA, listB, listC, ref, ref1, result;
        ref = cc.calculateN(method, state), A = ref[0], B = ref[1], C = ref[2];
        ref1 = cc.calculateNDetail(method, state), listA = ref1[0], listB = ref1[1], listC = ref1[2];
        BC = cc.N(listB, listC);
        AC = cc.N(listA, listC);
        AB = cc.N(listA, listB);
        ABC = cc.N(listA, listB, listC);
        result = A * B * C - A * BC - B * AC - C * AB + 2 * ABC;
        if (result > 0) {
            return result;
        } else {
            return 0;
        }
    },
    LTZX3_S(method, state) {
        return cc.calculateLTByIuput(method, 3, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTZU3(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 3);
    },
    LTZU3_S(method, state) {
        return cc.calculateLTByIuput(method, 3, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTDTZU3(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (!n1) {
            return 0;
        }
        return cc.C(n2, 3 - n1);
    },
    LTZX2(method, state) {
        let A, AB, B, listA, listB, ref, ref1, result;
        ref = cc.calculateN(method, state), A = ref[0], B = ref[1];
        ref1 = cc.calculateNDetail(method, state), listA = ref1[0], listB = ref1[1];
        AB = cc.N(listA, listB);
        result = A * B - AB;
        if (result > 0) {
            return result;
        } else {
            return 0;
        }
    },
    LTZX2_S(method, state) {
        return cc.calculateLTByIuput(method, 2, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTZU2(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 2);
    },
    LTZU2_S(method, state) {
        return cc.calculateLTByIuput(method, 2, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTDTZU2(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (!n1) {
            return 0;
        }
        return cc.C(n2, 2 - n1);
    },
    LTBDW(method, state) {
        return cc.calculateN(method, state)[0];
    },
    LTDWD(method, state) {
        let n1, n2, n3, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2];
        return n1 + n2 + n3;
    },
    LTDDS(method, state) {
        return cc.calculateN(method, state)[0];
    },
    LTCZW(method, state) {
        return cc.calculateN(method, state)[0];
    },

    LTRX1(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 1);
    },
    LTRX1_S(method, state) {
        return cc.calculateLTRXByIuput(method, 1, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX2(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 2);
    },
    LTRX2_S(method, state) {
        return cc.calculateLTRXByIuput(method, 2, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX3(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 3);
    },
    LTRX3_S(method, state) {
        return cc.calculateLTRXByIuput(method, 3, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX4(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 4);
    },
    LTRX4_S(method, state) {
        return cc.calculateLTRXByIuput(method, 4, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX5(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 5);
    },
    LTRX5_S(method, state) {
        return cc.calculateLTRXByIuput(method, 5, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX6(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 6);
    },
    LTRX6_S(method, state) {
        return cc.calculateLTRXByIuput(method, 6, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX7(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 7);
    },
    LTRX7_S(method, state) {
        return cc.calculateLTRXByIuput(method, 7, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRX8(method, state) {
        let n;
        n = cc.calculateN(method, state)[0];
        return cc.C(n, 8);
    },
    LTRX8_S(method, state) {
        return cc.calculateLTRXByIuput(method, 8, num => +num && +num >= 1 && +num <= 11, state);
    },
    LTRXDT2(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 2 - n1);
    },
    LTRXDT3(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 3 - n1);
    },
    LTRXDT4(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 4 - n1);
    },
    LTRXDT5(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 5 - n1);
    },
    LTRXDT6(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 6 - n1);
    },
    LTRXDT7(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 7 - n1);
    },
    LTRXDT8(method, state) {
        let n1, n2, ref;
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1];
        if (n1 < 1) {
            return 0;
        }
        return cc.C(n2, 8 - n1);
    },


    //------------------PK10------------------
    PKZX1(method, state) {
        let n1;
        n1 = cc.calculateN(method, state)[0];
        return n1;
    },
    PKZX2(method, state) {
        let A, AB, B, listA, listB, ref, ref1, result;
        ref = cc.calculateN(method, state), A = ref[0], B = ref[1];
        ref1 = cc.calculateNDetail(method, state), listA = ref1[0], listB = ref1[1];
        AB = cc.N(listA, listB);
        result = A * B - AB;
        if (result > 0) {
            return result;
        }

        return 0;
    },
    PKZX2_S(method, state) {
        return cc.calculateLTByIuput(method, 2, num => +num && +num >= 1 && +num <= 10, state);
    },
    n(a, b, c) {
        let i, item, j, len, len1, oldResult, result;
        result = [];
        for (i = 0, len = a.length; i < len; i++) {
            item = a[i];
            if (b.indexOf(item) >= 0) {
                result.push(item);
            }
        }
        if (c) {
            oldResult = result;
            result = [];
            for (j = 0, len1 = oldResult.length; j < len1; j++) {
                item = oldResult[j];
                if (c.indexOf(item) >= 0) {
                    result.push(item);
                }
            }
        }
        return result.length;
    },
    PKZX3(method, state) {
        let A, AB, ABC, AC, B, BC, C, listA, listB, listC, ref, ref1, result;
        ref = cc.calculateN(method, state), A = ref[0], B = ref[1], C = ref[2];
        ref1 = cc.calculateNDetail(method, state), listA = ref1[0], listB = ref1[1], listC = ref1[2];
        BC = cc.N(listB, listC);
        AC = cc.N(listA, listC);
        AB = cc.N(listA, listB);
        ABC = cc.N(listA, listB, listC);
        result = A * B * C - A * BC - B * AC - C * AB + 2 * ABC;
        if (result > 0) {
            return result;
        } else {
            return 0;
        }
    },
    PKZX3_S(method, state) {
        return cc.calculateLTByIuput(method, 3, num => +num && +num >= 1 && +num <= 10, state);
    },
    PKDWD(method, state) {
        //let n1, n10, n2, n3, n4, n5, n6, n7, n8, n9, ref;
        let n1, n2, n3, n4, n5, ref;
        //ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4], n6 = ref[5], n7 = ref[6], n8 = ref[7], n9 = ref[8], n10 = ref[9];
        ref = cc.calculateN(method, state), n1 = ref[0], n2 = ref[1], n3 = ref[2], n4 = ref[3], n5 = ref[4];
        //return n1 + n2 + n3 + n4 + n5 + n6 + n7 + n8 + n9 + n10;
        return n1 + n2 + n3 + n4 + n5;
    }

}
