import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import { Observable } from "rxjs";
import { GameState } from "../models/game-state";

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
}
