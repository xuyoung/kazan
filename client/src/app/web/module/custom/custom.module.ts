import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SharedModule } from '@web-shared/shared.module';

import { CustomRoutingModule } from './custom-routing.module';
import { ListComponent } from './list/list.component';
import { FormComponent } from './form/form.component';

@NgModule({
    imports: [
        CommonModule,
        CustomRoutingModule,
        SharedModule
    ],
    declarations: [ListComponent, FormComponent]
})
export class CustomModule { }
