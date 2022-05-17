import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { AccountComponent } from './account.component';
import { TransactionListComponent } from './transaction-list/transaction-list.component';
import { AddTransactionDialogComponent } from './transaction-list/account-transaction-list-add-transaction-dialog/add-transaction-dialog.component';

@NgModule({
    declarations: [
        AccountComponent,
        TransactionListComponent,
        AddTransactionDialogComponent
    ],
    imports: [
        CommonModule,
        SharedModule
    ],
    exports: [
        AccountComponent,
        TransactionListComponent
    ]
})
export class AccountModule { }
