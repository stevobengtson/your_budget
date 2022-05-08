import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TransactionListComponent } from './account/transaction-list/transaction-list.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { BudgetGuard } from './services/user-guard.guard';

/**
 * Dashboard
 *  - / = Page to select budget or login user
 * Home
 *  - /{budget_id}/budget/{YYYYMM} = Budget page for month
 *  - /{budget_id}/accounts = Transaction list for all accounts
 *  - /{budget_id}/accounts/{account_id} = Transaction list for single account
 *  - /{budget_id}/reports/{name} = Report based on name
 */

const routes: Routes = [
  { path: '', redirectTo: '/dashboard', pathMatch: 'full' },
  { path: 'dashboard', component: DashboardComponent, canActivate: [BudgetGuard] },
  // TODO: Put under '/account'
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  // TODO: Add Child routes for selections from the sidebar
  {
    path: ':id', component: HomeComponent, canActivate: [BudgetGuard], children: [
      { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'accounts/:id', component: TransactionListComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
