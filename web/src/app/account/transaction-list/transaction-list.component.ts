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

@Component({
    selector: 'app-transaction-list',
    templateUrl: './transaction-list.component.html',
    styleUrls: ['./transaction-list.component.css']
})
export class TransactionListComponent implements AfterViewInit {
    @Input() accountId: string = '';
    @Input() accountName: string | undefined = '';

    public displayedColumns: string[] = ['date', 'payee', 'category', 'memo', 'debit', 'credit', 'cleared', 'action'];
    public transactions: TransactionData[] = [];
    public resultsLength = 0;
    public isLoadingResults = true;

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
        .subscribe(data => (this.transactions = data));
    }

    openDialog(action: any, obj: any) {
      obj.action = action;
      const dialogRef = this.dialog.open(AddTransactionDialogComponent, {
        data: obj
      });
  
      dialogRef.afterClosed().subscribe(result => {
        if (result.event == 'Add') {
          this.addRowData(result.data);
        } else if(result.event == 'Update') {
          this.updateRowData(result.data);
        } else if(result.event == 'Delete') {
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

    addRowData(row_obj: TransactionData) {
      console.log('Add', row_obj);
      // Store in database
      // Add results to the transacton list
      // How to ensure it is in the correct spot?
    }

    updateRowData(row_obj: TransactionData) {
      console.log('Update', row_obj);
      // Store in database
      // Find entry in transaction list
      // Update list data
    }

    deleteRowData(row_obj: TransactionData) {
      console.log('Delete', row_obj);
      // Delete from database
      // Remove entry from list
    }
}
