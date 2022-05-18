import { Injectable } from "@angular/core";
import { BaseCollection, BaseData } from "./base-data.interface";
import { BaseApiService } from "./base-api.service";

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
export class AccountApiService extends BaseApiService<AccountData, AccountCollection> {
    override basePath = "accounts";
}