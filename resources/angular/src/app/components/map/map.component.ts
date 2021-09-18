import { Component, Input, OnInit } from '@angular/core';
import { Grid } from "../../models/grid";

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.scss']
})
export class MapComponent implements OnInit {

    @Input()
    public grid: Grid = [[]];

    constructor() {
    }

    ngOnInit(): void {
    }

}
