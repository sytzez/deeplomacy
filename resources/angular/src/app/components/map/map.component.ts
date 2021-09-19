import { Component, Input, EventEmitter, Output } from '@angular/core';
import { Grid } from "../../models/grid";
import { MySubmarine } from "../../models/my-submarine";
import { Cell } from "../../models/cell";
import { MoveSubmarineData } from "../../data/move-submarine-data";
import { Submarine } from "../../models/submarine";
import { ShareSonarData } from "../../data/share-sonar-data";
import { AttackSubmarineData } from "../../data/attack-submarine-data";

type CellType = 'me' | 'invisible' | 'unreachable' | 'reachable' | 'submarine';

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.scss']
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
    public shareSonar = new EventEmitter<ShareSonarData>();

    public submarineForMenu: Submarine|null = null;

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
        this.move.emit({ destination });
    }

    public emitAttack(target: Submarine): void {
        this.attack.emit({ target });
    }

    public emitGiveActionPoints(target: Submarine): void {
        // this.move.emit({
        //     destination
        // });
    }

    public emitShareSonar(target: Submarine): void {
        this.shareSonar.emit({ target });
    }

}
