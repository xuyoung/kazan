import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'app-list',
    templateUrl: './list.component.html',
    styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit {

    dataSet = [
        {
            area: ['四川', '陕西'],
            firstKg: 1,
            firstCost: 10,
            continuedKg: 1,
            continuedCost: 8
        },
        {
            area: ['澳门', '香港', '台湾'],
            firstKg: 1,
            firstCost: 27,
            continuedKg: 1,
            continuedCost: 27
        }
    ];

    constructor() { }

    ngOnInit() {
    }

}
