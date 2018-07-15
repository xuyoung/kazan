import { Component, OnInit, HostListener } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { NzModalService } from 'ng-zorro-antd';

@Component({
    selector: 'app-default',
    templateUrl: './default.component.html',
    styleUrls: ['./default.component.scss']
})
export class DefaultComponent implements OnInit {

    windowHeight;

    constructor(
        private titleService: Title,
        private modalService: NzModalService) { }

    ngOnInit() {
        this.titleService.setTitle(`业务平台`);
        this.windowHeight = document.body.clientHeight - 64;
    }
    @HostListener('window:resize', ['$event'])
    onResize(event) {
        this.windowHeight = document.body.clientHeight - 64;
    }

    quit() {
        this.modalService.confirm({
            nzTitle: '退出提醒',
            nzContent: '确定退出系统?',
            nzOnOk: () => console.log('OK')
        });
    }
}
