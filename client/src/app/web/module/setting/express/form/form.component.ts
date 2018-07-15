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

import { AREA } from '@mock/area';

@Component({
    selector: 'app-form',
    templateUrl: './form.component.html'
})
export class FormComponent implements OnInit {

    provinceInfo = AREA;


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
