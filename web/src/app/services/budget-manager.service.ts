import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { AccountCollection, AccountData } from "./api/account-api.service";
import { BudgetCollection, BudgetData } from "./api/budget-api.service";

@Injectable({
    providedIn: 'root'
})
export class BudgetManagerService {
    public userBudgets: BudgetCollection | null = null;
    public budget: BudgetData | null = null;
    public accounts: AccountCollection | null = null;
    public selectedAccount: AccountData | null = null;

    public selectAccount(accountId: string) {
        if (this.accounts == null) {
            return null;
        } else {
            this.selectedAccount = <AccountData>this.accounts["hydra:member"].find(account => account.id == accountId);
            return this.selectedAccount;
        }
    }
}
