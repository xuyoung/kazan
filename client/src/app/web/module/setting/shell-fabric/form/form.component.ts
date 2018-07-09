import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {
    FormBuilder,
    FormControl,
    FormGroup,
    ValidationErrors,
    Validators
} from '@angular/forms';
@Component({
    selector: 'app-form',
    templateUrl: './form.component.html',
    styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit {
    validateForm: FormGroup;
    constructor(
        private route: ActivatedRoute,
        private formBuilder: FormBuilder
    ) {
        this.validateForm = this.formBuilder.group({
            area: ['', [Validators.required]],
            firstKg: ['', [Validators.required]],
            firstCost: ['', [Validators.required]],
            continuedKg: ['', [Validators.required]],
            continuedCost: ['', [Validators.required]]
        });
    }

    controlArray: Array<{ id: number, controlInstance: string }> = [];

    addField(e?: MouseEvent): void {
        if (e) {
            e.preventDefault();
        }
        const id = (this.controlArray.length > 0) ? this.controlArray[this.controlArray.length - 1].id + 1 : 0;

        const control = {
            id,
            controlInstance: `passenger${id}`
        };
        const index = this.controlArray.push(control);
        console.log(this.controlArray[this.controlArray.length - 1]);
        this.validateForm.addControl(this.controlArray[index - 1].controlInstance, new FormControl(null, Validators.required));
    }

    removeField(i: { id: number, controlInstance: string }, e: MouseEvent): void {
        e.preventDefault();
        if (this.controlArray.length > 1) {
            const index = this.controlArray.indexOf(i);
            this.controlArray.splice(index, 1);
            console.log(this.controlArray);
            this.validateForm.removeControl(i.controlInstance);
        }
    }

    ngOnInit() {
        this.addField();
    }

}
