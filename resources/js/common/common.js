export function changeMoneyToFixed(money){
    var m4=+(money).toFixed(4);
    var m3=+(money).toFixed(3);
    var m2=+(money).toFixed(2);
    var m1=+(money).toFixed(1);
    var m0=parseInt(money);
    var m=m4;
    if(m==m3){
        m=m3;
    }
    if(m==m2){
        m=m2;
    }
    if(m==m1){
        m=m1;
    }
    if(m==m0){
        m=m0;
    }

    return m;
}

export function Bconvert(a){
    var f,g,b=[],c=0,d=0;
    var e       = parseInt(a[0]);
    var last    = e;
    for(f=1;f<a.length;f++){
        g=parseInt(a[f]);
        if(g==last+1){
            c++
        }else{
            d=g-last;
            if(c>0){
                b.push("m"+c);
            }
            if(d>0){
                b.push("n"+d);
            }
            c=0;
        }
        last=g;
    }
    if(c>0){
        b.push("m"+c);
    }

    return "s"+e+b.join("");
};


//加密投注数组
export function encodeCodes(arr) {
    if (typeof arr === "string") {
        arr = arr.split(",");
    }
    var chartData = [], m = 0, n = 0;
    var last = parseInt(arr[0]);
    var start = last;
    for (var i = 1; i < arr.length; i++) {
        var current = parseInt(arr[i]);
        if (current == last + 1) {
            m++;
        } else {
            n = current - last;
            m > 0 && chartData.push("m" + m);
            n > 0 && chartData.push("n" + n);
            m = 0;
        }
        last = current;
    }
    m > 0 && chartData.push("m" + m);
    return 's' + start + chartData.join('');
}

//揭秘投注数组
export function decodeCodes(str) {
    var tag = {s: 1, m: 1, n: 1},
        arr = [], result = [];
    for (var i = 0, j = -1; i < str.length; i++) {
        if (tag[str[i]]) {
            j++;
            arr[j] = {tag: str[i], num: ""};
        } else {
            arr[j].num += str[i];
        }
    }
    result[0] = parseInt(arr[0].num);
    for (var i =1, k = 1; i < arr.length; i++) {
        if (arr[i].tag == "m") { // 连续
            for (var j = 0; j < parseInt(arr[i].num); j++) {
                result[k] = result[k - 1] + 1;
                k++;
            }
        } else if (arr[i].tag == "n") { // 间隔
            result[k] = result[k - 1] + parseInt(arr[i].num);
            k++;
        }
    }
    return result;
}