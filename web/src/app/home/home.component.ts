import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { BudgetApiService, BudgetData } from '../services/api/budget-api.service';
import { BudgetManagerService } from '../services/budget-manager.service';

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
    public budgetId: string = '';
    public budget: BudgetData | null = null;

    constructor(
        private route: ActivatedRoute,
        private budgetApiService: BudgetApiService,
        private budgetManagerService: BudgetManagerService
    ) { }

    ngOnInit(): void {
        this.budgetId = this.route.snapshot.paramMap.get('id') ?? '';
        this.budgetApiService.get(this.budgetId).subscribe((budget: BudgetData) => {
            this.budget = budget;
            this.budgetManagerService.budget = budget;
        });
    }
}
