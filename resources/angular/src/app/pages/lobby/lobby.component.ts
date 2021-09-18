import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { Observable } from "rxjs";
import { map } from "rxjs/operators";
import { GamesService } from "../../services/games.service";
import { Game } from "../../models/game";

@Component({
    selector: 'app-lobby',
    templateUrl: './lobby.component.html',
    styleUrls: ['./lobby.component.scss']
})
export class LobbyComponent implements OnInit {

    public gameId$: Observable<string|null>;

    public game?: Game;

    constructor(
        protected route: ActivatedRoute,
        protected gamesService: GamesService,
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

            this.loadGame(+id);
        })
    }

    public loadGame(id: number): void {

        this.game = undefined;

        this.gamesService
            .getById(id)
            .subscribe((game) => {
                this.game = game;
            });
    }

}
