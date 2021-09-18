import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import { Observable } from "rxjs";
import { Grid } from "../models/grid";

@Injectable({
    providedIn: 'root'
})
export class PlayService {

    constructor(
        protected api: ApiService,
    ) {
    }

    public getGrid(
        gameId: number,
    ): Observable<Grid> {
        return this.api.get<Grid>(`play/${gameId}`);
    }
}
