import { Component, OnInit } from '@angular/core';
import { Game } from "../../models/game";
import { GamesService } from "../../services/games.service";
import { Router } from "@angular/router";

@Component({
    selector: 'app-games-index',
    templateUrl: './games-index.component.html',
    styleUrls: ['./games-index.component.scss']
})
export class GamesIndexComponent implements OnInit {

    public games: Game[] = [];

    constructor(
        protected gamesService: GamesService,
        protected router: Router,
    ) {
    }

    public ngOnInit(): void {

        this.loadGames();
    }

    public loadGames(): void {

        this.gamesService
            .getAll()
            .subscribe((games) => {
                console.log(games);
                this.games = games;
            });
    }

    public join(game: Game) {

        this.gamesService
            .join(game)
            .subscribe((joinedGame) => {
                this.router.navigate(['play', joinedGame.id]);
            });
    }

}
