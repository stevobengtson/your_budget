import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { TruncateTextPipe } from '../shared/truncate-text.pipe';
import { CreateBudgetComponent } from './create/create_budget.component';
import { DashboardComponent } from './dashboard.component';

@NgModule({
    declarations: [
        DashboardComponent,
        CreateBudgetComponent,
        TruncateTextPipe
    ],
    imports: [
        SharedModule
    ]
})
export class DashboardModule { }
