import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import { Observable } from "rxjs";
import { GameState } from "../models/game-state";
import { MoveSubmarineRequest } from "../data/move-submarine-request";

@Injectable({
    providedIn: 'root'
})
export class PlayService {

    constructor(
        protected api: ApiService,
    ) {
    }

    public getGameState(
        gameId: number,
    ): Observable<GameState> {
        return this.api.get<GameState>(`play/${gameId}`);
    }

    public move(
        gameId: number,
        request: MoveSubmarineRequest,
    ): Observable<GameState> {

        const body = {
            x: request.destination.x,
            y: request.destination.y,
        };

        return this.api.post<GameState>(`play/${gameId}/move`, body);
    }
}
