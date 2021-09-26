import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { GamesIndexComponent } from './pages/games-index/games-index.component';
import { PlayComponent } from './pages/play/play.component';

const routes: Routes = [
    {path: '', component: GamesIndexComponent},
    {path: 'play/:id', component: PlayComponent},
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
})
export class AppRoutingModule {
}
