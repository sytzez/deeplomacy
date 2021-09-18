import { Component, OnInit } from '@angular/core';
import { ConfigurationsService } from "../../services/configurations.service";
import { Configuration } from "../../models/configuration";
import { GamesService } from "../../services/games.service";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { Router } from "@angular/router";

@Component({
    selector: 'app-create-game-form',
    templateUrl: './create-game-form.component.html',
    styleUrls: ['./create-game-form.component.scss']
})
export class CreateGameFormComponent implements OnInit {

    public configurations?: Configuration[];

    public form = new FormGroup({
        configuration: new FormControl('', Validators.required),
    });

    constructor(
        protected configurationsService: ConfigurationsService,
        protected gamesService: GamesService,
        protected router: Router,
    ) {
    }

    public ngOnInit(): void {
        this.getConfigurations();
    }

    public submit(): void {

        if (this.form.invalid) {
            return;
        }

        this.gamesService
            .create({
                configuration: this.form.get('configuration')?.value as Configuration,
            })
            .subscribe((game) => {
                this.router.navigate(['play', game.id]);
            });
    }

    protected getConfigurations(): void {

        this.configurationsService
            .getAll()
            .subscribe((configurations) => {
                this.configurations = configurations;
            });
    }

}
