import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { Response } from '../data/response';
import { catchError, map, tap } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { flatMap } from 'rxjs/internal/operators';
import { MatSnackBar } from '@angular/material/snack-bar';

export type RequestMethod = 'get' | 'post' | 'patch' | 'delete';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    protected authToken: string|null = null;

    constructor(
        protected http: HttpClient,
        protected snackbar: MatSnackBar,
    ) {
        this.authToken = localStorage.getItem('token');
    }

    public get<R>(
        route: string,
    ): Observable<R> {
        return this.request<R>('get', route);
    }

    public post<R>(
        route: string, body: Record<string, unknown>,
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
                        withCredentials: true,
                        ...customOptions,
                    };

                    return this.http.request<Response<R>>(method, url, options);
                }),
                catchError((error) => this.handleErrorResponse(error)),
                map((response) => response.data),
            );
    }

    protected getAuthHeaders(): Observable<HttpHeaders> {

        if (this.authToken) {
            return of(
                new HttpHeaders({
                    'Authorization': 'Bearer ' + this.authToken,
                })
            );
        }

        const url = `${environment.apiBase}token`;

        return this.http
            .get<{data: string}>(url)
            .pipe(
                tap((response) => {
                    this.authToken = response.data;
                    localStorage.setItem('token', response.data);
                }),
                map((response) => new HttpHeaders({
                    'Authorization': 'Bearer ' + response.data,
                }))
            );
    }

    protected handleErrorResponse(error: HttpErrorResponse): Observable<never> {

        if (error.status === 401) {
            this.authToken = null;
            localStorage.removeItem('token');
        }

        if (error.error.message) {
            this.snackbar.open(error.error.message, 'Ok');
        } else {
            this.snackbar.open('A server error has occurred', 'Ok');
        }

        return throwError(error);
    }

}
