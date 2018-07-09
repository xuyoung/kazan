import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';

import { DefaultComponent } from './default/default.component';
import { PassportComponent } from './passport/passport.component';

@NgModule({
    imports: [SharedModule],
    providers: [],
    declarations: [DefaultComponent, PassportComponent],
    exports: [DefaultComponent, PassportComponent],
})
export class LayoutModule { }
