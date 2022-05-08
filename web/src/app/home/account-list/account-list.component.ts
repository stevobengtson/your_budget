import { Component, EventEmitter, Input, OnChanges, Output, SimpleChanges } from "@angular/core";
import { Router } from "@angular/router";
import { BudgetManagerService } from "src/app/services/budget-manager.service";
import { AccountApiService, AccountCollection, AccountData } from "../../services/api/account-api.service";

@Component({
    selector: 'app-account-list',
    templateUrl: './account-list.component.html',
    styleUrls: ['./account-list.component.css']
})
export class AccountListComponent implements OnChanges {
    @Input() budgetId: string = '';
    @Output() onAccountPicked = new EventEmitter<string>();

    public accounts: AccountData[] = [];

    constructor(
        private accountApiService: AccountApiService,
        private router: Router) { }

    ngOnChanges(changes: SimpleChanges): void {
        for (const propName in changes) {
            if (propName == 'budgetId') {
                this.loadAccounts();
            }
        }
    }

    public addAccount(): void {
        alert("Work in Progress");
    }

    public pickAccount(accountId: string): void {
        this.router.navigate([this.budgetId, 'accounts', accountId]);
    }

    private loadAccounts(): void {
        this.accountApiService.getBudgetAccounts(this.budgetId).subscribe((accounts: AccountCollection) => {
            this.accounts = accounts["hydra:member"];
        });
    }
}
