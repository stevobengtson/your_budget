import { Injectable } from '@angular/core';
import { UserData } from './user-api.service';
import { BaseCollection, BaseData } from './base-data.interface';
import { BaseApiService } from './base-api.service';

export interface BudgetData extends BaseData {
    name: string;
    startDate: Date;
    accounts: string[];
    budget_months: string[];
    categories: string[];
    payees: string[];
    user: UserData;
}

export interface BudgetCollection extends BaseCollection<BudgetData> {
}

@Injectable({
    providedIn: 'root'
})
export class BudgetApiService extends BaseApiService<BudgetData, BudgetCollection> {
    override basePath = "budgets";
}
