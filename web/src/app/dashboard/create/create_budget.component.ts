import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { BudgetData } from 'src/app/services/api/budget-api.service';

@Component({
    selector: 'app-create_budget',
    templateUrl: './create_budget.component.html',
    styleUrls: ['./create_budget.component.css']
})
export class CreateBudgetComponent {
    constructor(
        public dialogRef: MatDialogRef<CreateBudgetComponent>,
        @Inject(MAT_DIALOG_DATA) public data: BudgetData,
    ) { }

    onNoClick(): void {
        this.dialogRef.close();
    }
}
