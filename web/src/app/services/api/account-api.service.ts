import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { BaseCollection, BaseData } from "./base-data.interface";
import { environment } from "../../../environments/environment";

export interface AccountData extends BaseData {
    name: string;
    description: string;
    balance: number;
}

export interface AccountCollection extends BaseCollection<AccountData> {
}

@Injectable({
    providedIn: 'root'
})
export class AccountApiService {
    constructor(private http: HttpClient) { }

    getBudgetAccounts(budgetId: string) {
        return this.http.get<AccountCollection>(environment.apiUrl + '/budgets/' + budgetId + '/accounts');
    }

    get(id: string) {
        return this.http.get<AccountData>(environment.apiUrl + '/accounts/' + id);
    }
}