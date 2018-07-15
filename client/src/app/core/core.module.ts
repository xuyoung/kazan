import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { DefaultInterceptor } from '@core/default.interceptor';
// import { SocketIoModule, SocketIoConfig } from 'ng-socket-io';
// const config: SocketIoConfig = { url: 'http://localhost:5000', options: {} };
@NgModule({
    imports: [
        CommonModule,
        // SocketIoModule.forRoot(config)
    ],
    declarations: [],
    providers: [
        { provide: HTTP_INTERCEPTORS, useClass: DefaultInterceptor, multi: true },
    ],
})
export class CoreModule { }
