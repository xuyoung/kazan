import { Component, OnInit, HostListener } from '@angular/core';

@Component({
    selector: 'app-default',
    templateUrl: './default.component.html',
    styleUrls: ['./default.component.scss']
})
export class DefaultComponent implements OnInit {

    windowHeight;

    constructor() { }

    ngOnInit() {
        this.windowHeight = document.body.clientHeight - 64;
    }
    @HostListener('window:resize', ['$event'])
    onResize(event) {
        this.windowHeight = document.body.clientHeight - 64;
    }
}
