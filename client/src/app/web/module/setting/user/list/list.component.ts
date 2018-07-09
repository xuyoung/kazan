import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'app-list',
    templateUrl: './list.component.html',
    styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit {

    dataSet = [
        {
            key: '1',
            name: 'allen',
            age: '艾伦',
            address: '车间主管'
        },
        {
            key: '2',
            name: 'tony',
            age: '刘德华',
            address: '员工'
        },
        {
            key: '3',
            name: 'jack',
            age: '成龙',
            address: '仓库管理员'
        }
    ];

    constructor() { }

    ngOnInit() {
    }

}
