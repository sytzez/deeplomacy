import { Component, Input, OnInit } from '@angular/core';
import { Grid } from "../../models/grid";
import { MySubmarine } from "../../models/my-submarine";
import { Cell } from "../../models/cell";

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

}
