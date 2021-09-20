import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GiveActionPointsDialogComponent } from './give-action-points-dialog.component';

describe('GiveActionPointsDialogComponent', () => {
    let component: GiveActionPointsDialogComponent;
    let fixture: ComponentFixture<GiveActionPointsDialogComponent>;

    beforeEach(async () => {
        await TestBed.configureTestingModule({
            declarations: [GiveActionPointsDialogComponent]
        })
            .compileComponents();
    });

    beforeEach(() => {
        fixture = TestBed.createComponent(GiveActionPointsDialogComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
