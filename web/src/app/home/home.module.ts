import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { AccountModule } from '../account/account.module';
import { SharedModule } from '../shared/shared.module';
import { AccountListComponent } from './account-list/account-list.component';
import { HomeComponent } from './home.component';
import { SidebarComponent } from './sidebar/sidebar.component';

@NgModule({
    declarations: [
        HomeComponent,
        SidebarComponent,
        AccountListComponent
    ],
    imports: [
        RouterModule,
        SharedModule,
        AccountModule
    ]
})
export class HomeModule { }
