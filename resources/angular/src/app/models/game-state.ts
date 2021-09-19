import { Grid } from "./grid";
import { MySubmarine } from "./my-submarine";

export interface GameState {
    grid: Grid,
    mySubmarine: MySubmarine,
}
