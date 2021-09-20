import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from "@angular/material/dialog";
import { FormControl, Validators } from "@angular/forms";

export interface GiveActionPointsDialogData {
    max: number;
}

@Component({
    selector: 'app-give-action-points-dialog',
    templateUrl: './give-action-points-dialog.component.html',
    styleUrls: ['./give-action-points-dialog.component.scss']
})
export class GiveActionPointsDialogComponent {

    public amount = new FormControl(null, Validators.required);

    constructor(
        @Inject(MAT_DIALOG_DATA)
        public data: GiveActionPointsDialogData,
        protected dialogRef: MatDialogRef<GiveActionPointsDialogComponent>,
    ) {
    }

    public cancel(): void {

        this.dialogRef.close();
    }
}
