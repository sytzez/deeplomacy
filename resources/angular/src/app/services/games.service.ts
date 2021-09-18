import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import { Observable } from "rxjs";
import { Game } from "../models/game";
import { CreateGameRequest } from "../data/create-game-request";

@Injectable({
    providedIn: 'root'
})
export class GamesService {

    constructor(
        protected api: ApiService,
    ) {
    }

    public getAll(): Observable<Game[]> {
        return this.api.get<Game[]>('games');
    }

    public getById(
        id: string,
    ): Observable<Game> {
        return this.api.get<Game>(`games/${id}`);
    }

    public create(
        request: CreateGameRequest,
    ): Observable<Game> {

        const body = {
            configuration: request.configuration.id,
        };

        return this.api.post<Game>('games', body);
    }

}
