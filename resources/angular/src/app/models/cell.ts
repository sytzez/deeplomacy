import { Submarine } from './submarine';

export interface Cell {
    x: number;
    y: number;
    isVisible: boolean;
    canMoveTowards: boolean;
    actionPointsToMove?: number;
    submarine: Submarine|null;
    canAttack: boolean;
    actionPointsToAttack?: number;
    canShareSonar: boolean;
    actionPointsToShareSonar?: number;
    canGiveActionPoints: boolean;
}
