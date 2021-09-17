import { Configuration } from "./configuration";
import { Submarine } from "./submarine";

export interface Game {
    id: number;
    configuration: Configuration;
    submarines: Submarine[];
}
