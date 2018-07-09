import { Component, OnInit, ViewEncapsulation, DoCheck } from '@angular/core';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';

const info = [{
    key: "DATA_1",
    title: "长",
    type: "input",
    default: 210
}, {
    key: "DATA_2",
    title: "宽",
    type: "input",
    default: 75
}, {
    key: "DATA_3",
    title: "高",
    type: "input",
    default: 5
}, {
    key: "DATA_4",
    title: "面料幅数",
    formula: "ROUNDUP((#DATA_2#+2)*2/140,0)"
}, {
    key: "DATA_5",
    title: "面料米数",
    formula: "#DATA_4#*(#DATA_1#+2)/100"
}, {
    key: "DATA_6",
    title: "面料单价（每米）",
    type: "input",
    default: 48
}, {
    key: "DATA_7",
    title: "面料价格",
    formula: "#DATA_5#*#DATA_6#"
}, {
    key: "DATA_8",
    title: "是否加内套",
    type: "input",
    default: 1
}, {
    key: "DATA_9",
    title: "内套价格",
    formula: "#DATA_5#*10*#DATA_8#"
}, {
    key: "DATA_10",
    title: "是否带海绵",
    type: "input",
    default: 1
}, {
    key: "DATA_11",
    title: "海绵单价",
    formula: "IF(#DATA_3#=3,46,IF(#DATA_3#=5,72,IF(#DATA_3#=8,116,IF(#DATA_3#=10,136,IF(#DATA_3#=12,156,IF(#DATA_3#=15,196,IF(#DATA_3#=18,236,IF(#DATA_3#=20,280))))))))"
}, {
    key: "DATA_12",
    title: "海绵价格",
    formula: "IF(OR(#DATA_1#<160,#DATA_1#>200),#DATA_1#,200)*IF(OR(#DATA_2#<160,#DATA_2#>200),#DATA_2#,200)*#DATA_11#*#DATA_10#/10000"
}, {
    key: "DATA_13",
    title: "是否加夹棉",
    type: "input",
    default: 1
}, {
    key: "DATA_14",
    title: "夹棉价格",
    formula: "IF(OR(#DATA_1#<160,#DATA_1#>200),#DATA_1#,200)*IF(OR(#DATA_2#<160,#DATA_2#>200),#DATA_2#,200)*25*#DATA_13#/10000"
}, {
    key: "DATA_15",
    title: "滚边（单滚1,双滚2）",
    type: "input",
    default: 1
}, {
    key: "DATA_16",
    title: "滚边价格",
    formula: "(#DATA_1#+#DATA_2#)*2*0.05*#DATA_15#"
}, {
    key: "DATA_17",
    title: "荷叶边15cm",
    type: "input",
    default: 1
}, {
    key: "DATA_18",
    title: "荷叶边价格",
    formula: "#DATA_1#/100*3*#DATA_6#/7*#DATA_17#"
}, {
    key: "DATA_19",
    title: "缺口数",
    type: "input",
    default: 0
}, {
    key: "DATA_20",
    title: "异形价格",
    formula: "IF(#DATA_19#>2,#DATA_19#*10-20,0)"
}, {
    key: "DATA_21",
    title: "工费",
    type: "input",
    default: 20
}, {
    key: "DATA_22",
    title: "总价",
    formula: "#DATA_7#+#DATA_9#+#DATA_12#+#DATA_14#+#DATA_16#+#DATA_18#+#DATA_20#+#DATA_21#"
}, {
    key: "DATA_23",
    title: "重量",
    formula: "#DATA_1#*#DATA_2#/10000*0.33*#DATA_3#*#DATA_10#+#DATA_5#*0.34+#DATA_1#*#DATA_2#/10000*0.38*#DATA_13#"
}];
@Component({
    selector: 'app-form',
    templateUrl: './form.component.html',
    encapsulation: ViewEncapsulation.None,
    styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit, DoCheck {

    inputValue: string = 'Switch tab view preview @NG-ZORRO ';
    preview: SafeHtml;
    suggestions = ['NG-ZORRO', 'angular', 'Reactive-Extensions'];
    length = 210;
    width = 75;
    height = 5;
    pageCount;
    meter;
    unitPrice = 48;
    price;
    formulaInfo = info;
    myInfo = {};
    constructor(private sanitizer: DomSanitizer) {
        this.renderPreView();
    }

    isLoading = false;

    save(): void {
        this.isLoading = true;
        setTimeout(_ => {
            this.isLoading = false;
        }, 5000);
    }

    getRegExp(prefix: string | string[]): RegExp {
        const prefixArray = Array.isArray(prefix) ? prefix : [prefix];
        let prefixToken = prefixArray.join('').replace(/(\$|\^)/g, '\\$1');

        if (prefixArray.length > 1) {
            prefixToken = `[${prefixToken}]`;
        }

        return new RegExp(`(\\s|^)(${prefixToken})[^\\s]*`, 'g');
    }


    renderPreView(): void {
        if (this.inputValue) {
            const regex = this.getRegExp('@');
            const previewValue = this.inputValue
                .replace(regex, match => `<a target="_blank" href="https://github.com/${match.trim().substring(1)}">${match}</a>`);
            this.preview = this.sanitizer.bypassSecurityTrustHtml(previewValue);
        }
    }

    formatIfStr(a) {
        let index = a.lastIndexOf('IF('),
            aaaa;
        if (index != -1) {
            let b = a.indexOf(')', index);
            let c = a.substr(index, b - index);
            let d = c.replace("IF", '');
            let e = d.replace("=", '==');
            let f = e.split(',');

            let aa;
            if (f.length == 2) {
                aa = f[0] + "?" + f[1] + ":0";
            } else {
                aa = f[0] + "?" + f[1] + ":" + f[2];
            }
            aaaa = a.replace(c, aa);

            return this.formatIfStr(aaaa);
        } else {
            return a;
        }

    }

    ngOnInit() {
        for (let info of this.formulaInfo) {
            if (info.type && info.type == 'input' && 'default' in info) {
                this.myInfo[info.key] = info.default;
            }
        }


    }

    ngDoCheck() {

        let orInfoArray = [];

        for (let info of this.formulaInfo) {
            if (info.formula) {
                let formulaStr = info.formula,
                    formatStr,
                    resultStr;

                //处理ROUNDUP
                let roundupIndex = formulaStr.indexOf('ROUNDUP');
                if (roundupIndex != -1) {
                    let index = formulaStr.lastIndexOf(",");
                    let newStr1 = formulaStr.substr(0, index);
                    formulaStr = newStr1.replace('ROUNDUP', 'Math.ceil') + ')';
                }

                //获取OR  因为OR中的括号会影响后面的IF中的变换，所以先替换掉，最后再替换回来
                if (formulaStr.indexOf('OR') != -1) {
                    formulaStr = formulaStr.replace(/OR\((.*?)\)/g, function (word) {
                        word = word.replace(',', '||');
                        word = word.replace('OR', '');
                        word = word.replace('=', '==');

                        orInfoArray.push(word);

                        return "@" + (orInfoArray.length - 1) + "@";
                    });

                }

                //处理IF
                if (formulaStr.indexOf('IF') != -1) {
                    formulaStr = this.formatIfStr(formulaStr);
                }

                //处理前面替换掉的OR中的内容
                formulaStr = formulaStr.replace(/@(.*?)@/g, function (word) {
                    let index = word.replace(/@/g, '');
                    return orInfoArray[index];
                });


                if (formulaStr) {
                    resultStr = formulaStr.replace(/#(.*?)#/g, function (word) {
                        return "this.myInfo['" + word.replace(/#/g, '') + "']";
                    });
                }

                if (resultStr) {
                    this.myInfo[info.key] = eval(resultStr);
                }
            }
        }
    }
}
