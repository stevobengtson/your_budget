import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { UserData } from './user-api.service';
import { BaseCollection, BaseData } from './base-data.interface';
import { environment } from "../../../environments/environment";
import { Observable } from 'rxjs';

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
export class BudgetApiService {

    constructor(private http: HttpClient) { }

    // TODO: Get Active Budget for User
    getUserBudgets(userId: string) {
        return this.http.get<BudgetCollection>(environment.apiUrl + '/users/' + userId + '/budgets');
    }

    get(id: string) {
        return this.http.get<BudgetData>(environment.apiUrl + '/budgets/' + id);
    }

    create(name: string, userId: string) {
        return this.http.post<BudgetData>(environment.apiUrl + '/budgets', {
            name,
            user: '/users/' + userId
        });
    }
}
