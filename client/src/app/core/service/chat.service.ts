import { Injectable } from '@angular/core';
// import { Socket } from 'ng-socket-io';


@Injectable({
    providedIn: 'root'
})
export class ChatService {

    constructor(
        // private socket: Socket
    ) { }

    sendMessage(msg: string) {
        // this.socket.emit("message", msg);
    }

    getMessage() {
        // return this.socket
        //     .fromEvent<any>("message")
        //     .map(data => data.msg);
    }

    close() {
        // this.socket.disconnect()
    }
}
