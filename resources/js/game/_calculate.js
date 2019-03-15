import algorithm from './algorithm';

export default algorithm;

export function calculate(method, state) {
    let _cnt, _num, _pcnt, item, k, ref, result, inputcodes, positionDesc;
    _num = 0;
    inputcodes = '';
    positionDesc = [];

    // if ((method.type == 'multi' && statedata.choices.length < 1) || (method.type == 'text' && statedata.input == '' )) {
    //     return [_num, inputcodes, positionDesc];
    // }

    result = algorithm[method.method](method, state);

    if (method.rx) {
        _num = result[0];
        _cnt = result[1];
        _pcnt = 0;
        ref = state.__position;
        for (k in ref) {
            item = ref[k];
            if (item) {
                _pcnt += 1;
            }
        }
        positionDesc = [_pcnt, _cnt];
        if (result.length === 3) {
            inputcodes = result[2];
        }
    } else if (result instanceof Array) {
        _num = result[0];
        inputcodes = result[1];
    } else {
        _num = result;
    }

    state.num = _num;
    state.cost = _num*2;
    state.inputcodes = inputcodes;
    state.__positionDesc = positionDesc;

    return [_num, inputcodes, positionDesc];
}

// 对单式输入做过滤 和 检测重复
export function filterInputCode(method, inputcode) {
    if (method.method == '') {

    }
    return inputcode;
}