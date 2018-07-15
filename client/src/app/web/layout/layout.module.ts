import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';

import { DefaultComponent } from './default/default.component';
import { PassportComponent } from './passport/passport.component';
import { LockComponent } from './default/components/lock/lock.component';

@NgModule({
    imports: [SharedModule],
    providers: [],
    declarations: [DefaultComponent, PassportComponent, LockComponent],
    exports: [DefaultComponent, PassportComponent],
})
export class LayoutModule { }
