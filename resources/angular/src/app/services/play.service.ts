import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import { Observable } from "rxjs";
import { GameState } from "../models/game-state";
import { MoveSubmarineData } from "../data/move-submarine-data";
import { ShareSonarData } from "../data/share-sonar-data";
import { AttackSubmarineData } from "../data/attack-submarine-data";

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
        request: MoveSubmarineData,
    ): Observable<GameState> {

        const body = {
            x: request.destination.x,
            y: request.destination.y,
        };

        return this.api.post<GameState>(`play/${gameId}/move`, body);
    }

    public attack(
        gameId: number,
        request: AttackSubmarineData,
    ): Observable<GameState> {

        const body = {
            submarine: request.target.id,
        };

        return this.api.post<GameState>(`play/${gameId}/attack`, body);
    }

    public shareSonar(
        gameId: number,
        request: ShareSonarData,
    ): Observable<GameState> {

        const body = {
            submarine: request.target.id,
        };

        return this.api.post<GameState>(`play/${gameId}/share-sonar`, body);
    }
}
