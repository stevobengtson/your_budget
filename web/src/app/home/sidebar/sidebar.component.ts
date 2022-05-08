import { Component, EventEmitter, Input, Output } from '@angular/core';
import { BudgetData } from 'src/app/services/api/budget-api.service';

@Component({
    selector: 'app-sidebar',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent {
    @Input() budget: BudgetData | null = null;
    @Output() onAccountPicked = new EventEmitter<string>();

    public addAccount(): void {
        console.log("Add account!");
    }

    public pickMenu(menuId: number): void {
        console.log("Menu Item picked: " + menuId);
    }
}
