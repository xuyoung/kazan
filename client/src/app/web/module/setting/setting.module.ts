import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '../../shared/shared.module';

import { SettingRoutingModule } from './setting-routing.module';

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

@NgModule({
    imports: [
        CommonModule,
        SharedModule,
        SettingRoutingModule
    ],
    declarations: [
        UserFormComponent,
        UserListComponent,
        RoleListComponent,
        RoleFormComponent,
        ExpressListComponent,
        ExpressFormComponent,
        FormulaListComponent,
        FormulaFormComponent,
        ProductListComponent,
        ProductFormComponent,
        ShellFabricListComponent,
        ShellFabricFormComponent
    ]
})
export class SettingModule { }
