import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '@web-shared/shared.module';
import { VisitRoutingModule } from './visit-routing.module';
import { MineComponent } from './mine/mine.component';
import { AppointmentComponent } from './appointment/appointment.component';
import { ScheduleComponent } from './schedule/schedule.component';

@NgModule({
    imports: [
        CommonModule,
        VisitRoutingModule,
        SharedModule
    ],
    declarations: [MineComponent, AppointmentComponent, ScheduleComponent]
})
export class VisitModule { }
