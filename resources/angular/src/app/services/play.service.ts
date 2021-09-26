import { Injectable } from '@angular/core';
import { Observable, Subject, timer } from 'rxjs';
import { ApiService } from './api.service';
import { GameState } from '../models/game-state';
import { MoveSubmarineData } from '../data/move-submarine-data';
import { ShareSonarData } from '../data/share-sonar-data';
import { AttackSubmarineData } from '../data/attack-submarine-data';
import { GiveActionPointsData } from '../data/give-action-points-data';
import { filter, switchMap, takeUntil, tap } from 'rxjs/operators';

@Injectable({
    providedIn: 'root',
})
export class PlayService {

    protected readonly POLL_INTERVAL = 2000;

    constructor(
        protected api: ApiService,
    ) {
    }

    public getGameState(
        gameId: number,
    ): Observable<GameState> {
        return this.api.get<GameState>(`play/${gameId}`);
    }

    public getGameStateIfNeeded(
        gameId: number,
    ): Observable<GameState | false> {
        return this.api.get<GameState | false>(`play/${gameId}/if-needed`);
    }

    public pollGameState(
        gameId: number,
        stopPolling: Observable<void>,
    ): Observable<GameState> {
        return timer(0, this.POLL_INTERVAL)
            .pipe(
                switchMap(
                    (index) => index === 0
                        ? this.getGameState(gameId)
                        : this.getGameStateIfNeeded(gameId)
                ),
                tap(console.log),
                takeUntil(stopPolling),
                filter((gameState) => gameState !== false),
            );
    }

    public move(
        gameId: number,
        data: MoveSubmarineData,
    ): Observable<GameState> {

        const body = {
            x: data.destination.x,
            y: data.destination.y,
        };

        return this.api.post<GameState>(`play/${gameId}/move`, body);
    }

    public attack(
        gameId: number,
        data: AttackSubmarineData,
    ): Observable<GameState> {

        const body = {
            submarine: data.target.id,
        };

        return this.api.post<GameState>(`play/${gameId}/attack`, body);
    }

    public shareSonar(
        gameId: number,
        data: ShareSonarData,
    ): Observable<GameState> {

        const body = {
            submarine: data.recipient.id,
        };

        return this.api.post<GameState>(`play/${gameId}/share-sonar`, body);
    }

    public giveActionPoints(
        gameId: number,
        data: GiveActionPointsData,
    ): Observable<GameState> {

        const body = {
            submarine: data.recipient.id,
            amount: data.amount,
        };

        return this.api.post<GameState>(`play/${gameId}/give-action-points`, body);
    }
}
