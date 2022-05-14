import { Component, Input, OnChanges, SimpleChanges } from "@angular/core";
import { TransactionApiService, TransactionCollection, TransactionData } from "src/app/services/api/transaction-api.service";

@Component({
    selector: 'app-transaction-list',
    templateUrl: './transaction-list.component.html',
    styleUrls: ['./transaction-list.component.css']
})
export class TransactionListComponent implements OnChanges {
    @Input() accountId: string | null = null;

    public displayedColumns: string[] = ['date', 'payee', 'category', 'memo', 'debit', 'credit', 'cleared'];
    public transactions: TransactionData[] = [];

    constructor(private transactionApiService: TransactionApiService) { }

    ngOnChanges(changes: SimpleChanges): void {
        for (const propName in changes) {
            if (propName == 'accountId') {
                this.loadTransactions();
            }
        }
    }

    private loadTransactions(): void {
        if (this.accountId == null) {
            return;
        }

        this.transactionApiService.getListFromResource('accounts', this.accountId).subscribe((transactions: TransactionCollection) => {
            this.transactions = transactions["hydra:member"];
        });
    }
}
