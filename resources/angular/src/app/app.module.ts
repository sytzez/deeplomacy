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
import { MatToolbarModule } from "@angular/material/toolbar";
import { MatDividerModule } from "@angular/material/divider";
import { MatListModule } from "@angular/material/list";
import { GamesCreateComponent } from './pages/games-create/games-create.component';

@NgModule({
    declarations: [
        AppComponent,
        GamesIndexComponent,
        LobbyComponent,
        PlayComponent,
        GamesCreateComponent
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        BrowserAnimationsModule,
        MatCommonModule,
        MatToolbarModule,
        MatTableModule,
        MatButtonModule,
        MatCardModule,
        MatListModule,
        MatDividerModule,
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
