import { Component } from "@angular/core";
import { ActivatedRoute } from "@angular/router";
import { AccountApiService, AccountData } from "../services/api/account-api.service";

@Component({
    selector: 'app-account',
    templateUrl: './account.component.html',
    styleUrls: ['./account.component.css']
})
export class AccountComponent {
    public accountId: string | null = null;
    public account: AccountData | null = null;

    constructor(private route: ActivatedRoute, private accountApiService: AccountApiService) {}

    ngOnInit(): void {
        this.accountId = this.route.snapshot.paramMap.get('account_id');
        if (this.accountId !== null) {
            this.accountApiService.getItem(this.accountId).subscribe((account: AccountData) => this.account = account);
        }
     }
}
