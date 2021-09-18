import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { Observable } from "rxjs";
import { map } from "rxjs/operators";
import { GamesService } from "../../services/games.service";
import { Game } from "../../models/game";
import { PlayService } from "../../services/play.service";
import { Grid } from "../../models/grid";

@Component({
    selector: 'app-play',
    templateUrl: './play.component.html',
    styleUrls: ['./play.component.scss']
})
export class PlayComponent implements OnInit {

    public gameId$: Observable<string|null>;

    public game?: Game;

    public grid?: Grid;

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
            .getGrid(gameId)
            .subscribe((grid) => {
                this.grid = grid;
            });
    }

}
