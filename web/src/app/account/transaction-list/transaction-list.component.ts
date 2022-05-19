import { AfterViewInit, Component, Input, ViewChild } from "@angular/core";
import { Filter } from "src/app/services/api/base-api.service";
import { TransactionApiService, TransactionCollection, TransactionData } from "src/app/services/api/transaction-api.service";
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { merge, Observable, of as observableOf } from 'rxjs';
import { catchError, map, startWith, switchMap } from 'rxjs/operators';
import { AddTransactionDialogComponent } from "./account-transaction-list-add-transaction-dialog/add-transaction-dialog.component";
import { MatDialog } from "@angular/material/dialog";
import { BlockUIService } from '../../services/block-ui.service';
import { MatTableDataSource } from "@angular/material/table";

@Component({
    selector: 'app-transaction-list',
    templateUrl: './transaction-list.component.html',
    styleUrls: ['./transaction-list.component.css']
})
export class TransactionListComponent implements AfterViewInit {
    @Input() accountId: string = '';
    @Input() accountName: string | undefined = '';

    public displayedColumns: string[] = ['date', 'payee', 'category', 'memo', 'debit', 'credit', 'cleared', 'action'];
    public resultsLength = 0;
    public isLoadingResults = true;

    dataSource = new MatTableDataSource<TransactionData>();
    @ViewChild(MatPaginator, {static: false}) paginator!: MatPaginator;
    @ViewChild(MatSort, {static: false}) sort!: MatSort;

    constructor(
      public dialog: MatDialog,
      private transactionApiService: TransactionApiService,
      private blockUIService: BlockUIService
    ) {
    }

    ngAfterViewInit(): void {
        // If the user changes the sort order, reset back to the first page.
        this.sort.sortChange.subscribe(() => (this.paginator.pageIndex = 0));

        merge(this.sort.sortChange, this.paginator.page)
        .pipe(
          startWith({}),
          switchMap(() => {
            this.blockUIService.block();
            return this.loadTransactions(
              this.sort.active,
              this.sort.direction,
              this.paginator.pageIndex + 1,
            ).pipe(catchError(() => observableOf(null)));
          }),
          map((data: TransactionCollection | null) => {
            this.blockUIService.unblock();

            if (data == null) {
                return [];
            }
  
            this.resultsLength = data["hydra:totalItems"];
            return data["hydra:member"];
          }),
        )
        .subscribe(data => (this.dataSource.data = data));
    }

    openDialog(action: any, obj: any) {
      obj.action = action;
      const dialogRef = this.dialog.open(AddTransactionDialogComponent, {
        data: obj
      });
  
      dialogRef.afterClosed().subscribe(result => {
        if (result.event == 'Add') {
          this.addRowData(result.data);
        } else if (result.event == 'Update') {
          this.updateRowData(result.data);
        } else if (result.event == 'Delete') {
          this.deleteRowData(result.data);
        }
      });
    }

    private loadTransactions(orderProperty: string, orderDirection: string, page: number): Observable<TransactionCollection> {
        let filter: Filter = new Filter();
        filter.page = page;
        filter.limit = 25;
        filter.addOrderBy(orderProperty, orderDirection);

        return this.transactionApiService.getListFromResource('accounts', this.accountId, filter);
    }

    addRowData(row: TransactionData) {
      this.transactionApiService.create({
        account: '/accounts/' + this.accountId,
        date: row.date,
        memo: row.memo,
        payee: row.payee,
        category: row.category,
        credit: this.transactionApiService.toStringOrNull(row.credit),
        debit: this.transactionApiService.toStringOrNull(row.debit),
        cleared: !!row.cleared
      }).subscribe({
        next: (data: TransactionData) => {
          this.dataSource.data = [data, ...this.dataSource.data];
        },
        error: (err: any) => console.log(err)
      });
    }

    updateRowData(row: TransactionData) {
      if (row.id === undefined) {
        return;
      }

      this.transactionApiService.update(row.id, {
        account: '/accounts/' + this.accountId,
        date: row.date,
        memo: row.memo,
        payee: row.payee,
        category: row.category,
        credit: this.transactionApiService.toStringOrNull(row.credit),
        debit: this.transactionApiService.toStringOrNull(row.debit),
        cleared: !!row.cleared
      }).subscribe({
        next: (data: TransactionData) => {
          row = data;
        },
        error: (err: any) => console.log(err)
      });
    }

    deleteRowData(row: TransactionData) {
      if (row.id === undefined) {
        return;
      }

      this.transactionApiService.delete(row.id).subscribe({
        next: () => this.dataSource.data = this.dataSource.data.filter((data: TransactionData) => data.id !== row.id),
        error: (err: any) => console.log(err)
      });
    }
}
