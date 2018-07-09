import { Component, OnInit } from '@angular/core';
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
        private formBuilder: FormBuilder
    ) { }

    ngOnInit() {
        this.validateForm = this.formBuilder.group({
            aaa: ['', [Validators.required]]
        });
    }

}
