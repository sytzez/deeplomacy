import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { Response } from "../data/response";
import { concatAll, map, tap } from "rxjs/operators";
import { environment } from "../../environments/environment";
import { flatMap } from "rxjs/internal/operators";

export type RequestMethod = 'get' | 'post' | 'patch' | 'delete';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    protected authToken: string|null = null;

    constructor(
        protected http: HttpClient,
    ) {
        this.authToken = localStorage.getItem('token');
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
        method: RequestMethod, route: string, customOptions = {},
    ): Observable<R> {

        const url = `${environment.apiBase}${route}`;

        return this.getAuthHeaders()
            .pipe(
                flatMap((headers) => {
                    const options = {
                        headers,
                        ...customOptions,
                    };

                    return this.http.request<Response<R>>(method, url, options);
                }),
                map((response) => response.data),
            );
    }

    protected getAuthHeaders(): Observable<HttpHeaders>
    {
        if (this.authToken) {
            return of(
                new HttpHeaders({
                    'Authentication': this.authToken
                })
            );
        }

        const url = `${environment.apiBase}token`;

        return this.http
            .get(url)
            .pipe(
                tap((response) => {
                    console.log(response);
                    this.authToken = response as string;
                    localStorage.setItem('token', response as string);
                }),
                map((response) => new HttpHeaders({
                    'Authentication': response as string,
                }))
            );
    }

}
