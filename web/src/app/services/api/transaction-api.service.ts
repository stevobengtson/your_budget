import { Injectable } from "@angular/core";
import { BaseApiService } from "./base-api.service";
import { BaseCollection, BaseData } from "./base-data.interface";

export interface TransactionData extends BaseData {
    account: string,
    date: Date,
    memo: string,
    payee: string,
    category: string,
    credit: string | null,
    debit: string | null,
    cleared: boolean
}

export interface TransactionCollection extends BaseCollection<TransactionData> {
    
}

@Injectable({
    providedIn: 'root'
})
export class TransactionApiService extends BaseApiService<TransactionData, TransactionCollection> {
    override basePath = "transactions";
}