import { Component, OnInit } from '@angular/core';
import { Game } from '../../models/game';
import { GamesService } from '../../services/games.service';
import { Router } from '@angular/router';

@Component({
    selector: 'app-games-index',
    templateUrl: './games-index.component.html',
    styleUrls: ['./games-index.component.scss']
})
export class GamesIndexComponent implements OnInit {

    public games: Game[]|null = null;

    public isLoadingGames = false;

    constructor(
        protected gamesService: GamesService,
        protected router: Router,
    ) {
    }

    public ngOnInit(): void {

        this.loadGames();
    }

    public loadGames(): void {

        if (this.isLoadingGames) {
            return;
        }

        this.isLoadingGames = true;

        this.gamesService
            .getAll()
            .subscribe(
                (games) => {
                    this.games = games;
                },
                () => {},
                () => {
                    this.isLoadingGames = false;
                }
            );
    }

    public join(game: Game) {

        this.gamesService
            .join(game)
            .subscribe((joinedGame) => {
                this.play(joinedGame);
            });
    }

    public play(game: Game) {

        this.router.navigate(['play', game.id]);
    }

}
