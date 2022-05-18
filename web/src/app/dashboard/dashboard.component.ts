import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BudgetApiService, BudgetData, BudgetCollection } from '../services/api/budget-api.service';
import { MatDialog } from '@angular/material/dialog';
import { AuthService } from '../services/auth.service';
import { BlockUIService } from '../services/block-ui.service';
import { CreateBudgetComponent } from './create/create_budget.component';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
    private userId: string = '';
    public budgets: BudgetData[] | null = null;

    constructor(
        private budgetApiService: BudgetApiService,
        private authService: AuthService,
        private blockUIService: BlockUIService,
        private router: Router,
        public dialog: MatDialog,
    ) { }

    ngOnInit(): void {
        this.userId = this.authService.userData?.id || '';
        if (this.userId !== '') {
            this.blockUIService.block();
            this.budgetApiService
                .getListFromResource('users', this.userId)
                .subscribe({
                    next: (budgets: BudgetCollection) => this.budgets = budgets["hydra:member"],
                    complete: () => this.blockUIService.unblock()
                });
        } else {
            console.log("Route me to the login page.");
        }
    }

    public openBudget(budgetId: string): void {
        this.router.navigate([budgetId]);
    }

    public createBudget(): void {
        const dialogRef = this.dialog.open(CreateBudgetComponent, {
            data: {},
        });

        dialogRef.afterClosed().subscribe((result: BudgetData) => {
            this.budgetApiService.create(result).subscribe((budget: BudgetData) => {
                this.budgets?.push(budget);
            });
        });
    }

}
