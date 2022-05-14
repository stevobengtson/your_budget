import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccountComponent } from './account/account.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './user/login/login.component';
import { RegisterComponent } from './user/register/register.component';
import { BudgetGuard } from './services/user-guard.guard';

/**
 * User
 *  - /user/login
 *  - /user/register
 * Dashboard
 *  - /users/budgets = Page to select budget or login user
 * Home
 *  - /{budget_id}/budget/{YYYYMM} = Budget page for month
 *  - /{budget_id}/accounts = Transaction list for all accounts
 *  - /{budget_id}/accounts/{account_id} = Transaction list for single account
 *  - /{budget_id}/reports/{name} = Report based on name
 * Settings
 *  - /settings
 */

const routes: Routes = [
  { path: '', redirectTo: '/dashboard', pathMatch: 'full' },
  { path: 'dashboard', component: DashboardComponent, canActivate: [BudgetGuard] },
  { 
    path: 'user', children: [
      { path: '', redirectTo: 'user/login', pathMatch: 'full' },
      { path: 'login', component: LoginComponent },
      { path: 'register', component: RegisterComponent }
    ]
  },
  {
    path: ':id', component: HomeComponent, canActivate: [BudgetGuard], children: [
      { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'accounts/:account_id', component: AccountComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
