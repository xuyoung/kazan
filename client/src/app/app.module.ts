import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { SharedModule } from '@web-shared/shared.module';
import { AppRoutingModule } from './app-routing.module';
import { CoreModule } from '@core/core.module';


@NgModule({
    declarations: [
        AppComponent,
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        SharedModule,
        AppRoutingModule,
        CoreModule
    ],
    bootstrap: [AppComponent]
})
export class AppModule { }
