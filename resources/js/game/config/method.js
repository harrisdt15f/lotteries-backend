const digitalCodesTpl = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
const digitalPosTpl = ["全", "大", "小", "奇", "偶", "清"];
const digitalZxhzTpl = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
const digitalZuhzTpl = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];

const digitalZxhz2Tpl = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
const digitalZuhz2Tpl = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
const digitalDxdsTpl = ['大', '小', '单', '双'];

const lottoCodesTpl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11'];
const pk10CodesTpl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'];

export default {
    'digital': {
        '五星': {
            '五星直选': {
                'ZX5': {
                    'name': '直选复式',
                    'method': 'ZX5',
                    'desc': '从万位、千位、百位、十位、个位各选一个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中选择一个5位数号码组成一注，所选号码与开奖号码全部相同，且顺序一致，即为中奖。',
                    'example': '投注方案：13456<br>开奖号码：13456，即中五星直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZX5_S': {
                    'name': '直选单式',
                    'method': 'ZX5_S',
                    'desc': '手动输入号码，至少输入1个五位数号码组成一注。',
                    'help': '手动输入一个5位数号码组成一注，所选号码的万位、千位、百位、十位、个位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：23456<br>开奖号码：23456，即中五星直选。',
                    'type': 'text',
                    'number': 5,
                    'b64': 5
                },
                'ZH5': {
                    'name': '五星组合',
                    'type': 'multi',
                    'method': 'ZH5',
                    'desc': '从万位、千位、百位、十位、个位各选一个号码组成五注。',
                    'help': '从万位、千位、百位、十位、个位中至少各选一个号码组成1-5星的组合，共五注，所选号码的个位与开奖号码全部相同，则中1个5等奖；所选号码的个位、十位与开奖号码相同，则中1个5等奖以及1个4等奖，依此类推，最高可中5个奖。',
                    'example': '投注方案：购买4+5+6+7+8，该票共10元，由以下5注：45678(五星)、5678(四星)、678(三星)、78(二星)、8(一星)构成。<br>开奖号码：45678，即可中五星、四星、三星、二星、一星各1注',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '五星组选': {
                'WXZU120': {
                    'name': '组选120',
                    'method': 'WXZU120',
                    'desc': '从0-9中任意选择5个号码组成一注',
                    'help': '从0-9中任意选择5个号码组成一注，所选号码与开奖号码的万位、千位、百位、十位、个位相同，顺序不限，即为中奖。\t',
                    'example': '投注方案：10568<br>开奖号码：10568（顺序不限），即可中五星组选120。',
                    'type': 'multi',
                    'layout': {
                        '组选120': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'WXZU60': {
                    'name': '组选60',
                    'method': 'WXZU60',
                    'desc': '选择1个二重号码和三个单号号码组成一注',
                    'help': '选择1个二重号码和三个单号号码组成一注，所选的单号号码与开奖号码相同，且所选二重号码在开奖号码中出现了2次，即为中奖。\t',
                    'example': '投注方案：二重号：8；单号：016<br>开奖号码：01688（顺序不限），即可中五星组选60。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'WXZU30': {
                    'name': '组选30',
                    'method': 'WXZU30',
                    'desc': '选择2个二重号和1个单号号码组成一注',
                    'help': '选择2个二重号和1个单号号码组成一注，所选的单号号码与开奖号码相同，且所选的2个二重号码分别在开奖号码中出现了2次，即为中奖',
                    'example': '投注方案：二重号：68；单号：0<br>开奖号码：06688（顺序不限），即可中五星组选30。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'WXZU20': {
                    'name': '组选20',
                    'method': 'WXZU20',
                    'desc': '选择1个三重号码和两个单号号码组成一注',
                    'help': '选择1个三重号码和两个单号号码组成一注，所选的单号号码与开奖号码相同，且所选三重号码在开奖号码中出现了3次，即为中奖。\t',
                    'example': '投注方案：三重号：8；单号：01<br>开奖号码：01888（顺序不限），即可中五星组选20。',
                    'type': 'multi',
                    'layout': {
                        '三重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'WXZU10': {
                    'name': '组选10',
                    'method': 'WXZU10',
                    'desc': '选择1个三重号码和1个二重号码组成一注',
                    'help': '选择1个三重号码和1个二重号码，所选三重号码在开奖号码中出现3次，并且所选二重号码在开奖号码中出现了2次，即为中奖。',
                    'example': '投注方案：三重号：8；二重号：1<br>开奖号码：11888（顺序不限），即可中五星组选10。',
                    'type': 'multi',
                    'layout': {
                        '三重号': digitalCodesTpl,
                        '二重号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'WXZU5': {
                    'name': '组选5',
                    'method': 'WXZU5',
                    'desc': '选择1个四重号码和1个单号号码组成一注\t',
                    'help': '选择1个四重号码和1个单号号码组成一注所选的单号号码与开奖号码相同，且所选四重号码在开奖号码中出现了4次，即为中奖。',
                    'example': '投注方案：四重号：8；单号：1<br>开奖号码：18888（顺序不限），即可中五星组选5。',
                    'type': 'multi',
                    'layout': {
                        '四重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '五星特殊': {
                'YFFS': {
                    'name': '一帆风顺',
                    'method': 'YFFS',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中任意选择1个号码组成一注，只要开奖号码的万位、千位、百位、十位、个位中包含所选号码，即为中奖。',
                    'example': '投注方案：8<br>开奖号码：至少出现1个8，即中一帆风顺。',
                    'type': 'multi',
                    'layout': {
                        '一帆风顺': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HSCS': {
                    'name': '好事成双',
                    'method': 'HSCS',
                    'desc': '从0-9中任意选择1个以上的二重号码。',
                    'help': '从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现2次，即为中奖。',
                    'example': '投注方案：8<br>开奖号码：至少出现2个8，即中好事成双。',
                    'type': 'multi',
                    'layout': {
                        '好事成双': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'SXBX': {
                    'name': '三星报喜',
                    'method': 'SXBX',
                    'desc': '从0-9中任意选择1个以上的三重号码。',
                    'help': '从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现3次，即为中奖。',
                    'example': '投注方案：8<br>开奖号码：至少出现3个8，即中三星报喜。',
                    'type': 'multi',
                    'layout': {
                        '三星报喜': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'SJFC': {
                    'name': '四季发财',
                    'method': 'SJFC',
                    'desc': '从0-9中任意选择1个以上的四重号码。',
                    'help': '从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现4次，即为中奖。',
                    'example': '投注方案：8<br>开奖号码：至少出现4个8，即中四季发财。',
                    'type': 'multi',
                    'layout': {
                        '四季发财': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '四星': {
            '四星直选': {
                'ZX4': {
                    'name': '直选复式',
                    'method': 'ZX4',
                    'desc': '从千位、百位、十位、个位各选一个号码组成一注。',
                    'help': '从千位、百位、十位、个位中选择一个4位数号码组成一注，所选号码与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：3456<br>开奖号码：3456，即中四星直选。',
                    'type': 'multi',
                    'layout': {
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZX4_S': {
                    'name': '直选单式',
                    'method': 'ZX4_S',
                    'desc': '手动输入号码，至少输入1个四位数号码组成一注。',
                    'help': '手动输入一个4位数号码组成一注，所选号码的千位、百位、十位、个位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：3456<br>开奖号码：3456，即中四星直选。',
                    'type': 'text',
                    'number': 4,
                    'b64': 4
                },
                'ZH4': {
                    'name': '四星组合',
                    'method': 'ZH4',
                    'desc': '从千位、百位、十位、个位各选一个号码组成四注。',
                    'help': '从千位、百位、十位、个位中至少各选一个号码组成1-4星的组合，共四注，所选号码的个位与开奖号码相同，则中1个4等奖；<br>所选号码的个位、十位与开奖号码相同，则中1个4等奖以及1个3等奖，依此类推，最高可中4个奖。',
                    'example': '投注方案：购买5+6+7+8，该票共8元，由以下4注：5678(四星)、678(三星)、78(二星)、8(一星)构成。<br>开奖号码：5678，即可中四星、三星、二星、一星各1注',
                    'type': 'multi',
                    'layout': {
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '四星组选': {
                'SXZU24': {
                    'name': '组选24',
                    'method': 'SXZU24',
                    'desc': '从0-9中选择4个号码组成一注。',
                    'help': '从0-9中任意选择4个号码组成一注，所选号码与开奖号码的千位、百位、十位、个位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：0568<br>开奖号码：0568（顺序不限），即可中四星组选24。',
                    'type': 'multi',
                    'layout': {
                        '组选24': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'SXZU12': {
                    'name': '组选12',
                    'method': 'SXZU12',
                    'desc': '从“二重号”选择一个号码，“单号”中选择两个号码组成一注。',
                    'help': '选择1个二重号码和2个单号号码组成一注，所选号码与开奖号码的千位、百位、十位、个位相同，且所选二重号码在开奖号码中出现了2次，即为中奖。',
                    'example': '投注方案：二重号：8；单号：06<br>开奖号码：0688（顺序不限），即可中四星组选12。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'SXZU6': {
                    'name': '组选6',
                    'method': 'SXZU6',
                    'desc': '从“二重号”中选择两个号码组成一注。',
                    'help': '选择2个二重号码组成一注，所选的2个二重号码在开奖号码的千位、百位、十位、个位中分别出现了2次，即为中奖。',
                    'example': '投注方案：二重号：28<br>开奖号码：2288（顺序不限），即可中四星组选6。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'SXZU4': {
                    'name': '组选4',
                    'method': 'SXZU4',
                    'desc': '从“三重号”中选择一个号码，“单号”中选择一个号码组成一注。',
                    'help': '选择1个三重号码和1个单号号码组成一注，所选号码与开奖号码的千位、百位、十位、个位相同，且所选三重号码在开奖号码中出现了3次，即为中奖。',
                    'example': '投注方案：三重号：8；单号：2<br>开奖号码：8828（顺序不限），即可中四星组选4。',
                    'type': 'multi',
                    'layout': {
                        '三重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '前三': {
            '前三直选': {
                'QZX3': {
                    'name': '直选复式',
                    'method': 'ZX3',
                    'desc': '从万位、千位、百位各选一个号码组成一注。',
                    'help': '从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：前三位 345，即中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX3_S': {
                    'name': '直选单式',
                    'method': 'ZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：前三位 345，即中前三直选。',
                    'type': 'text',
                    'b64': 3
                },
                'QZH3': {
                    'name': '前三组合',
                    'method': 'ZH3',
                    'desc': '从万位、千位、百位各选一个号码组成三注。',
                    'help': '从万位、千位、百位中至少各选择一个号码组成1-3星的组合共三注，当百位号码与开奖号码相同，则中1个3等奖；<br>如果百位与千位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。',
                    'example': '投注方案：购买：6+7+8，该票共6元，由以上3注：678(三星)、78(二星)、8(一星)构成<br>开奖号码：前三位 678，即可中三星、二星、一星各1注。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZXHZ': {
                    'name': '直选和值',
                    'method': 'ZXHZ',
                    'desc': '从0-27中任意选择1个或1个以上号码。',
                    'help': '所选数值等于开奖号码的万位、千位、百位三个数字相加之和，即为中奖。',
                    'example': '投注方案：和值 1<br>开奖号码：前三位 001、010、100，即中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': []
                },
                'QZXKD': {
                    'name': '直选跨度',
                    'method': 'ZXKD',
                    'desc': '从0-9中选择1个号码。',
                    'help': '所选数值等于开奖号码的前3位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度8<br>开奖号码：前三位0,8,X，其中X不等于9；或者前三位1,9,X，其中X不等于0，即可中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '前三组选': {
                'QZUS': {
                    'name': '组三复式',
                    'method': 'ZUS',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选择2个数字组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：前三位588（顺序不限），即可中前三组选三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZUS_S': {
                    'name': '组三单式',
                    'method': 'ZUS_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字当中必须有二个数字相同）。',
                    'help': '手动输入一个3位数号码组成一注，三个数字当中必须有两个数字相同，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：前三位588（顺序不限），即可中前三组选三。',
                    'type': 'text'
                },
                'QZUL': {
                    'name': '组六复式',
                    'method': 'ZUL',
                    'desc': '从0-9中任意选择3个或3个以上号码。',
                    'help': '从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。',
                    'example': '投注方案：258<br>开奖号码：前三位 852（顺序不限），即中前三组选六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZUL_S': {
                    'name': '组六单式',
                    'method': 'ZUL_S',
                    'desc': '手动输入号码，至少输入1个三位数号（三个数字全不相同）。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：前三位 312（顺序不限），即中前三组选六。',
                    'type': 'text'
                },
                'QHHZX': {
                    'name': '混合组选',
                    'method': 'HHZX',
                    'desc': '手动输入号码，至少输入1个三位数号码。',
                    'help': '手动输入一个3位数号码组成一注（不含豹子号），开奖号码的万位、千位、百位符合前三组三或组六均为中奖。',
                    'example': '投注方案：001 和 123<br>开奖号码：前三位 010（顺序不限）即中前三组选三，或者前三位 312（顺序不限）即中前三组选六。',
                    'type': 'text',
                    'b64': 3
                },
                'QZUHZ': {
                    'name': '组选和值',
                    'method': 'ZUHZ',
                    'desc': '从1-26中任意选择1个以上号码。',
                    'help': '所选数值等于开奖号码万位、千位、百位三个数字相加之和(非豹子号)，即为中奖。',
                    'example': '投注方案：和值3<br>开奖号码：前三位 003（顺序不限）即中前三组选三，或者前三位 012（顺序不限）即中前三组选六。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': []
                },
                'QZU3BD': {
                    'name': '组选包胆',
                    'method': 'ZU3BD',
                    'desc': '从0-9中任选1个号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的万位、千位、百位中任意1位只要和所选包胆号码相同(不含豹子号)，即为中奖。',
                    'example': '投注方案：包胆3<br>开奖号码：前三位 3XX 或者 33X，即中前三组选三，或者前三位 3XY，即中前三组选六。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            },
            '前三其他': {
                'QHZWS': {
                    'name': '和值尾数',
                    'method': 'HZWS',
                    'desc': '从0-9中选择1个号码。',
                    'help': '所选数值等于开奖号码的万位、千位、百位三个数字相加之和的尾数，即为中奖。',
                    'example': '投注方案：和值尾数 8开奖号码：前三位 936，和值尾数为8，即中和值尾数。',
                    'type': 'multi',
                    'layout': {
                        '和值尾数': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QTS3': {
                    'name': '特殊号',
                    'method': 'TS3',
                    'desc': '选择一个号码形态。',
                    'help': '所选的号码特殊属性和开奖号码前3位的属性一致，即为中奖。<br>其中：1.顺子号的万、千、百位不分顺序；<br>2.对子号指的是开奖号码的前三位当中，任意2位数字相同的三位数号码。',
                    'example': '投注方案：豹子顺子对子<br>开奖号码：前三位 888，即中豹子；前三位 678，即中顺子；前三位 558，即中对子。',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '特殊号': [
                            '豹子',
                            '顺子',
                            '对子'
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '中三': {
            '中三直选': {
                'ZZX3': {
                    'name': '直选复式',
                    'method': 'ZX3',
                    'desc': '从千、百、十位中各选一个号码组成一注。',
                    'help': '从千、百、十位中选择一个3位数号码组成一注，所选号码与开奖号码中间3位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：中三位 345，即中 中三直选。',
                    'type': 'multi',
                    'layout': {
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZZX3_S': {
                    'name': '直选单式',
                    'method': 'ZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的千、百、十位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：中间三位 345，即中 中三直选。',
                    'type': 'text',
                    'b64': 3
                },
                'ZZH3': {
                    'name': '中三组合',
                    'method': 'ZH3',
                    'desc': '从千、百、十位中各选一个号码组成三注。',
                    'help': '从千、百、十位中至少各选择一个号码组成1-3星的组合共三注，当十位号码与开奖号码相同，则中1个3等奖；<br>如果百位与十位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。',
                    'example': '投注方案：购买：6+7+8，该票共6元，由以上3注：678(三星)、78(二星)、8(一星)构成<br>开奖号码：中间三位 678，即可中三星、二星、一星各1注。',
                    'type': 'multi',
                    'layout': {
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZZXHZ': {
                    'name': '直选和值',
                    'method': 'ZXHZ',
                    'desc': '从0-27中任意选择1个或1个以上号码。',
                    'help': '所选数值等于开奖号码的千、百、十位中三个数字相加之和，即为中奖。',
                    'example': '投注方案：和值 1<br>开奖号码：中三位 001、010、100，即中中三直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': []
                },
                'ZZXKD': {
                    'name': '直选跨度',
                    'method': 'ZXKD',
                    'desc': '从0-9中选择1个号码。',
                    'help': '所选数值等于开奖号码的中3位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度8<br>开奖号码：中三位0,8,X，其中X不等于9；或者中三位1,9,X，其中X不等于0，即可中 中三直选。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '中三组选': {
                'ZZUS': {
                    'name': '组三复式',
                    'method': 'ZUS',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选择2个数字组成两注，所选号码与开奖号码的千、百、十位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：中间三位588（顺序不限），即可中 中三组选三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZZUS_S': {
                    'name': '组三单式',
                    'method': 'ZUS_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字当中必须有二个数字相同）。',
                    'help': '手动输入一个3位数号码组成一注，三个数字当中必须有两个数字相同，所选号码与开奖号码的千位、百位、十位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：中间三位588（顺序不限），即可中 中三组选三。',
                    'type': 'text'
                },
                'ZZUL': {
                    'name': '组六复式',
                    'method': 'ZUL',
                    'desc': '从0-9中任意选择3个或3个以上号码。',
                    'help': '从0-9中任意选择3个号码组成一注，所选号码与开奖号码的千、百、十位相同，顺序不限，即为中奖。',
                    'example': '投注方案：258<br>开奖号码：中间三位 852（顺序不限），即中 中三组选六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZZUL_S': {
                    'name': '组六单式',
                    'method': 'ZUL_S',
                    'desc': '手动输入号码，至少输入1个三位数号（三个数字全不相同）。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的千、百、十位相同，顺序不限，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：中间三位 312（顺序不限），即中 中三组选六。',
                    'type': 'text'
                },
                'ZHHZX': {
                    'name': '混合组选',
                    'method': 'HHZX',
                    'desc': '手动输入号码，至少输入1个三位数号码。',
                    'help': '手动输入一个3位数号码组成一注（不含豹子号），开奖号码的千、百、十位符合中三组三或组六均为中奖。',
                    'example': '投注方案：001 和 123<br>开奖号码：中间三位 010（顺序不限）即中 中三组选三，或者中三位 312（顺序不限）即中 中三组选六。',
                    'type': 'text',
                    'b64': 3
                },
                'ZZUHZ': {
                    'name': '组选和值',
                    'method': 'ZUHZ',
                    'desc': '从1-26中任意选择1个以上号码。',
                    'help': '所选数值等于开奖号码千、百、十位三个数字相加之和(非豹子号)，即为中奖。',
                    'example': '投注方案：和值3<br>开奖号码：中间三位 003（顺序不限）即中 中三组选三，或者中间三位 012（顺序不限）即中 中三组选六。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': []
                },
                'ZZU3BD': {
                    'name': '组选包胆',
                    'method': 'ZU3BD',
                    'desc': '从0-9中任选1个号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的千、百、十位中任意1位只要和所选包胆号码相同(不含豹子号)，即为中奖。',
                    'example': '投注方案：包胆3<br>开奖号码：中三位 3XX 或者 33X，即中 中三组选三，或者中三位 3XY，即中 中三组选六。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            },
            '中三其他': {
                'ZHZWS': {
                    'name': '和值尾数',
                    'method': 'HZWS',
                    'desc': '从0-9中选择1个号码。',
                    'help': '所选数值等于开奖号码的千、百、十位三个数字相加之和的尾数，即为中奖。',
                    'example': '投注方案：和值尾数 8开奖号码：中间三位 936，和值尾数为8，即中和值尾数。',
                    'type': 'multi',
                    'layout': {
                        '和值尾数': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZTS3': {
                    'name': '特殊号',
                    'method': 'TS3',
                    'desc': '选择一个号码形态。',
                    'help': '所选的号码特殊属性和开奖号码中间3位的属性一致，即为中奖。<br>其中：1.顺子号的千、百、十位不分顺序；<br>2.对子号指的是开奖号码的中间三位当中，任意2位数字相同的三位数号码。',
                    'example': '投注方案：豹子顺子对子<br>开奖号码：中间三位 888，即中豹子；中间三位 678，即中顺子；中间三位 558，即中对子。',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '特殊号': [
                            '豹子',
                            '顺子',
                            '对子'
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '后三': {
            '后三直选': {
                'HZX3': {
                    'name': '直选复式',
                    'method': 'ZX3',
                    'desc': '从百位、十位、个位各选一个号码组成一注。',
                    'help': '从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中后三直选。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                },
                'HZX3_S': {
                    'name': '直选单式',
                    'method': 'ZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中后三直选。',
                    'type': 'text',
                    'b64': 3
                },
                'HZH3': {
                    'name': '后三组合',
                    'method': 'ZH3',
                    'desc': '从百位、十位、个位各选一个号码组成三柱。',
                    'help': '从百位、十位、个位中至少各选择一个号码组成1-3星的组合共三注，当个位号码与开奖号码相同，则中1个3等奖；如果个位与十位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。',
                    'example': '购买6+7+8，该票共6元，由一下3注：678（三星）、78（二星）、8（一星）构成<br>开奖号码：后三位 678，即中三星、二星、一星各一注。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZXHZ': {
                    'name': '直选和值',
                    'method': 'ZXHZ',
                    'desc': '从0-27中任意选择1个或1个以上号码。',
                    'help': '所选数值等于开奖号码的百位、十位、个位三个数字相加之和，即为中奖。',
                    'example': '投注方案：和值1<br>开奖号码：后三位001，010，100，即中后三直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': []
                },
                'HZXKD': {
                    'name': '直选跨度',
                    'method': 'ZXKD',
                    'desc': '从0-9中选择1个以上号码。',
                    'help': '所选数值等于开奖号码的后3位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度8<br>开奖号码：后三位0,8,X，其中X不等于9；或者后三位1,9,X，其中X不等于0，即可中后三直选。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '后三组选': {
                'HZUS': {
                    'name': '组三复式',
                    'method': 'ZUS',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选择2个数字组成两注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：后三位588（顺序不限），即可中后三组选三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZUS_S': {
                    'name': '组三单式',
                    'method': 'ZUS_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字中必须有二个数字相同）。',
                    'help': '手动输入一个3位数号码组成一注，三个数字中必须有二个数字相同，输入号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。',
                    'example': '投注方案：001<br>开奖号码：后三位 010（顺序不限），即中后三组选三。',
                    'type': 'text'
                },
                'HZUL': {
                    'name': '组六复式',
                    'method': 'ZUL',
                    'desc': '从0-9中任意选择3个或3个以上号码。',
                    'help': '从0-9中任意选择3个号码组成一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。',
                    'example': '投注方案：258<br>开奖号码：后三位 852（顺序不限），即中后三组选六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZUL_S': {
                    'name': '组六单式',
                    'method': 'ZUL_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字完全不相同）。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：后三位 321（顺序不限），即中后三组选六。',
                    'type': 'text'
                },
                'HHHZX': {
                    'name': '混合组选',
                    'method': 'HHZX',
                    'desc': '手动输入号码，至少输入1个三位数号码。',
                    'help': '手动输入一个3位数号码组成一注（不含豹子号），开奖号码的百位、十位、个位符合后三组三或者组六均为中奖。',
                    'example': '投注方案：001 和 123<br>开奖号码：后三位 010（顺序不限）即中后三组选三，或者后三位 312（顺序不限）即中后三组选六。',
                    'type': 'text',
                    'b64': 3
                },
                'HZUHZ': {
                    'name': '组选和值',
                    'method': 'ZUHZ',
                    'desc': '从1-26中选择1个号码。',
                    'help': '所选数值等于开奖号码百位、十位、个位三个数字相加之和(非豹子号)，即为中奖。',
                    'example': '投注方案：和值3<br>开奖号码：后三位 003（顺序不限）即中后三组选三，或者后三位 012（顺序不限）即中后三组选六。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': []
                },
                'HZU3BD': {
                    'name': '组选包胆',
                    'method': 'ZU3BD',
                    'desc': '从0-9中选择1个号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的百位、十位、个位中任意1位与所选包胆号码相同(不含豹子号)，即为中奖。',
                    'example': '投注方案：包胆3<br>开奖号码：后三位 3XX 或者 33X，即中后三组选三，后三位 3XY，即中后三组选六。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            },
            '后三其他': {
                'HHZWS': {
                    'name': '和值尾数',
                    'method': 'HZWS',
                    'desc': '从0-9中选择1个号码。',
                    'help': '所选数值等于开奖号码的百位、十位、个位三个数字相加之和的尾数，即为中奖。',
                    'example': '投注方案：和值尾数 8<br>开奖号码：后三位 936，和值尾数为8，即中和值尾数。',
                    'type': 'multi',
                    'layout': {
                        '和值尾数': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HTS3': {
                    'name': '特殊号',
                    'method': 'TS3',
                    'desc': '选择一个号码形态。',
                    'help': '所选的号码特殊属性和开奖号码后3位的属性一致，即为中奖。其中：1.顺子号的个、十、百位不分顺序；2.对子号指的是开奖号码的后三位当中，任意2位数字相同的三位数号码。',
                    'example': '投注方案：豹子顺子对子<br>开奖号码：后三位 888，即中豹子；后三位 678，即中顺子；后三位 558，即中对子。',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '特殊号': [
                            '豹子',
                            '顺子',
                            '对子'
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '前二': {
            '前二直选': {
                'QZX2': {
                    'name': '直选复式',
                    'method': 'ZX2',
                    'desc': '从万位、千位中至少各选1个号码组成一注。',
                    'help': '从万位、千位中选择一个2位数号码组成一注，所选号码与开奖号码的前2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX2_S': {
                    'name': '直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的万位、千位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'text'
                },
                'QZXHZ2': {
                    'name': '直选和值',
                    'method': 'ZXHZ2',
                    'desc': '从0-18中任意选择1个或1个以上的和值号码。',
                    'help': '所选数值等于开奖号码的万位、千位二个数字相加之和，即为中奖。',
                    'example': '投注方案：和值1<br>开奖号码：前二位 01，10，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhz2Tpl
                    },
                    'buttons': []
                },
                'QZXKD2': {
                    'name': '直选跨度',
                    'method': 'ZXKD2',
                    'desc': '从0-9中任意选择1个号码组成一注。',
                    'help': '所选数值等于开奖号码的前2位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度9<br>开奖号码：前二位 90或09，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '前二组选': {
                'QZU2': {
                    'name': '组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的万位、千位相同，顺序不限，即中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZU2_S': {
                    'name': '组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的万位、千位与开奖号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'text'
                },
                'QZUHZ2': {
                    'name': '组选和值',
                    'method': 'ZUHZ2',
                    'desc': '从1-17中任意选择1个或者1个以上号码。',
                    'help': '所选数值等于开奖号码的万位、千位二个数字相加之和（不含对子号），即为中奖。',
                    'example': '投注方案：和值 1<br>开奖号码：前二位 10 或者 01（顺序不限，不含对子号），即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhz2Tpl
                    },
                    'buttons': []
                },
                'QZU2BD': {
                    'name': '组选包胆',
                    'method': 'ZU2BD',
                    'desc': '从0-9中任意选择1个包胆号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的万位，千位中任意1位包含所选的包胆号码相同（不含对子号），即为中奖。',
                    'example': '投注方案：包胆 8 <br>开奖号码：前二位 8X，且X不等于8，即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            }
        },
        '后二': {
            '后二直选': {
                'HZX2': {
                    'name': '直选复式',
                    'method': 'ZX2',
                    'desc': '从十位、个位中至少各选1个号码组成一注。',
                    'help': '从十位、个位中选择一个2位数号码组成一注，所选号码与开奖号码的后2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'multi',
                    'layout': {
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZX2_S': {
                    'name': '直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'text'
                },
                'HZXHZ2': {
                    'name': '直选和值',
                    'method': 'ZXHZ2',
                    'desc': '从0-18中任意选择1个或1个以上的和值号码。',
                    'help': '所选数值等于开奖号码的十位、个位二个数字相加之和，即为中奖。',
                    'example': '投注方案：和值1<br>开奖号码：后二位 01，10，即中后二直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhz2Tpl
                    },
                    'buttons': []
                },
                'HZXKD2': {
                    'name': '直选跨度',
                    'method': 'ZXKD2',
                    'desc': '从0-9中任意选择1个号码组成一注。',
                    'help': '所选数值等于开奖号码的后2位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度9<br>开奖号码：后二位 90或09，即中后二直选。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '后二组选': {
                'HZU2': {
                    'name': '组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同（不含对子号），顺序不限，即中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 85 或者 58（顺序不限，不含对子号），即中后二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZU2_S': {
                    'name': '组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同（不含对子号），顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 85 或者 58（顺序不限，不含对子号），即中后二组选。',
                    'type': 'text'
                },
                'HZUHZ2': {
                    'name': '组选和值',
                    'method': 'ZUHZ2',
                    'desc': '从1-17中任意选择1个或者1个以上号码。',
                    'help': '所选数值等于开奖号码的十位、个位二个数字相加之和（不含对子号），即为中奖。',
                    'example': '投注方案：和值 1<br>开奖号码：后二位 10 或者 01（顺序不限，不含对子号），即中后二组选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhz2Tpl
                    },
                    'buttons': []
                },
                'HZU2BD': {
                    'name': '组选包胆',
                    'method': 'ZU2BD',
                    'desc': '从0-9中任意选择1个包胆号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的十位，个位中任意1位包含所选的包胆号码相同（不含对子号），即为中奖。',
                    'example': '投注方案：包胆 8 <br>开奖号码：后二位 8X，且X不等于8，即中后二组选。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            }
        },
        '定位胆': {
            'default': {
                'DWD': {
                    'name': '定位胆',
                    'method': 'DWD',
                    'desc': '在万位、千位、百位、十位、个位任意位置上任意选择1个或1个以上号码。',
                    'help': '从万位、千位、百位、十位、个位任意位置上至少选择1个以上号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                    'example': '投注方案：万位 1<br>开奖号码：万位 1，即中定位胆万位。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '不定位': {
            '三星': {
                'HBDW1': {
                    'name': '后三一码',
                    'method': 'BDW1',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的百位、十位、个位中包含所选号码，即为中奖。',
                    'example': '投注方案：1<br>开奖号码：后三位至少出现1个1，即中后三一码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QBDW1': {
                    'name': '前三一码',
                    'method': 'BDW1',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的万位、千位、百位中包含所选号码，即为中奖。',
                    'example': '投注方案：1<br>开奖号码：前三位，至少出现1个1，即中前三一码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HBDW2': {
                    'name': '后三二码',
                    'method': 'BDW2',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：后三位，至少出现1和2各1个，即中后三二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QBDW2': {
                    'name': '前三二码',
                    'method': 'BDW2',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：前三位，至少出现1和2各1个，即中前三二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '四星': {
                'BDW41': {
                    'name': '四星一码',
                    'method': 'BDW41',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的千位、百位、十位、个位中包含所选号码，即为中奖。',
                    'example': '投注方案：1<br>开奖号码：后四位，至少出现1个1，即中四星一码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'BDW42': {
                    'name': '四星二码',
                    'method': 'BDW42',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的千位、百位、十位、个位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：后四位，至少出现1和2各一个，即中四星二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '五星': {
                'BDW52': {
                    'name': '五星二码',
                    'method': 'BDW52',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位、十位、个位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：至少出现1和2各一个，即中五星二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'BDW53': {
                    'name': '五星三码',
                    'method': 'BDW53',
                    'desc': '从0-9中任意选择3个以上号码。',
                    'help': '从0-9中选择3个号码，每注由3个不同的号码组成，开奖号码的万位、千位、百位、十位、个位中同时包含所选的3个号码，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：至少出现1、2、3各1个，即中五星三码不定位。',
                    'type': 'multi',
                    'layout': {
                        '不定位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '大小单双': {
            '大小单双': {
                'QDXDS': {
                    'name': '前二大小单双',
                    'method': 'DXDS',
                    'desc': '从万位、千位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对万位、千位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：小双<br>开奖号码：万位与千位“小双”，即中前二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '万位': digitalDxdsTpl,
                        '千位': digitalDxdsTpl
                    },
                    'buttons': [
                        '清'
                    ]
                },
                'HDXDS': {
                    'name': '后二大小单双',
                    'method': 'DXDS',
                    'desc': '从十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单<br>开奖号码：十位与个位“小双”，即中后二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '十位': digitalDxdsTpl,
                        '个位': digitalDxdsTpl
                    },
                    'buttons': [
                        '清'
                    ]
                },
                'QDXDS3': {
                    'name': '前三大小单双',
                    'method': 'DXDS3',
                    'desc': '从万位、千位、百位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对万位、千位和百位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：小双小<br>开奖号码：万位、千位、百位“小双小”，即中前三大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '万位': digitalDxdsTpl,
                        '千位': digitalDxdsTpl,
                        '百位': digitalDxdsTpl
                    },
                    'buttons': [
                        '清'
                    ]
                },
                'HDXDS3': {
                    'name': '后三大小单双',
                    'method': 'DXDS3',
                    'desc': '从百位、十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对百位、十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单大<br>开奖号码：百位、十位、个位“大单大”，即中后三大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '百位': digitalDxdsTpl,
                        '十位': digitalDxdsTpl,
                        '个位': digitalDxdsTpl
                    },
                    'buttons': [
                        '清'
                    ]
                }
            }
        },
        '任选二': {
            '任二直选': {
                'RZX2': {
                    'name': '直选复式',
                    'method': 'RZX2',
                    'desc': '从万位、千位、百位、十位、个位中至少两位上各选1个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少两位上各选1个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：万位5，百位8<br>开奖号码：51812，即中任二直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': []
                },
                'RZX2_S': {
                    'name': '直选单式',
                    'method': 'RZX2_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择两个位置,至少手动输入一个两位数的号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,至少手动输入一个两位数的号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：位置选择万位、百位，输入号码58<br>开奖号码：51812，即中任二直选(单式)。',
                    'type': 'text',
                    'pc': [
                        's',
                        'g'
                    ]
                },
                'RZXHZ2': {
                    'name': '直选和值',
                    'method': 'RZXHZ2',
                    'desc': '从万位、千位、百位、十位、个位中至少选择两个位置,至少选择一个和值号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,至少选择一个和值号码构成一注，所选号码与开奖号码的和值相同，即为中奖。',
                    'example': '投注方案：位置选择万位、百位，选择和值号码13<br>开奖号码：51812，即中任二直选(单式)。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhz2Tpl
                    },
                    'buttons': [],
                    'pc': [
                        's',
                        'g'
                    ]
                }
            },
            '任二组选': {
                'RZU2': {
                    'name': '组选复式',
                    'method': 'RZU2',
                    'desc': '从万位、千位、百位、十位、个位中至少选择两个位置,号码区至少选择两个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,号码区至少选择两个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：位置选择万位、百位，选择号码85<br>开奖号码：51812或者81512，即中任二组选。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        's',
                        'g'
                    ]
                },
                'RZU2_S': {
                    'name': '组选单式',
                    'method': 'RZU2_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择两个位置,至少手动输入一个两位数的号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,至少手动输入一个两位数的号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：位置选择万位、百位，输入号码85<br>开奖号码：51812或者81512，即中任二组选(单式)。',
                    'type': 'text',
                    'pc': [
                        's',
                        'g'
                    ]
                },
                'RZUHZ2': {
                    'name': '组选和值',
                    'method': 'RZUHZ2',
                    'desc': '从万位、千位、百位、十位、个位中至少选择两个位置,至少选择一个和值号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,至少选择一个和值号码构成一注，所选号码与开奖号码的和值相同，即为中奖。',
                    'example': '投注方案：位置选择万位、百位，选择和值号码13<br>开奖号码：51812，即中任二组选和值。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhz2Tpl
                    },
                    'buttons': [],
                    'pc': [
                        's',
                        'g'
                    ]
                }
            }
        },
        '任选三': {
            '任三直选': {
                'RZX3': {
                    'name': '直选复式',
                    'method': 'RZX3',
                    'desc': '从万位、千位、百位、十位、个位中至少三位上各选1个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少三位上各选1个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：万位5，百8,个位2<br>开奖号码：51812，即中任三直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': []
                },
                'RZX3_S': {
                    'name': '直选单式',
                    'method': 'RZX3_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,至少手动输入一个三位数的号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,至少手动输入一个三位数的号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：位置选择万位、百位,个位，输入号码582<br>开奖号码：51812，即中任三直选(单式)。',
                    'type': 'text',
                    'pc': [
                        'b',
                        's',
                        'g'
                    ],
                    'b64': 3
                },
                'RZXHZ': {
                    'name': '直选和值',
                    'method': 'RZXHZ',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,至少选择一个和值号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,至少选择一个和值号码构成一注，所选号码与开奖号码的和值相同，即为中奖。',
                    'example': '投注方案：位置选择万位、百位、个位，选择和值号码15<br>开奖号码：51812，即中任二直选(单式)。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': [],
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                }
            },
            '任三组选': {
                'RZUS': {
                    'name': '组三复式',
                    'method': 'RZUS',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,号码区至少选择两个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,号码区至少选择两个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：选择位置万位、十位、个位,选择号码12<br>开奖号码：11812，即中任三组三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                },
                'RZUS_S': {
                    'name': '组三单式',
                    'method': 'RZUS_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入两个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入两个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：选择位置万位、十位、个位,输入号码12<br>开奖号码：11812，即中任三组三(单式)。',
                    'type': 'text',
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                },
                'RZUL': {
                    'name': '组六复式',
                    'method': 'RZUL',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,号码区至少选择三个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,号码区至少选择三个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：选择位置万位、十位、个位,选择号码512<br>开奖号码：51812，即中任三组六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                },
                'RZUL_S': {
                    'name': '组六单式',
                    'method': 'RZUL_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入三个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入三个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：选择位置万位、十位、个位,输入号码512<br>开奖号码：51812，即中任三组六(单式)。',
                    'type': 'text',
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                },
                'RHHZX': {
                    'name': '混合组选',
                    'method': 'RHHZX',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入三个号码构成一注(不包含豹子号)。',
                    'help': '从万位、千位、百位、十位、个位中至少选择三个位置,手动至少输入三个号码构成一注(不包含豹子号)，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：勾选位置千位、百位、个位，分别投注(0,0,1)，以及(1,2,3),开奖号码：*00*1，顺序不限，即中任三组三；或者(2)*21*3，顺序不限，即中任三组六。',
                    'type': 'text',
                    'pc': [
                        'b',
                        's',
                        'g'
                    ],
                    'b64': 3
                },
                'RZUHZ': {
                    'name': '组选和值',
                    'method': 'RZUHZ',
                    'desc': '从万位、千位、百位、十位、个位中至少选择三个位置,至少选择一个和值号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择两个位置,至少选择一个和值号码构成一注，所选号码与开奖号码的和值(不包含豹子号)相同，即为中奖。',
                    'example': '投注方案：选择位置万位、十位、个位,选择和值号码8<br>开奖号码：51812，即中任三组选和值。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': [],
                    'pc': [
                        'b',
                        's',
                        'g'
                    ]
                }
            }
        },
        '任选四': {
            '任四直选': {
                'RZX4': {
                    'name': '直选复式',
                    'method': 'RZX4',
                    'desc': '从万位、千位、百位、十位、个位中至少四位上各选1个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少四位上各选1个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：万位5，千位1,百位8,十位1<br>开奖号码：51812，即中任四直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': []
                },
                'RZX4_S': {
                    'name': '直选单式',
                    'method': 'RZX4_S',
                    'desc': '从万位、千位、百位、十位、个位中至少选择四个位置,至少手动输入一个四位数的号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择四个位置,至少手动输入一个四位数的号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：选择万位、千位、百位、十位，输入号码5181<br>开奖号码：51812，即中任四直选(单式)。',
                    'type': 'text',
                    'pc': [
                        'q',
                        'b',
                        's',
                        'g'
                    ],
                    'b64': 4
                }
            },
            '任四组选': {
                'RSXZU24': {
                    'name': '组选24',
                    'method': 'RSXZU24',
                    'desc': '从万位、千位、百位、十位、个位中至少选择四个位置,号码区至少选择四个号码构成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择四个位置,号码区至少选择四个号码构成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序不限，即为中奖。',
                    'example': '投注方案：位置选择千位、百位、十位、个位,号码选择0568<br>开奖号码：10568(指定位置号码顺序不限)，即可中任四组选24。',
                    'type': 'multi',
                    'layout': {
                        '组选24': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'q',
                        'b',
                        's',
                        'g'
                    ]
                },
                'RSXZU12': {
                    'name': '组选12',
                    'method': 'RSXZU12',
                    'desc': '从万位、千位、百位、十位、个位中至少选择四个位置,从“二重号”和“单号”中各选择两个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择四个位置，然后选择1个二重号码和2个单号号码组成一注，所选4个位置的开奖号码中包含与所选号码，且所选二重号码在所选4个位置的开奖号码中出现了2次，即为中奖。',
                    'example': '投注方案：位置选择千位、百位、十位、个位,二重号：8；单号：06<br>开奖号码：10688(指定位置号码顺序不限)，即可中任四组选12。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'q',
                        'b',
                        's',
                        'g'
                    ]
                },
                'RSXZU6': {
                    'name': '组选6',
                    'method': 'RSXZU6',
                    'desc': '从万位、千位、百位、十位、个位中至少选择四个位置,从“二重号”中选择两个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择四个位置，从“二重号”中选择两个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且二重号在指定位置中分别出现了2次，即为中奖。',
                    'example': '投注方案：位置选择千位、百位、十位、个位,二重号：28<br>开奖号码：12288(指定位置号码顺序不限)，即可中任四组选6。',
                    'type': 'multi',
                    'layout': {
                        '二重号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'q',
                        'b',
                        's',
                        'g'
                    ]
                },
                'RSXZU4': {
                    'name': '组选4',
                    'method': 'RSXZU4',
                    'desc': '从万位、千位、百位、十位、个位中至少选择四个位置,从“三重号”和“单号”中各选择一个号码组成一注。',
                    'help': '从万位、千位、百位、十位、个位中至少选择四个位置，从“三重号”和”单号”中各选择一个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且三重号号码在指定位置中出现了3次，即为中奖。',
                    'example': '投注方案：位置选择千位、百位、十位、个位,三重号：8；单号：2<br>开奖号码：18828(指定位置号码顺序不限)，即可中任四组选4。',
                    'type': 'multi',
                    'layout': {
                        '三重号': digitalCodesTpl,
                        '单　号': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'pc': [
                        'q',
                        'b',
                        's',
                        'g'
                    ]
                }
            }
        }
    },
    'digital3': {
        '三星': {
            '三星直选': {
                'ZX3': {
                    'name': '直选复式',
                    'method': 'ZX3',
                    'desc': '从百位、十位、个位各选一个号码组成一注。',
                    'help': '从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中三星直选。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZX3_S': {
                    'name': '直选单式',
                    'method': 'ZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中三星直选。',
                    'type': 'text',
                    'number': 3,
                    'b64': 3
                },
                'ZH3': {
                    'name': '直选组合',
                    'method': 'ZH3',
                    'desc': '从百位、十位、个位各选一个号码组成三柱。',
                    'help': '从百位、十位、个位中至少各选择一个号码组成1-3星的组合共三注，当个位号码与开奖号码相同，则中1个3等奖；如果个位与十位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。',
                    'example': '投注方案：购买：6+7+8，该票共6元，由以下3注：678(三星)、78(二星)、8(一星)构成<br>开奖号码：678，即可中三星、二星、一星各1注。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZXHZ': {
                    'name': '直选和值',
                    'method': 'ZXHZ',
                    'desc': '从0-27中任意选择1个或1个以上号码。',
                    'help': '所选数值等于开奖号码的百位、十位、个位三个数字相加之和，即为中奖。',
                    'example': '投注方案：和值1<br>开奖号码：三位001，010，100，即中三星直选。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': []
                },
                'ZXKD': {
                    'name': '直选跨度',
                    'method': 'ZXKD',
                    'desc': '从0-9中选择1个以上号码。',
                    'help': '所选数值等于开奖号码的后3位最大与最小数字相减之差，即为中奖。',
                    'example': '投注方案：跨度8<br>开奖号码：百十个位0,8,X，其中X不等于9；或者百十个位1,9,X，其中X不等于0，即中直选跨度。',
                    'type': 'multi',
                    'layout': {
                        '跨度': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            },
            '三星组选': {
                'ZUS': {
                    'name': '组三复式',
                    'method': 'ZUS',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选择2个数字组成两注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：588（顺序不限），即可中三星组选三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZUS_S': {
                    'name': '组三单式',
                    'method': 'ZUS_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字中必须有二个数字相同）。',
                    'help': '手动输入一个3位数号码组成一注，三个数字中必须有二个数字相同，输入号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。',
                    'example': '投注方案：001<br>开奖号码：010（顺序不限），即中三星组选三。',
                    'type': 'text',
                    'number': 3
                },
                'ZUL': {
                    'name': '组六复式',
                    'method': 'ZUL',
                    'desc': '从0-9中任意选择3个或3个以上号码。',
                    'help': '从0-9中任意选择3个号码组成一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。',
                    'example': '投注方案：258<br>开奖号码：852（顺序不限），即中三星组选六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'ZUL_S': {
                    'name': '组六单式',
                    'method': 'ZUL_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字完全不相同）。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：321（顺序不限），即中三星组选六。',
                    'type': 'text',
                    'number': 3
                },
                'HHZX': {
                    'name': '混合组选',
                    'method': 'HHZX',
                    'desc': '手动输入号码，至少输入1个三位数号码。',
                    'help': '手动输入一个3位数号码组成一注（不含豹子号），开奖号码的百位、十位、个位符合后三组三或者组六均为中奖。',
                    'example': '投注方案：001 和 123<br>开奖号码：010（顺序不限）即中三星组选三，或者 312（顺序不限）即中三星组选六。',
                    'type': 'text',
                    'number': 3,
                    'b64': 3
                },
                'ZUHZ': {
                    'name': '组选和值',
                    'method': 'ZUHZ',
                    'desc': '从1-26中选择1个号码。',
                    'help': '所选数值等于开奖号码百位、十位、个位三个数字相加之和(非豹子号)，即为中奖。',
                    'example': '投注方案：和值3<br>开奖号码：003（顺序不限）即中三星组选三，或者 012（顺序不限）即中三星组选六。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': []
                },
                'ZU3BD': {
                    'name': '组选包胆',
                    'method': 'ZU3BD',
                    'desc': '从0-9中选择1个号码。',
                    'help': '从0-9中任意选择1个包胆号码，开奖号码的百位、十位、个位中任意1位与所选包胆号码相同(不含豹子号)，即为中奖。',
                    'example': '投注方案：包胆3<br>开奖号码：3XX 或者 33X，即中三星组选三，3XY，即中三星组选六。',
                    'type': 'multi',
                    'layout': {
                        '包胆': digitalCodesTpl
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1
                    ]
                }
            }
        },
        '二星': {
            '二星直选': {
                'QZX2': {
                    'name': '(前二)直选复式',
                    'method': 'ZX2',
                    'desc': '从百位、十位中至少各选1个号码组成一注。',
                    'help': '从百位、十位中选择一个2位数号码组成一注，所选号码与开奖号码的前2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX2_S': {
                    'name': '(前二)直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的百位、十位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'text',
                    'number': 3
                },
                'HZX2': {
                    'name': '(后二)直选复式',
                    'method': 'ZX2',
                    'desc': '从十位、个位中至少各选1个号码组成一注。',
                    'help': '从十位、个位中选择一个2位数号码组成一注，所选号码与开奖号码的后2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'multi',
                    'layout': {
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZX2_S': {
                    'name': '(后二)直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'text',
                    'number': 3
                }
            },
            '二星组选': {
                'QZU2': {
                    'name': '(前二)组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的百位、十位相同，顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZU2_S': {
                    'name': '(前二)组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的万位、千位与开奖号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'text',
                    'number': 3
                },
                'HZU2': {
                    'name': '(后二)组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同（不含对子号），顺序不限，即中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 85 或者 58（顺序不限，不含对子号），即中后二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZU2_S': {
                    'name': '(后二)组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同（不含对子号），顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'text',
                    'number': 3
                }
            }
        },
        '定位胆': {
            '定位胆': {
                'DWD': {
                    'name': '定位胆',
                    'method': 'DWD',
                    'desc': '在百位、十位、个位任意位置上任意选择1个或1个以上号码。',
                    'help': '从百位、十位、个位任意位置上至少选择1个以上号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                    'example': '投注方案：百位 1<br>开奖号码：百位 1，即中定位胆百位。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '不定位': {
            '不定位': {
                'BDW1': {
                    'name': '一码不定位',
                    'method': 'BDW1',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的百位、十位、个位中包含所选号码，即为中奖。',
                    'example': '投注方案：1<br>开奖号码：至少出现1个1，即中一码不定位。',
                    'type': 'multi',
                    'layout': {
                        '一码': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'BDW2': {
                    'name': '二码不定位',
                    'method': 'BDW2',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：至少出现1和2各1个，即中二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '二码': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '大小单双': {
            '大小单双': {
                'QDXDS': {
                    'name': '前二大小单双',
                    'method': 'DXDS',
                    'desc': '从百位、十位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对百位和十位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单<br>开奖号码：百位与十位“大单”，即中前二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '百位': digitalDxdsTpl,
                        '十位': digitalDxdsTpl
                    },
                    'buttons': []
                },
                'HDXDS': {
                    'name': '后二大小单双',
                    'method': 'DXDS',
                    'desc': '从十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单<br>开奖号码：十位与个位“大单”，即中后二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '十位': digitalDxdsTpl,
                        '个位': digitalDxdsTpl
                    },
                    'buttons': []
                }
            }
        }
    },
    'ks': {
        '和值': {
            'default': {
                'KSHZ': {
                    'name': '和值',
                    'method': 'KSHZ',
                    'desc': '是指对三个号码的和值进行投注,和值从3到18',
                    'help': '是指对三个号码的和值进行投注,和值从3到18,开奖三个号码的和值等于购买的号码则中奖',
                    'example': '购买号码:5<br>开奖号码:113',
                    'type': 'multi',
                    'layout': {
                        '和值号': [
                            3,
                            4,
                            5,
                            6,
                            7,
                            8,
                            9,
                            10,
                            11,
                            12,
                            13,
                            14,
                            15,
                            16,
                            17,
                            18
                        ]
                    },
                    'buttons': []
                },

                'KSHZDXDS': {
                    'name': '和值大小单双',
                    'method': 'KSHZDXDS',
                    'desc': '选择1个或者多个结果，如果开奖号码的和值与所选结果符合即中奖',
                    'help': '选择1个或者多个结果，如果开奖号码的和值与所选结果符合即中奖',
                    'example': '投注方案：大<br>开奖号码：开奖号码和值为大，即中和值大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '和值': digitalDxdsTpl
                    },
                    'buttons': []
                }

            }
        },
        '三同号通选': {
            'default': {
                'STHTX': {
                    'name': '三同号通选',
                    'method': 'STHTX',
                    'desc': '是指对所有相同的三个号码(111、222、…、666)进行投注',
                    'help': '是指对所有相同的三个号码(111、222、…、666)进行投注,开奖号码出现任意一个豹子号则中奖',
                    'example': '购买号码:1<br>开奖号码:111',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '号码': [
                            '通选'
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '三同号单选': {
            'default': {
                'STHDX': {
                    'name': '三同号单选',
                    'method': 'STHDX',
                    'desc': '是指从所有相同的三个号码(111、222、…、666)中任意选择一组号码进行投注',
                    'help': '是指从所有相同的三个号码(111、222、…、666)中任意选择一组号码进行投注,开奖号码与购买号完全相同则中奖',
                    'example': '购买号码:111<br>开奖号码:111',
                    'type': 'multi',
                    'lengthen': true,
                    'layout': {
                        '号码': [
                            111,
                            222,
                            333,
                            444,
                            555,
                            666
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '二同号复选': {
            'default': {
                'ETHFX': {
                    'name': '二同号复选',
                    'method': 'ETHFX',
                    'desc': '是指对三个号码中两个指定的相同号码和一个任意号码进行投注',
                    'help': '是指对三个号码中两个指定的相同号码和一个任意号码进行投注,开奖号码中有两个号码相同,与购买号码一样,顺序不限',
                    'example': '购买号码:11*<br>开奖号码:112',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '号码': [
                            '11*',
                            '22*',
                            '33*',
                            '44*',
                            '55*',
                            '66*'
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '二同号单选': {
            'default': {
                'ETHDX': {
                    'name': '标准选号',
                    'method': 'ETHDX',
                    'desc': '是指对三个号码中两个指定的相同号码和一个指定的不同号码进行投注',
                    'help': '是指对三个号码中两个指定的相同号码和一个指定的不同号码进行投注,开奖号码中有两个号码相同,与购买号码一样,顺序不限',
                    'example': '购买号码:112<br>开奖号码:112',
                    'type': 'multi',
                    'lengthen': true,
                    'layout': {
                        '相同号': [
                            11,
                            22,
                            33,
                            44,
                            55,
                            66
                        ],
                        '不同号': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ]
                    },
                    'buttons': [],
                    'limitSelectedSomePosition': true
                },
                'ETHDX_S': {
                    'name': '单式选号',
                    'method': 'ETHDX_S',
                    'desc': '是指对三个号码中两个指定的相同号码和一个指定的不同号码进行投注',
                    'help': '至少输入三个号码中两个指定的相同号码和一个指定的不同号码进行投注，所选号码与开奖号码相同（顺序不限），即中奖。',
                    'example': '购买号码:112<br>开奖号码:112',
                    'type': 'text'
                }
            }
        },
        '三不同号': {
            'default': {
                'SBTH': {
                    'name': '标准选号',
                    'method': 'SBTH',
                    'desc': '是指对三个各不相同的号码进行投注',
                    'help': '是指对三个各不相同的号码进行投注,开奖号三个号码完全不同,并且在购买号码中则中奖',
                    'example': '购买号码:123<br>开奖号码:123',
                    'type': 'multi',
                    'layout': {
                        '号码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ]
                    },
                    'buttons': []
                },
                'SBTH_S': {
                    'name': '单式选号',
                    'method': 'SBTH_S',
                    'desc': '手动输入，至少输入一个3位数,号码由1-6组成的不同的号码。',
                    'help': '手动输入，至少输入一个3位数,号码由1-6组成的不同的号码，所投注的号码与开奖号码的3个号码相同（顺序不限），即为中奖。',
                    'example': '购买号码:123<br>开奖号码:123',
                    'type': 'text'
                },
                'SBTHDT': {
                    'name': '胆拖选号',
                    'method': 'SBTHDT',
                    'desc': '是指对三个各不相同的号码进行投注',
                    'help': '分别从胆码和拖码的1-6中，至少选择1个胆码和2个拖码组成一注，只要所选的每注3个号码与当期开奖号码相同，即为中奖。',
                    'example': '选择胆码 1，选择拖码 34<br>开奖号码为 134，即为中奖。',
                    'type': 'multi',
                    'layout': {
                        '胆码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ],
                        '拖码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ]
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        2,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'SBTHHZ': {
                    'name': '和值选号',
                    'method': 'SBTHHZ',
                    'desc': '是指对三个各不相同的号码的和值进行投注',
                    'help': '是指对三个各不相同的号码的和值进行投注,开奖号三个号码完全不同,并且在购买号码为开奖号码的和值中则中奖',
                    'example': '购买号码:10<br>开奖号码:136或者145或者235',
                    'type': 'multi',
                    'layout': {
                        '和值': [
                            6,
                            7,
                            8,
                            9,
                            10,
                            11,
                            12,
                            13,
                            14,
                            15
                        ]
                    },
                    'buttons': []
                }
            }
        },
        '二不同号': {
            'default': {
                'EBTH': {
                    'name': '标准选号',
                    'method': 'EBTH',
                    'desc': '是指对三个号码中两个指定的不同号码和一个任意号码进行投注',
                    'help': '从1-6中任选2个或多个号码，所选号码与开奖号码任意2个号码相同，即为中奖。',
                    'example': '购买号码:12<br>开奖号码:123',
                    'type': 'multi',
                    'layout': {
                        '号码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ]
                    },
                    'buttons': []
                },
                'EBTH_S': {
                    'name': '单式选号',
                    'method': 'EBTH_S',
                    'desc': '手动输入，至少输入一个2位数,号码由1-6组成的不同的号码。',
                    'help': '手动输入，至少输入一个2位数,号码由1-6组成的不同的号码，所投注的号码与开奖号码任意2个号码相同，即为中奖。 ',
                    'example': '购买号码:12<br>开奖号码:123',
                    'type': 'text'
                },
                'EBTHDT': {
                    'name': '胆拖选号',
                    'method': 'EBTHDT',
                    'desc': '是指对三个号码中两个指定的不同号码和一个任意号码进行投注',
                    'help': '分别从胆码和拖码的1-6中，至少选择1个胆码和1个拖码组成一注，所选的每注2个号码与当期任意2个开奖号码相同，即中奖。 ',
                    'example': '选择胆码 1，选择拖码 3，开奖号码为 134，即为中奖。',
                    'type': 'multi',
                    'layout': {
                        '胆码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ],
                        '拖码': [
                            1,
                            2,
                            3,
                            4,
                            5,
                            6
                        ]
                    },
                    'buttons': [],
                    'limitSelectedCount': [
                        1,
                        999
                    ],
                    'limitSelectedSomePosition': true
                }
            }
        },
        '三连号通选': {
            'default': {
                'SLTHTX': {
                    'name': '三连号通选',
                    'method': 'SLTHTX',
                    'desc': '是指对所有三个相连的号码(仅限：123、234、345、456)进行投注',
                    'help': '是指对所有三个相连的号码(仅限：123、234、345、456)进行投注,开奖号码为任意一个连号则中奖',
                    'example': '购买号码:123<br>开奖号码:123',
                    'type': 'multi',
                    'btnStr': true,
                    'lengthen': true,
                    'layout': {
                        '号码': [
                            '通选'
                        ]
                    },
                    'buttons': []
                }
            }
        }
    },
    'lotto': {
        '三码': {
            'default': {
                'LTZX3': {
                    'name': '前三直选复式',
                    'method': 'LTZX3',
                    'desc': '从第一位、第二位、第三位中至少各选择1个号码。',
                    'help': '从01-11共11个号码中选择3个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：01 02 03 * *，即中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '第一位': lottoCodesTpl,
                        '第二位': lottoCodesTpl,
                        '第三位': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTZX3_S': {
                    'name': '前三直选单式',
                    'method': 'LTZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：01 02 03 * *，即中前三直选。',
                    'type': 'text',
                    'number': 3
                },
                'LTZU3': {
                    'name': '前三组选复式',
                    'method': 'LTZU3',
                    'desc': '从01-11中任意选择3个或3个以上号码。',
                    'help': '从01-11中共11个号码中选择3个号码，所选号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：03 01 02 * *（前三顺序不限），即中前三组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTZU3_S': {
                    'name': '前三组选单式',
                    'method': 'LTZU3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：03 01 02 * *（前三顺序不限），即中前三组选。',
                    'type': 'text',
                    'number': 3
                },
                'LTDTZU3': {
                    'name': '前三组选胆拖',
                    'method': 'LTDTZU3',
                    'desc': '从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。',
                    'help': '从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。<br>所选单注号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：胆码 02，拖码 01 06<br>开奖号码：02 01 06 * *（前三顺序不限），即中前三组选胆拖。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        2,
                        999
                    ],
                    'limitSelectedSomePosition': true
                }
            }
        },
        '二码': {
            'default': {
                'LTZX2': {
                    'name': '前二直选复式',
                    'method': 'LTZX2',
                    'desc': '从第一位、第二位中至少各选择1个号码。',
                    'help': '从01-11共11个号码中选择2个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即中奖。',
                    'example': '投注方案：01 02<br>开奖号码：01 02 * * *，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '第一位': lottoCodesTpl,
                        '第二位': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTZX2_S': {
                    'name': '前二直选单式',
                    'method': 'LTZX2_S',
                    'desc': '手动输入号码，至少输入1个两位数号码组成一注。',
                    'help': '手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02<br>开奖号码：01 02 * * *，即中前二直选。',
                    'type': 'text',
                    'number': 3
                },
                'LTZU2': {
                    'name': '前二组选复式',
                    'method': 'LTZU2',
                    'desc': '从01-11中任意选择2个或2个以上号码。',
                    'help': '从01-11中共11个号码中选择2个号码，所选号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：01 02<br>开奖号码：02 01 * * *，（前二顺序不限），即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTZU2_S': {
                    'name': '前二组选单式',
                    'method': 'LTZU2_S',
                    'desc': '手动输入号码，至少输入1个两位数号码组成一注。',
                    'help': '手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：01 02<br>开奖号码：02 01 * * *，（前二顺序不限），即中前二组选。',
                    'type': 'text',
                    'number': 3
                },
                'LTDTZU2': {
                    'name': '前二组选胆拖',
                    'method': 'LTDTZU2',
                    'desc': '从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。',
                    'help': '从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。<br>所选单注号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：胆码 01，拖码 06<br>开奖号码：06 01 * * *，（前二顺序不限），即中前二组选胆拖。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        1,
                        999
                    ],
                    'limitSelectedSomePosition': true
                }
            }
        },
        '不定位': {
            'default': {
                'LTBDW': {
                    'name': '不定位',
                    'method': 'LTBDW',
                    'desc': '从01-11中任意选择1个或1个以上号码。',
                    'help': '从01-11中共11个号码中选择1个号码，每注由1个号码组成，只要当期顺序摇出的第一位、第二位、第三位开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：01<br>开奖号码：01 * * * *，* 01 * * *，* * 01 * *，即中前三位。',
                    'type': 'multi',
                    'layout': {
                        '前三位': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '定位胆': {
            'default': {
                'LTDWD': {
                    'name': '定位胆',
                    'method': 'LTDWD',
                    'desc': '从第一位，第二位，第三位任意位置上任意选择1个或1个以上号码。',
                    'help': '从第一位，第二位，第三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                    'example': '投注方案：第一位 01<br>开奖号码：01 * * * *，即中定位胆。',
                    'type': 'multi',
                    'layout': {
                        '第一位': lottoCodesTpl,
                        '第二位': lottoCodesTpl,
                        '第三位': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '趣味型': {
            'default': {
                'LTDDS': {
                    'name': '定单双',
                    'method': 'LTDDS',
                    'desc': '从不同的单双组合中任意选择1个或1个以上的组合。',
                    'help': '从6种单双个数组合中选择1种组合，当期开奖号码的单双个数与所选单双组合一致，即为中奖。',
                    'example': '投注方案：5单0双<br>开奖号码：01 03 05 07 09五个单数，即中趣味_定单双。',
                    'type': 'multi',
                    'lengthen': true,
                    'layout': {
                        '定单双': [
                            '5单0双',
                            '4单1双',
                            '3单2双',
                            '2单3双',
                            '1单4双',
                            '0单5双'
                        ]
                    },
                    'buttons': []
                },
                'LTCZW': {
                    'name': '猜中位',
                    'method': 'LTCZW',
                    'desc': '从3-9中任意选择1个或1个以上数字。',
                    'help': '从3-9中选择1个号码进行购买，所选号码与5个开奖号码按照大小顺序排列后的第3个号码相同，即为中奖。',
                    'example': '投注方案：08<br>开奖号码：按号码大小顺序排列后04 05 08 09 11，中间数08，即中趣味_猜中位。',
                    'type': 'multi',
                    'layout': {
                        '猜中位': [
                            '3',
                            '4',
                            '5',
                            '6',
                            '7',
                            '8',
                            '9'
                        ]
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '任选复式': {
            'default': {
                'LTRX1': {
                    'name': '任选一中一',
                    'method': 'LTRX1',
                    'desc': '从01-11中任意选择1个或1个以上号码。',
                    'help': '从01-11共11个号码中选择1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05<br>开奖号码：08 04 11 05 03，即中任选一中一。',
                    'type': 'multi',
                    'layout': {
                        '选1中1': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX2': {
                    'name': '任选二中二',
                    'method': 'LTRX2',
                    'desc': '从01-11中任意选择2个或2个以上号码。',
                    'help': '从01-11共11个号码中选择2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 04<br>开奖号码：08 04 11 05 03，即中任选二中二。',
                    'type': 'multi',
                    'layout': {
                        '选2中2': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX3': {
                    'name': '任选三中三',
                    'method': 'LTRX3',
                    'desc': '从01-11中任意选择3个或3个以上号码。',
                    'help': '从01-11共11个号码中选择3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 04 11<br>开奖号码：08 04 11 05 03，即中任选三中三。',
                    'type': 'multi',
                    'layout': {
                        '选3中3': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX4': {
                    'name': '任选四中四',
                    'method': 'LTRX4',
                    'desc': '从01-11中任意选择4个或4个以上号码。',
                    'help': '从01-11共11个号码中选择4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 04 08 03<br>开奖号码：08 04 11 05 03，即中任选四中四。',
                    'type': 'multi',
                    'layout': {
                        '选4中4': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX5': {
                    'name': '任选五中五',
                    'method': 'LTRX5',
                    'desc': '从01-11中任意选择5个或5个以上号码。',
                    'help': '从01-11共11个号码中选择5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选五中五。',
                    'type': 'multi',
                    'layout': {
                        '选5中5': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX6': {
                    'name': '任选六中五',
                    'method': 'LTRX6',
                    'desc': '从01-11中任意选择6个或6个以上号码。',
                    'help': '从01-11共11个号码中选择6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选六中五。',
                    'type': 'multi',
                    'layout': {
                        '选6中5': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX7': {
                    'name': '任选七中五',
                    'method': 'LTRX7',
                    'desc': '从01-11中任意选择7个或7个以上号码。',
                    'help': '从01-11共11个号码中选择7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08 09<br>开奖号码：08 04 11 05 03，即中任选七中五。',
                    'type': 'multi',
                    'layout': {
                        '选7中5': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'LTRX8': {
                    'name': '任选八中五',
                    'method': 'LTRX8',
                    'desc': '从01-11中任意选择8个或8个以上号码。',
                    'help': '从01-11共11个号码中选择8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08 09 01<br>开奖号码：08 04 11 05 03，即中任选八中五。',
                    'type': 'multi',
                    'layout': {
                        '选8中5': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '任选单式': {
            'default': {
                'LTRX1_S': {
                    'name': '任选一中一',
                    'method': 'LTRX1_S',
                    'desc': '手动输入号码，从01-11中任意输入1个号码组成一注。',
                    'help': '从01-11中手动输入1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05<br>开奖号码：08 04 11 05 03，即中任选一中一。',
                    'type': 'text'
                },
                'LTRX2_S': {
                    'name': '任选二中二',
                    'method': 'LTRX2_S',
                    'desc': '手动输入号码，从01-11中任意输入2个号码组成一注。',
                    'help': '从01-11中手动输入2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 04<br>开奖号码：08 04 11 05 03，即中任选二中二。',
                    'type': 'text'
                },
                'LTRX3_S': {
                    'name': '任选三中三',
                    'method': 'LTRX3_S',
                    'desc': '手动输入号码，从01-11中任意输入3个号码组成一注。',
                    'help': '从01-11中手动输入3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 04 11<br>开奖号码：08 04 11 05 03，即中任选三中三。',
                    'type': 'text'
                },
                'LTRX4_S': {
                    'name': '任选四中四',
                    'method': 'LTRX4_S',
                    'desc': '手动输入号码，从01-11中任意输入4个号码组成一注。',
                    'help': '从01-11中手动输入4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 04 08 03<br>开奖号码：08 04 11 05 03，即中任选四中四。',
                    'type': 'text'
                },
                'LTRX5_S': {
                    'name': '任选五中五',
                    'method': 'LTRX5_S',
                    'desc': '手动输入号码，从01-11中任意输入5个号码组成一注。',
                    'help': '从01-11中手动输入5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选五中五。',
                    'type': 'text'
                },
                'LTRX6_S': {
                    'name': '任选六中五',
                    'method': 'LTRX6_S',
                    'desc': '手动输入号码，从01-11中任意输入6个号码组成一注。',
                    'help': '从01-11中手动输入6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选六中五。',
                    'type': 'text'
                },
                'LTRX7_S': {
                    'name': '任选七中五',
                    'method': 'LTRX7_S',
                    'desc': '手动输入号码，从01-11中任意输入7个号码组成一注。',
                    'help': '从01-11中手动输入7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08 09<br>开奖号码：08 04 11 05 03，即中任选七中五。',
                    'type': 'text'
                },
                'LTRX8_S': {
                    'name': '任选八中五',
                    'method': 'LTRX8_S',
                    'desc': '手动输入号码，从01-11中任意输入8个号码组成一注。',
                    'help': '从01-11中手动输入8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
                    'example': '投注方案：05 10 04 11 03 08 09 01<br>开奖号码：08 04 11 05 03，即中任选八中五。',
                    'type': 'text'
                }
            }
        },
        '任选胆拖': {
            'default': {
                'LTRXDT2': {
                    'name': '任选二中二',
                    'method': 'LTRXDT2',
                    'desc': '从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。',
                    'help': '从01-11共11个号码中选择2个及以上号码进行投注，每注需至少包括1个胆码及1个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 06<br>开奖号码：06 08 11 09 02，即中任选二中二。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        1,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT3': {
                    'name': '任选三中三',
                    'method': 'LTRXDT3',
                    'desc': '从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。',
                    'help': '从01-11共11个号码中选择3个及以上号码进行投注，每注需至少包括1个胆码及2个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 06 11<br>开奖号码：06 08 11 09 02，即中任选三中三。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        2,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT4': {
                    'name': '任选四中四',
                    'method': 'LTRXDT4',
                    'desc': '从01-11中，选取4个及以上的号码进行投注，每注需至少包括1个胆码及3个拖码。',
                    'help': '从01-11共11个号码中选择4个及以上号码进行投注，每注需至少包括1个胆码及3个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选四中四。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        3,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT5': {
                    'name': '任选五中五',
                    'method': 'LTRXDT5',
                    'desc': '从01-11中，选取5个及以上的号码进行投注，每注需至少包括1个胆码及4个拖码。',
                    'help': '从01-11共11个号码中选择5个及以上号码进行投注，每注需至少包括1个胆码及4个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 02 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选五中五。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        4,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT6': {
                    'name': '任选六中五',
                    'method': 'LTRXDT6',
                    'desc': '从01-11中，选取6个及以上的号码进行投注，每注需至少包括1个胆码及5个拖码。',
                    'help': '从01-11共11个号码中选择6个及以上号码进行投注，每注需至少包括1个胆码及5个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 02 05 06 09 11  <br>开奖号码：06 08 11 09 02，即中任选六中五。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        5,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT7': {
                    'name': '任选七中五',
                    'method': 'LTRXDT7',
                    'desc': '从01-11中，选取7个及以上的号码进行投注，每注需至少包括1个胆码及6个拖码。',
                    'help': '从01-11共11个号码中选择7个及以上号码进行投注，每注需至少包括1个胆码及6个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 01 02 05 06 09 11  <br>开奖号码：06 08 11 09 02，即中任选七中五。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        6,
                        999
                    ],
                    'limitSelectedSomePosition': true
                },
                'LTRXDT8': {
                    'name': '任选八中五',
                    'method': 'LTRXDT8',
                    'desc': '从01-11中，选取8个及以上的号码进行投注，每注需至少包括1个胆码及7个拖码。',
                    'help': '从01-11共11个号码中选择8个及以上号码进行投注，每注需至少包括1个胆码及7个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',
                    'example': '投注方案：胆码 08，托码 01 02 03 05 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选八中五。',
                    'type': 'multi',
                    'layout': {
                        '胆码': lottoCodesTpl,
                        '拖码': lottoCodesTpl
                    },
                    'buttons': digitalPosTpl,
                    'limitSelectedCount': [
                        7,
                        999
                    ],
                    'limitSelectedSomePosition': true
                }
            }
        }
    },
    'p3p5': {
        '三星': {
            '三星直选': {
                'QZX3': {
                    'name': '直选复式',
                    'method': 'ZX3',
                    'desc': '从万位、千位、百位各选一个号码组成一注。',
                    'help': '从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX3_S': {
                    'name': '直选单式',
                    'method': 'ZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：345<br>开奖号码：345，即中前三直选。',
                    'type': 'text',
                    'number': 3,
                    'b64': 3
                },
                'QZXHZ': {
                    'name': '直选和值',
                    'method': 'ZXHZ',
                    'desc': '从0-27中任意选择1个或1个以上号码。',
                    'help': '所选数值等于开奖号码的万位、千位、百位三个数字相加之和，即为中奖。',
                    'example': '投注方案：和值1<br>开奖号码：前三位001，010，100，即中前三直选和值。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZxhzTpl
                    },
                    'buttons': []
                }
            },
            '三星组选': {
                'QZUS': {
                    'name': '组三复式',
                    'method': 'ZUS',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选择2个数字组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：588<br>开奖号码：前三位588（顺序不限），即可中前三组选三。',
                    'type': 'multi',
                    'layout': {
                        '组三': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZUS_S': {
                    'name': '组三单式',
                    'method': 'ZUS_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字中必须有二个数字相同）。',
                    'help': '手动输入一个3位数号码组成一注，三个数字中必须有二个数字相同，输入号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。',
                    'example': '投注方案：001<br>开奖号码：前三位 010（顺序不限），即中前三组选三。',
                    'type': 'text',
                    'number': 3
                },
                'QZUL': {
                    'name': '组六复式',
                    'method': 'ZUL',
                    'desc': '从0-9中任意选择3个或3个以上号码。',
                    'help': '从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。',
                    'example': '投注方案：258<br>开奖号码：前三位 852（顺序不限），即中前三组选六。',
                    'type': 'multi',
                    'layout': {
                        '组六': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZUL_S': {
                    'name': '组六单式',
                    'method': 'ZUL_S',
                    'desc': '手动输入号码，至少输入1个三位数号码（三个数字完全不相同）。',
                    'help': '手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。',
                    'example': '投注方案：123<br>开奖号码：前三位 321（顺序不限），即中前三组选六。',
                    'type': 'text',
                    'number': 3
                },
                'QHHZX': {
                    'name': '混合组选',
                    'method': 'HHZX',
                    'desc': '手动输入号码，至少输入1个三位数号码。',
                    'help': '手动输入一个3位数号码组成一注（不含豹子号），开奖号码的万位、千位、百位符合后三组三或者组六均为中奖。',
                    'example': '投注方案：001 和 123<br>开奖号码：前三位 010（顺序不限）即中前三组选三，或者前三位 312（顺序不限）即中前三组选六。',
                    'type': 'text',
                    'number': 3,
                    'b64': 3
                },
                'QZUHZ': {
                    'name': '组选和值',
                    'method': 'ZUHZ',
                    'desc': '从1-26中选择1个号码。',
                    'help': '所选数值等于开奖号码万位、千位、百位三个数字相加之和(非豹子号)，即为中奖。',
                    'example': '投注方案：和值3<br>开奖号码：前三位 003（顺序不限）即中前三组选三，或者前三位 012（顺序不限）即中前三组选六。',
                    'type': 'multi',
                    'layout': {
                        '和值': digitalZuhzTpl
                    },
                    'buttons': []
                }
            }
        },
        '二星': {
            '二星直选': {
                'QZX2': {
                    'name': '(前二)直选复式',
                    'method': 'ZX2',
                    'desc': '从万位、千位中至少各选1个号码组成一注。',
                    'help': '从万位、千位中选择一个2位数号码组成一注，所选号码与开奖号码的前2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX2_S': {
                    'name': '(前二)直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的万位、千位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 58，即中前二直选。',
                    'type': 'text',
                    'number': 3
                },
                'HZX2': {
                    'name': '(后二)直选复式',
                    'method': 'ZX2',
                    'desc': '从十位、个位中至少各选1个号码组成一注。',
                    'help': '从十位、个位中选择一个2位数号码组成一注，所选号码与开奖号码的后2位相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'multi',
                    'layout': {
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZX2_S': {
                    'name': '(后二)直选单式',
                    'method': 'ZX2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 58，即中后二直选。',
                    'type': 'text',
                    'number': 3
                }
            },
            '二星组选': {
                'QZU2': {
                    'name': '(前二)组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的万位、千位相同，顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZU2_S': {
                    'name': '(前二)组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的万位、千位与开奖号码相同，顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'text',
                    'number': 3
                },
                'HZU2': {
                    'name': '(后二)组选复式',
                    'method': 'ZU2',
                    'desc': '从0-9中任意选择2个或2个以上号码。',
                    'help': '从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同（不含对子号），顺序不限，即中奖。',
                    'example': '投注方案：58<br>开奖号码：后二位 85 或者 58（顺序不限，不含对子号），即中后二组选。',
                    'type': 'multi',
                    'layout': {
                        '组选': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'HZU2_S': {
                    'name': '(后二)组选单式',
                    'method': 'ZU2_S',
                    'desc': '手动输入号码，至少输入1个二位数号码组成一注。',
                    'help': '手动输入一个2位数号码组成一注，输入号码的十位、个位与开奖号码相同（不含对子号），顺序不限，即为中奖。',
                    'example': '投注方案：58<br>开奖号码：前二位 85 或者 58（顺序不限，不含对子号），即中前二组选。',
                    'type': 'text',
                    'number': 3
                }
            }
        },
        '定位胆': {
            'default': {
                'DWD': {
                    'name': '定位胆',
                    'method': 'DWD',
                    'desc': '在万位、千位、百位、十位、个位任意位置上任意选择1个或1个以上号码。',
                    'help': '从万位、千位、百位、十位、个位任意位置上至少选择1个以上号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                    'example': '投注方案：百位 1<br>开奖号码：百位 1，即中定位胆百位。',
                    'type': 'multi',
                    'layout': {
                        '万位': digitalCodesTpl,
                        '千位': digitalCodesTpl,
                        '百位': digitalCodesTpl,
                        '十位': digitalCodesTpl,
                        '个位': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '不定位': {
            '不定位': {
                'QBDW1': {
                    'name': '前三一码',
                    'method': 'BDW1',
                    'desc': '从0-9中任意选择1个以上号码。',
                    'help': '从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的万位、千位、百位中包含所选号码，即为中奖。',
                    'example': '投注方案：1<br>开奖号码：前三位至少出现1个1，即中前三一码不定位。',
                    'type': 'multi',
                    'layout': {
                        '一码': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QBDW2': {
                    'name': '前三二码',
                    'method': 'BDW2',
                    'desc': '从0-9中任意选择2个以上号码。',
                    'help': '从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位中同时包含所选的2个号码，即为中奖。',
                    'example': '投注方案：12<br>开奖号码：至少出现1和2各1个，即中二码不定位。',
                    'type': 'multi',
                    'layout': {
                        '二码': digitalCodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '大小单双': {
            '大小单双': {
                'QDXDS': {
                    'name': '前二大小单双',
                    'method': 'DXDS',
                    'desc': '从万位、千位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对万位和千位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单<br>开奖号码：万位与千位“小双”，即中前二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '百位': digitalDxdsTpl,
                        '十位': digitalDxdsTpl
                    },
                    'buttons': []
                },
                'HDXDS': {
                    'name': '后二大小单双',
                    'method': 'DXDS',
                    'desc': '从十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
                    'help': '对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                    'example': '投注方案：大单<br>开奖号码：十位与个位“小双”，即中后二大小单双。',
                    'type': 'multi',
                    'btnStr': true,
                    'layout': {
                        '十位': digitalDxdsTpl,
                        '个位': digitalDxdsTpl
                    },
                    'buttons': []
                }
            }
        }
    },
    'pk10': {
        '猜冠军': {
            'default': {
                'QZX1': {
                    'name': '直选复式',
                    'method': 'PKZX1',
                    'desc': '从冠军中至少各选择1个号码。',
                    'help': '从冠军投注的1个号码与开奖号码中的第1位数号码相同，视为中奖。',
                    'example': '投注方案：01 <br>开奖号码为：01 * * * * * * * * *，即中前一直选。',
                    'type': 'multi',
                    'layout': {
                        '冠军': pk10CodesTpl
                    },
                    'buttons': digitalPosTpl
                }
            }
        },
        '猜前二': {
            'default': {
                'QZX2': {
                    'name': '直选复式',
                    'method': 'PKZX2',
                    'desc': '从冠军、亚军中至少各选择1个号码。',
                    'help': '从01-10共10个号码中选择2个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即中奖。',
                    'example': '投注方案：01 02<br>开奖号码：01 02 * * * * * * * *，即中前二直选。',
                    'type': 'multi',
                    'layout': {
                        '冠军': pk10CodesTpl,
                        '亚军': pk10CodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX2_S': {
                    'name': '直选单式',
                    'method': 'PKZX2_S',
                    'desc': '手动输入号码，至少输入1个两位数号码组成一注。',
                    'help': '手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02<br>开奖号码：01 02 * * * * * * * *，即中前二直选。',
                    'type': 'text',
                    'number': 3
                }
            }
        },
        '猜前三': {
            'default': {
                'QZX3': {
                    'name': '直选复式',
                    'method': 'PKZX3',
                    'desc': '从冠军、亚军、季军中至少各选择1个号码。',
                    'help': '从01-10共10个号码中选择3个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：01 02 03 * * * * * * *，即中前三直选。',
                    'type': 'multi',
                    'layout': {
                        '冠军': pk10CodesTpl,
                        '亚军': pk10CodesTpl,
                        '季军': pk10CodesTpl
                    },
                    'buttons': digitalPosTpl
                },
                'QZX3_S': {
                    'name': '直选单式',
                    'method': 'PKZX3_S',
                    'desc': '手动输入号码，至少输入1个三位数号码组成一注。',
                    'help': '手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
                    'example': '投注方案：01 02 03<br>开奖号码：01 02 03 * * * * * * *，即中前三直选。',
                    'type': 'text',
                    'number': 3
                }
            }
        },
        '定位胆': {
            'default': {
                'DWD': {
                    'name': '定位胆',
                    'method': 'PKDWD',
                    'desc': '从冠军到第五名任意位置上任意选择1个或1个以上号码。',
                    'help': '从冠军到第五名任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                    'example': '投注方案：第一位 01<br>开奖号码：01 * * * * * * * * *，即中定位胆。',
                    'type': 'multi',
                    'layout': {
                        '冠军': pk10CodesTpl,
                        '亚军': pk10CodesTpl,
                        '季军': pk10CodesTpl,
                        '第四名': pk10CodesTpl,
                        '第五名': pk10CodesTpl,
                    },
                    'buttons': digitalPosTpl
                }
            }
        }
    }
};