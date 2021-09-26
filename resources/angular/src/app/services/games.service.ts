import { Injectable } from '@angular/core';
import { ApiService } from './api.service';
import { Observable } from 'rxjs';
import { Game } from '../models/game';
import { CreateGameData } from '../data/create-game-data';

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
        id: number,
    ): Observable<Game> {
        return this.api.get<Game>(`games/${id}`);
    }

    public create(
        request: CreateGameData,
    ): Observable<Game> {

        const body = {
            configuration: request.configuration.id,
        };

        return this.api.post<Game>('games', body);
    }

    public join(
        game: Game
    ): Observable<Game> {

        return this.api.get<Game>(`games/${game.id}/join`);
    }

}
