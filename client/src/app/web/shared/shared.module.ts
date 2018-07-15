import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { NgZorroAntdModule, NZ_I18N, zh_CN } from 'ng-zorro-antd';
import { NgxEchartsModule } from 'ngx-echarts';
import { FroalaEditorModule, FroalaViewModule } from 'angular-froala-wysiwyg';

import { HttpClientModule } from '@angular/common/http';

import { registerLocaleData } from '@angular/common';
import zh from '@angular/common/locales/zh';
registerLocaleData(zh);

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        RouterModule,
        ReactiveFormsModule,
        NgZorroAntdModule,
        NgxEchartsModule,
        HttpClientModule,
        FroalaEditorModule.forRoot(),
        FroalaViewModule.forRoot()
    ],
    exports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        RouterModule,
        NgZorroAntdModule,
        NgxEchartsModule,
        HttpClientModule,
        FroalaEditorModule,
        FroalaViewModule
    ],
    providers: [{ provide: NZ_I18N, useValue: zh_CN }],
    declarations: []
})
export class SharedModule { }
