import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { BudgetApiService, BudgetData, BudgetCollection } from '../services/api/budget-api.service';
import { AuthService } from '../services/auth.service';
import { BlockUIService } from '../services/block-ui.service';
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
    selector: 'app-budget',
    templateUrl: './budget.component.html',
    styleUrls: ['./budget.component.css']
})
export class BudgetComponent implements OnInit {
    public options: FormGroup;
    public budget: BudgetData | null = null;
    public accountId: string | undefined;

    private userId: string = '';

    constructor(
        fb: FormBuilder,
        public dialog: MatDialog,
        private budgetApiService: BudgetApiService,
        private authService: AuthService,
        private blockUIService: BlockUIService
    ) {
        this.options = fb.group({
            bottom: 0,
            fixed: false,
            top: 0,
        });
    }

    ngOnInit(): void {
        this.userId = this.authService.userData?.id ?? '';

        this.blockUIService.block();
        this.loadBudgets();
    }

    showAccount(accountId: string): void {
        console.log("Account selected: " + accountId);
        this.accountId = accountId;
    }

    private loadBudgets(): void {
        this.budgetApiService
            .getListFromResource('users', this.userId)
            .subscribe({
                next: (budgets: BudgetCollection) => {
                    if (budgets["hydra:member"].length > 0) {
                        // Pick the first one for now
                        this.budget = budgets["hydra:member"][0];
                    }
                },
                error: (error: any) => {
                    console.log(error);
                },
                complete: () => this.blockUIService.unblock()
            });
    }
}
