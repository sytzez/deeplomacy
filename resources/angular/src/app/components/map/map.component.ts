import { Component, Input, EventEmitter, Output } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Grid } from '../../models/grid';
import { MySubmarine } from '../../models/my-submarine';
import { Cell } from '../../models/cell';
import { MoveSubmarineData } from '../../data/move-submarine-data';
import { Submarine } from '../../models/submarine';
import { ShareSonarData } from '../../data/share-sonar-data';
import { AttackSubmarineData } from '../../data/attack-submarine-data';
import { GiveActionPointsData } from '../../data/give-action-points-data';
import { GiveActionPointsDialogComponent } from '../give-action-points-dialog/give-action-points-dialog.component';

type CellType = 'me' | 'invisible' | 'unreachable' | 'reachable' | 'submarine';

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.scss'],
})
export class MapComponent {

    @Input()
    public grid?: Grid;

    @Input()
    public mySubmarine?: MySubmarine;

    @Output()
    public move = new EventEmitter<MoveSubmarineData>();

    @Output()
    public attack = new EventEmitter<AttackSubmarineData>();

    @Output()
    public giveActionPoints = new EventEmitter<GiveActionPointsData>();

    @Input()
    public isLoading = true;

    @Output()
    public shareSonar = new EventEmitter<ShareSonarData>();

    public submarineForMenu: Submarine | null = null;

    constructor(
        protected dialog: MatDialog,
    ) {
    }

    public getCellType(cell: Cell): CellType {

        if (
            cell.x === this.mySubmarine?.x
            && cell.y === this.mySubmarine?.y
        ) {
            return 'me';
        }

        if (! cell.isVisible) {
            return 'invisible';
        }

        if (cell.submarine) {
            return 'submarine';
        }

        if (cell.canMoveTowards) {
            return 'reachable';
        }

        return 'unreachable';
    }

    public emitMove(destination: Cell): void {

        this.submarineForMenu = null;

        this.move.emit({ destination });
    }

    public emitAttack(target: Submarine, event: Event): void {

        event.stopPropagation();

        this.submarineForMenu = null;

        this.attack.emit({ target });
    }

    public emitGiveActionPoints(recipient: Submarine, event: Event): void {

        event.stopPropagation();

        this.submarineForMenu = null;

        const dialogRef = this.dialog.open(GiveActionPointsDialogComponent, {
            data: {
                max: this.mySubmarine?.actionPoints,
            },
        });

        dialogRef.afterClosed().subscribe((amount: number) => {
            if (! amount || amount < 1) {
                return;
            }

            this.giveActionPoints.emit({ recipient, amount });
        });

    }

    public emitShareSonar(recipient: Submarine, event: Event): void {

        event.stopPropagation();

        this.submarineForMenu = null;

        this.shareSonar.emit({ recipient });
    }

}
