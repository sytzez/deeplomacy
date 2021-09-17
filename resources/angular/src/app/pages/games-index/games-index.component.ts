import { Component, OnInit } from '@angular/core';
import { Game } from "../../models/game";

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
                name: 'Name',
                description: '...',
                maxNumOfPlayers: 3,
            },
            submarines: [],
        },
    ];

    constructor() {
    }

    ngOnInit(): void {
    }

}
