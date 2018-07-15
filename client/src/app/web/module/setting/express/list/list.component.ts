import { Component, OnInit } from '@angular/core';

import { AREA } from '@mock/area';
import { EXPRESS } from '@mock/express';

@Component({
    selector: 'app-list',
    templateUrl: './list.component.html'
})
export class ListComponent implements OnInit {

    expressInfo = [];

    constructor() { }

    ngOnInit() {
        for (let index in EXPRESS) {

            console.log(EXPRESS[index])
        }
    }

}
