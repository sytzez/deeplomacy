import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { Observable } from "rxjs";
import { map } from "rxjs/operators";
import { GamesService } from "../../services/games.service";
import { Game } from "../../models/game";
import { PlayService } from "../../services/play.service";
import { Grid } from "../../models/grid";
import { MySubmarine } from "../../models/my-submarine";

@Component({
    selector: 'app-play',
    templateUrl: './play.component.html',
    styleUrls: ['./play.component.scss']
})
export class PlayComponent implements OnInit {

    public gameId$: Observable<string|null>;

    public game?: Game;

    public grid?: Grid;

    public mySubmarine?: MySubmarine;

    constructor(
        protected route: ActivatedRoute,
        protected gamesService: GamesService,
        protected playService: PlayService,
    ) {
        this.gameId$ = route.paramMap
            .pipe(
                map((params) => params.get('id'))
            );
    }

    ngOnInit(): void {

        this.gameId$.subscribe((id) => {
            if (! id) {
                return;
            }

            this.loadGrid(+id);
        })
    }

    public loadGrid(gameId: number): void {

        this.playService
            .getGameState(gameId)
            .subscribe((state) => {
                this.grid = state.grid;
                this.mySubmarine = state.mySubmarine;
            });
    }

}
