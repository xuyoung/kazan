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
import { ListComponent as ShellFabricListComponent } from './shell-fabric/list/list.component';
import { FormComponent as ShellFabricFormComponent } from './shell-fabric/form/form.component';
import { PropertyComponent } from './product/property/property.component';
import { CategoryComponent } from './product/category/category.component';

import { ListComponent as CraftListComponent } from './craft/list/list.component';
import { FormComponent as CraftFormComponent } from './craft/form/form.component';

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
        ShellFabricListComponent,
        ShellFabricFormComponent,
        PropertyComponent,
        CategoryComponent,
        CraftListComponent,
        CraftFormComponent
    ]
})
export class SettingModule { }
