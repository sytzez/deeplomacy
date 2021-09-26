import { Submarine } from '../models/submarine';

export interface GiveActionPointsData {
    recipient: Submarine;
    amount: number
}
