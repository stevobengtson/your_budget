import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { BudgetComponent } from './budget.component';

@NgModule({
    declarations: [
        BudgetComponent
    ],
    imports: [
        SharedModule
    ]
})
export class BudgetModule { }
