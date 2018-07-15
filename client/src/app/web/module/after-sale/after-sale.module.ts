import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SharedModule } from '@web-shared/shared.module';
import { AfterSaleRoutingModule } from './after-sale-routing.module';
import { ListComponent } from './list/list.component';
import { FormComponent } from './form/form.component';

@NgModule({
    imports: [
        CommonModule,
        AfterSaleRoutingModule,
        SharedModule
    ],
    declarations: [ListComponent, FormComponent]
})
export class AfterSaleModule { }
