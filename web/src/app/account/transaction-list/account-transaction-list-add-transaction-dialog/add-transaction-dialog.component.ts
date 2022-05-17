import { Component, Inject, Optional } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Validators } from '@angular/forms';

interface TransactionDialogData {
  date: Date;
  payee: string;
  category: string;
  memo: string;
  debit: string;
  credit: string;
  cleared: boolean;
  action: string;
}

@Component({
  selector: 'app-add-transaction-dialog',
  templateUrl: './add-transaction-dialog.component.html',
  styleUrls: ['./add-transaction-dialog.component.scss']
})
export class AddTransactionDialogComponent {
  action: string = 'Add';

  transactionForm = this.fb.group({
    date: ['', Validators.required],
    payee: ['', Validators.required],
    category: ['', Validators.required],
    memo: [''],
    amount: ['', Validators.required],
    cleared: [''],
  });

  constructor(
    public dialogRef: MatDialogRef<AddTransactionDialogComponent>,
    @Optional() @Inject(MAT_DIALOG_DATA) public data: TransactionDialogData,
    private fb: FormBuilder
  ) {
    this.transactionForm.controls['date'].setValue(new Date());
    if (data.date) {
      this.transactionForm.controls['date'].setValue(data.date);
    }
    if (data.payee) {
      this.transactionForm.controls['payee'].setValue(data.payee);
    }
    if (data.category) {
      this.transactionForm.controls['category'].setValue(data.category);
    }
    if (data.memo) {
      this.transactionForm.controls['memo'].setValue(data.memo);
    }
    if (data.credit) {
      this.transactionForm.controls['amount'].setValue(data.credit);
    }
    if (data.debit) {
      this.transactionForm.controls['amount'].setValue(data.debit);
    }
    if (data.cleared) {
      this.transactionForm.controls['cleared'].setValue(data.cleared);
    }
    this.action = data.action;
  }

  onSubmit(form: FormGroup) {
    if (form.valid) {
      this.dialogRef.close({event: this.action, data: {
        date: form.value.date,
        payee: form.value.payee,
        category: form.value.category,
        memo: form.value.memo,
        credit: form.value.amount >= 0 ? form.value.amount : null,
        debit: form.value.amount < 0 ? form.value.amount : null,
        cleared: form.value.cleared
      }});
    }
  }

  closeDialog() {
    this.dialogRef.close({event:'Cancel'});
  }
}
