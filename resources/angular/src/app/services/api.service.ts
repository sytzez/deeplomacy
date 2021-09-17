import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";

export type RequestMethod = 'get' | 'post' | 'patch' | 'delete';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    constructor(
        protected http: HttpClient,
    ) {
    }

    public get<R extends object>(route: string): Observable<R> {
        return this.request<R>('get', route);
    }

    public post<R extends object>(route: string, body: any): Observable<R> {
        return this.request<R>('post', route, { body });
    }

    protected request<R extends object>(method: RequestMethod, route: string, options = {}): Observable<R> {
        return this.http.request<R>(method, route, options);
    }

}
