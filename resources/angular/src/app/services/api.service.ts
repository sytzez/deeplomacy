import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Response } from "../data/response";
import { map } from "rxjs/operators";
import { environment } from "../../environments/environment";

export type RequestMethod = 'get' | 'post' | 'patch' | 'delete';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    constructor(
        protected http: HttpClient,
    ) {
    }

    public get<R>(
        route: string,
    ): Observable<R> {
        return this.request<R>('get', route);
    }

    public post<R>(
        route: string, body: any,
    ): Observable<R> {
        return this.request<R>('post', route, { body });
    }

    protected request<R>(
        method: RequestMethod, route: string, options = {},
    ): Observable<R> {

        const url = `${environment.apiBase}${route}`;

        return this.http.request<Response<R>>(method, url, options)
            .pipe(
                map((response) => response.data),
            );
    }

}
