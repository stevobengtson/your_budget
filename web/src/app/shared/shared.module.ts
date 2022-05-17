import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AngularMaterialModule } from './angular-material.module';
import { BlockUIModule } from 'ng-block-ui';
import { CurrencyMaskModule } from "ng2-currency-mask";
import { PayeeSelectorComponent } from './payee-selector/payee-selector.component';

@NgModule({
    imports: [
        CommonModule,
        BlockUIModule.forRoot(),
        AngularMaterialModule
    ],
    declarations: [
        PayeeSelectorComponent
    ],
    exports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        AngularMaterialModule,
        BlockUIModule,
        CurrencyMaskModule,
        PayeeSelectorComponent
    ]
})
export class SharedModule { }