import { AfterViewInit, Component, Input, ViewChild } from "@angular/core";
import { Filter } from "src/app/services/api/base-api.service";
import { TransactionApiService, TransactionCollection, TransactionData } from "src/app/services/api/transaction-api.service";
import { MatPaginator } from '@angular/material/paginator';
import { MatSort, SortDirection } from '@angular/material/sort';
import { merge, Observable, of as observableOf } from 'rxjs';
import { catchError, map, startWith, switchMap } from 'rxjs/operators';

@Component({
    selector: 'app-transaction-list',
    templateUrl: './transaction-list.component.html',
    styleUrls: ['./transaction-list.component.css']
})
export class TransactionListComponent implements AfterViewInit {
    @Input() accountId: string = '';

    public displayedColumns: string[] = ['date', 'payee', 'category', 'memo', 'debit', 'credit', 'cleared'];
    public transactions: TransactionData[] = [];
    public resultsLength = 0;
    public isLoadingResults = true;

    @ViewChild(MatPaginator, {static: false}) paginator!: MatPaginator;
    @ViewChild(MatSort, {static: false}) sort!: MatSort;

    constructor(private transactionApiService: TransactionApiService) {
    }

    ngAfterViewInit(): void {
        // If the user changes the sort order, reset back to the first page.
        this.sort.sortChange.subscribe(() => (this.paginator.pageIndex = 0));

        merge(this.sort.sortChange, this.paginator.page)
        .pipe(
          startWith({}),
          switchMap(() => {
            this.isLoadingResults = true;
            return this.loadTransactions(
              this.sort.active,
              this.sort.direction,
              this.paginator.pageIndex + 1,
            ).pipe(catchError(() => observableOf(null)));
          }),
          map((data: TransactionCollection | null) => {
            // Flip flag to show that loading has finished.
            this.isLoadingResults = false;

            if (data == null) {
                return [];
            }
  
            // Only refresh the result length if there is new data. In case of rate
            // limit errors, we do not want to reset the paginator to zero, as that
            // would prevent users from re-triggering requests.
            this.resultsLength = data["hydra:totalItems"];
            return data["hydra:member"];
          }),
        )
        .subscribe(data => (this.transactions = data));
    }

    private loadTransactions(orderProperty: string, orderDirection: string, page: number): Observable<TransactionCollection> {
        let filter: Filter = new Filter();
        filter.page = page;
        filter.limit = 25;
        filter.addOrderBy(orderProperty, orderDirection);

        return this.transactionApiService.getListFromResource('accounts', this.accountId, filter);
    }
}
