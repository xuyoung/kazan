import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
    {
        path: 'web',
        loadChildren: './web/web.module#WebModule'
    },
    { path: 'mobile', loadChildren: './mobile/mobile.module#MobileModule' },
    { path: '', redirectTo: '/web/login', pathMatch: 'full' },
    // { path: '**', PageNotFoundComponent}
];

@NgModule({
    imports: [RouterModule.forRoot(routes, {
        useHash: false,
        enableTracing: true
    })],
    exports: [RouterModule]
})
export class AppRoutingModule { }
