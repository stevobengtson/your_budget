import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { AccountComponent } from './account.component';
import { TransactionListComponent } from './transaction-list/transaction-list.component';

@NgModule({
    declarations: [
        AccountComponent,
        TransactionListComponent
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
