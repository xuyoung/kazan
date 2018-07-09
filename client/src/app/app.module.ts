import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
// import { NZ_I18N, zh_CN } from 'ng-zorro-antd';
// import { registerLocaleData } from '@angular/common';
// import zh from '@angular/common/locales/zh';

import { SharedModule } from '@web-shared/shared.module';
//import { WebModule } from './web/web.module';
// import { LayoutModule } from './web/layout/layout.module';
// registerLocaleData(zh);

import { AppRoutingModule } from './app-routing.module';
// import { LoginComponent } from './web/module/login/login.component';
// import { DashboardComponent } from './web/module/dashboard/dashboard.component';


@NgModule({
    declarations: [
        AppComponent,
        // LoginComponent,
        // DashboardComponent
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        FormsModule,
        HttpClientModule,
        SharedModule,
        //WebModule,
        // LayoutModule,
        AppRoutingModule
    ],
    // providers: [{ provide: NZ_I18N, useValue: zh_CN }],
    bootstrap: [AppComponent]
})
export class AppModule { }
