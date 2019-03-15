import randoms from './random';

//export default randoms;

export function random(method, times) {
    const result = [];

    for (let ii = 0; ii < times; ii++) {
        result.push(randoms[method.method](method));
    }

    return result;
}
