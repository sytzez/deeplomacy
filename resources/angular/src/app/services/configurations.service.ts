import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { Configuration } from '../models/configuration';

@Injectable({
    providedIn: 'root',
})
export class ConfigurationsService {

    constructor(
        protected api: ApiService,
    ) {
    }

    public getAll(): Observable<Configuration[]> {
        return this.api.get<Configuration[]>('configurations');
    }

    public getById(
        id: number,
    ): Observable<Configuration> {
        return this.api.get<Configuration>(`configurations/${id}`);
    }

}
