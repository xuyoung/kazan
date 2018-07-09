import { NgModule } from '@angular/core';
import { SharedModule } from '@web-shared/shared.module';
import { WebRoutingModule } from './web-routing.module';
import { LoginComponent } from './module/login/login.component';
import { LayoutModule } from './layout/layout.module';
import { DashboardComponent } from './module/dashboard/dashboard.component';

@NgModule({
    imports: [
        SharedModule,
        WebRoutingModule,
        LayoutModule
    ],
    declarations: [LoginComponent, DashboardComponent]
})
export class WebModule { }
