import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { Observable } from "rxjs";
import { map, tap } from "rxjs/operators";
import { GamesService } from "../../services/games.service";
import { PlayService } from "../../services/play.service";
import { Grid } from "../../models/grid";
import { MySubmarine } from "../../models/my-submarine";
import { MoveSubmarineRequest } from "../../data/move-submarine-request";
import { GameState } from "../../models/game-state";

@Component({
    selector: 'app-play',
    templateUrl: './play.component.html',
    styleUrls: ['./play.component.scss']
})
export class PlayComponent implements OnInit {

    public gameId$: Observable<string|null>;

    public gameId?: number;

    public grid?: Grid;

    public mySubmarine?: MySubmarine;

    public loading = false;

    constructor(
        protected route: ActivatedRoute,
        protected gamesService: GamesService,
        protected playService: PlayService,
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
        })
    }

    public loadGameState(state: GameState): void {

        this.grid = state.grid;
        this.mySubmarine = state.mySubmarine;
    }

    public moveTo(request: MoveSubmarineRequest): void {

        if (! this.gameId || this.loading) {
            return;
        }

        this.loading = true;

        this.playService
            .move(this.gameId, request)
            .pipe(tap(() => {
                this.loading = false;
            }))
            .subscribe(this.loadGameState.bind(this));
    }

}
