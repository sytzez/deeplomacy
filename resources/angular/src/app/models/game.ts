import { Configuration } from './configuration';

export interface Game {
    id: number;
    configuration: Configuration;
    numOfPlayers: number;
    isJoined: boolean;
}
