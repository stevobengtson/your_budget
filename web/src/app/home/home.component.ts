import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { BudgetApiService, BudgetData } from '../services/api/budget-api.service';

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
    ) { }

    ngOnInit(): void {
        this.budgetId = this.route.snapshot.paramMap.get('id') ?? '';
        this.budgetApiService.getItem(this.budgetId).subscribe((budget: BudgetData) => {
            this.budget = budget;
        });
    }
}
