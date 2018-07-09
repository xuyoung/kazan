import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ListComponent as UserListComponent } from './user/list/list.component';
import { FormComponent as UserFormComponent } from './user/form/form.component';

import { ListComponent as RoleListComponent } from './role/list/list.component';
import { FormComponent as RoleFormComponent } from './role/form/form.component';

import { ListComponent as ExpressListComponent } from './express/list/list.component';
import { FormComponent as ExpressFormComponent } from './express/form/form.component';
import { ListComponent as FormulaListComponent } from './formula/list/list.component';
import { FormComponent as FormulaFormComponent } from './formula/form/form.component';
import { ListComponent as ProductListComponent } from './product/list/list.component';
import { FormComponent as ProductFormComponent } from './product/form/form.component';
import { ListComponent as ShellFabricListComponent } from './shell-fabric/list/list.component';
import { FormComponent as ShellFabricFormComponent } from './shell-fabric/form/form.component';




const routes: Routes = [{
    path: 'user',
    children: [{
        path: '',
        component: UserListComponent
    },
    {
        path: 'new',
        component: UserFormComponent
    },
    {
        path: 'edit/:id',
        component: UserFormComponent
    }]
},
{
    path: 'role',
    children: [{
        path: '',
        component: RoleListComponent
    },
    {
        path: 'new',
        component: RoleFormComponent
    },
    {
        path: 'edit/:id',
        component: RoleFormComponent
    }]
},
{
    path: 'express',
    children: [{
        path: '',
        component: ExpressListComponent
    },
    {
        path: 'new',
        component: ExpressFormComponent
    },
    {
        path: 'edit/:id',
        component: ExpressFormComponent
    }]
},
{
    path: 'formula',
    children: [{
        path: '',
        component: FormulaListComponent
    },
    {
        path: 'new',
        component: FormulaFormComponent
    },
    {
        path: 'edit/:id',
        component: FormulaFormComponent
    }]
},
{
    path: 'product',
    children: [{
        path: '',
        component: ProductListComponent
    },
    {
        path: 'new',
        component: ProductFormComponent
    },
    {
        path: 'edit/:id',
        component: ProductFormComponent
    }]
},
{
    path: 'shell-fabric',
    children: [{
        path: '',
        component: ShellFabricListComponent
    },
    {
        path: 'new',
        component: ShellFabricFormComponent
    },
    {
        path: 'edit/:id',
        component: ShellFabricFormComponent
    }]
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class SettingRoutingModule { }
