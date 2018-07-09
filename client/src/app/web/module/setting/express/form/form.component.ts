import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {
    FormBuilder,
    FormControl,
    FormGroup,
    ValidationErrors,
    Validators
} from '@angular/forms';
import { Observable, Observer } from 'rxjs';
import { NzMessageService } from 'ng-zorro-antd';

const province = [
    "河北省",
    "山西省",
    "辽宁省",
    "吉林省",
    "黑龙江省",
    "江苏省",
    "浙江省",
    "安徽省",
    "福建省",
    "江西省",
    "山东省",
    "河南省",
    "湖北省",
    "湖南省",
    "广东省",
    "海南省",
    "四川省",
    "贵州省",
    "云南省",
    "陕西省",
    "甘肃省",
    "青海省",
    "台湾省",
    "北京市",
    "天津市",
    "上海市",
    "重庆市",
    "内蒙古自治区",
    "广西壮族自治区",
    "宁夏回族自治区",
    "新疆维吾尔自治区",
    "西藏自治区",
    "香港特别行政区",
    "澳门特别行政区"
];


@Component({
    selector: 'app-form',
    templateUrl: './form.component.html'
})
export class FormComponent implements OnInit {

    provinceInfo = province;


    id;
    isLoading = false;
    validateForm: FormGroup;
    submitForm = ($event, value) => {
        $event.preventDefault();
        for (const key in this.validateForm.controls) {
            this.validateForm.controls[key].markAsDirty();
            this.validateForm.controls[key].updateValueAndValidity();
        }

        if (this.validateForm.valid) {
            this.isLoading = true;
            setTimeout(_ => {
                this.isLoading = false;
                this.message.create('success', `保存成功`);
            }, 2000);
        }
        console.log(value);
    };

    resetForm(e: MouseEvent): void {
        e.preventDefault();
        this.validateForm.reset();
        for (const key in this.validateForm.controls) {
            this.validateForm.controls[key].markAsPristine();
            this.validateForm.controls[key].updateValueAndValidity();
        }
    }


    constructor(
        private route: ActivatedRoute,
        private formBuilder: FormBuilder,
        private message: NzMessageService
    ) {
        this.validateForm = this.formBuilder.group({
            area: ['', [Validators.required]],
            firstKg: ['', [Validators.required]],
            firstCost: ['', [Validators.required]],
            continuedKg: ['', [Validators.required]],
            continuedCost: ['', [Validators.required]]
        });
    }

    ngOnInit() {
        this.id = this.route.snapshot.paramMap.get('id');

    }

}
