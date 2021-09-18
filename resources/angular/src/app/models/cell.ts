import { Submarine } from "./submarine";

export interface Cell {
    x: number;
    y: number;
    isVisible: boolean;
    canMoveTowards: boolean;
    submarine: Submarine|null;
    canAttack: boolean;
    canShareSonar: boolean;
    canGiveActionPoints: boolean;
}
