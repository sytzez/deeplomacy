import { Component, OnInit } from '@angular/core';
import { Game } from "../../models/game";
import { GamesService } from "../../services/games.service";

@Component({
    selector: 'app-games-index',
    templateUrl: './games-index.component.html',
    styleUrls: ['./games-index.component.scss']
})
export class GamesIndexComponent implements OnInit {

    public games: Game[] = [
        {
            id: 1,
            configuration: {
                id: 1,
                name: 'Name',
                description: '...',
                maxNumOfPlayers: 3,
            },
            numOfPlayers: 1,
        },
    ];

    constructor(
        protected gamesService: GamesService,
    ) {
    }

    public ngOnInit(): void {
        this.loadGames();
    }

    public loadGames(): void {

        this.gamesService.getAll()
            .subscribe((games) => {
                console.log(games);
                this.games = games;
            });
    }

}