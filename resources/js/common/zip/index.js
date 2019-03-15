var gzip = require('./gzip.js');
var b64cvt = require('./b64cvt.js');

exports.compress = function (instr) {
    var d = new Date();

    var out = gzip.zip(instr, {
        name: 'data',
        level: gzip.DEFAULT_LEVEL,
        timestamp: parseInt(Math.round(d.getTime() / 1000))
    });

    return b64cvt.fromByteArray(out);
};

exports.uncompress = function (instr) {
    var d = new Date();

    var out = gzip.unzip(b64cvt.toByteArray(instr), {
        name: 'data',
        level: gzip.DEFAULT_LEVEL,
        timestamp: parseInt(Math.round(d.getTime() / 1000))
    });

    return out;
};