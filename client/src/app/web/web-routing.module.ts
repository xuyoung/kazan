import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

//layout
import { DefaultComponent } from './layout/default/default.component';
import { PassportComponent } from './layout/passport/passport.component';

import { LoginComponent } from './module/login/login.component';
import { DashboardComponent } from './module/dashboard/dashboard.component';



const routes: Routes = [
    { path: '', redirectTo: '/web/login', pathMatch: 'full' },
    {
        path: '',
        component: PassportComponent,
        children: [
            {
                path: 'login',
                component: LoginComponent,
            }
        ]

    },
    {
        path: '',
        component: DefaultComponent,
        children: [
            {
                path: 'dashboard',
                component: DashboardComponent,
            },
            {
                path: 'setting',
                loadChildren: './module/setting/setting.module#SettingModule',
            },
            {
                path: 'custom',
                loadChildren: './module/custom/custom.module#CustomModule',
            }
        ]

    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class WebRoutingModule { }
