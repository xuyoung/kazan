import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MineComponent } from './mine/mine.component';
import { AppointmentComponent } from './appointment/appointment.component';
import { ScheduleComponent } from './schedule/schedule.component';

const routes: Routes = [{
    path: 'mine',
    component: MineComponent
},
{
    path: 'appointment',
    component: AppointmentComponent
},
{
    path: 'schedule',
    component: ScheduleComponent
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class VisitRoutingModule { }
