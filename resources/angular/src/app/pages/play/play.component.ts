import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { map, tap } from 'rxjs/operators';
import { MatSnackBar } from '@angular/material/snack-bar';
import { PlayService } from '../../services/play.service';
import { Grid } from '../../models/grid';
import { MySubmarine } from '../../models/my-submarine';
import { MoveSubmarineData } from '../../data/move-submarine-data';
import { GameState } from '../../models/game-state';
import { ShareSonarData } from '../../data/share-sonar-data';
import { AttackSubmarineData } from '../../data/attack-submarine-data';
import { GiveActionPointsData } from '../../data/give-action-points-data';

@Component({
    selector: 'app-play',
    templateUrl: './play.component.html',
    styleUrls: ['./play.component.scss'],
})
export class PlayComponent implements OnInit {

    public gameId$: Observable<string | null>;

    public gameId?: number;

    public grid?: Grid;

    public mySubmarine?: MySubmarine;

    public isLoading = false;

    constructor(
        protected route: ActivatedRoute,
        protected playService: PlayService,
        protected snackbar: MatSnackBar,
    ) {
        this.gameId$ = route.paramMap
            .pipe(
                map((params) => params.get('id')),
                tap((id) => {
                    if (id) {
                        this.gameId = +id;
                    }
                }),
            );
    }

    ngOnInit(): void {

        this.gameId$.subscribe((id) => {
            if (! id) {
                return;
            }

            this.playService
                .getGameState(+id)
                .subscribe(this.loadGameState.bind(this));
        });
    }

    public loadGameState(state: GameState): void {

        this.isLoading = false;
        this.grid = state.grid;
        this.mySubmarine = state.mySubmarine;

        if (state.message) {
            this.snackbar.open(state.message, 'Ok');
        }
    }

    public moveTo(data: MoveSubmarineData): void {

        if (! this.gameId || this.isLoading) {
            return;
        }

        this.isLoading = true;

        this.playService
            .move(this.gameId, data)
            .subscribe(this.loadGameState.bind(this));
    }

    public attack(data: AttackSubmarineData): void {

        if (! this.gameId || this.isLoading) {
            return;
        }

        this.isLoading = true;

        this.playService
            .attack(this.gameId, data)
            .subscribe(this.loadGameState.bind(this));
    }

    public shareSonar(data: ShareSonarData): void {

        if (! this.gameId || this.isLoading) {
            return;
        }

        this.isLoading = true;

        this.playService
            .shareSonar(this.gameId, data)
            .subscribe(this.loadGameState.bind(this));
    }

    public giveActionPoints(data: GiveActionPointsData): void {

        if (! this.gameId || this.isLoading) {
            return;
        }

        this.isLoading = true;

        this.playService
            .giveActionPoints(this.gameId, data)
            .subscribe(this.loadGameState.bind(this));
    }

}
