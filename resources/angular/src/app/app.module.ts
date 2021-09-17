import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { GamesIndexComponent } from './pages/games-index/games-index.component';
import { LobbyComponent } from './pages/lobby/lobby.component';
import { PlayComponent } from './pages/play/play.component';
import { MatTableModule } from "@angular/material/table";
import { MatButtonModule } from "@angular/material/button";
import { MatCardModule } from "@angular/material/card";
import { MatCommonModule } from "@angular/material/core";

@NgModule({
    declarations: [
        AppComponent,
        GamesIndexComponent,
        LobbyComponent,
        PlayComponent
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        BrowserAnimationsModule,
        MatCommonModule,
        MatTableModule,
        MatButtonModule,
        MatCardModule,
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
