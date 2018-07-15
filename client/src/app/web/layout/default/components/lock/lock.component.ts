import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'header-lock',
    templateUrl: './lock.component.html',
    styleUrls: ['./lock.component.scss']
})
export class LockComponent implements OnInit {

    isVisible = false;

    constructor() { }

    ngOnInit() {
    }
    showModal(): void {
        this.isVisible = true;
    }

    handleOk(): void {
        console.log('Button ok clicked!');
        this.isVisible = false;
    }

    handleCancel(): void {
        console.log('Button cancel clicked!');
        this.isVisible = false;
    }

}
