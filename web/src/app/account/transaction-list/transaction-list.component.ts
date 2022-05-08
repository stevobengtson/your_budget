import { Component, Input, OnChanges, SimpleChanges } from "@angular/core";
import { BudgetManagerService } from "src/app/services/budget-manager.service";

export interface TransactionData {
    date: string;
    payee: string;
    category: string;
    memo: string;
    debit: number;
    credit: number;
}

@Component({
    selector: 'app-transaction-list',
    templateUrl: './transaction-list.component.html',
    styleUrls: ['./transaction-list.component.css']
})
export class TransactionListComponent implements OnChanges {
    @Input() accountId: string = '';

    public displayedColumns: string[] = ['date', 'payee', 'category', 'memo', 'debit', 'credit'];
    public transactions: TransactionData[] = [];

    constructor(private budgetManagerService: BudgetManagerService) { }

    ngOnChanges(changes: SimpleChanges): void {
        for (const propName in changes) {
            if (propName == 'accountId') {
                this.loadTransactions();
            }
        }
    }


    private loadTransactions(): void {
        this.transactions = [
            { date: '24/03/2022', payee: 'Hydrogen', category: 'Test', memo: 'H', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Helium', category: 'Test', memo: 'He', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Lithium', category: 'Test', memo: 'Li', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Beryllium', category: 'Test', memo: 'Be', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Boron', category: 'Test', memo: 'B', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Carbon', category: 'Test', memo: 'C', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Nitrogen', category: 'Test', memo: 'N', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Oxygen', category: 'Test', memo: 'O', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Fluorine', category: 'Test', memo: 'F', debit: 0.00, credit: 10.00 },
            { date: '24/03/2022', payee: 'Neon', category: 'Test', memo: 'Ne', debit: 0.00, credit: 10.00 },
        ];
    }
}
