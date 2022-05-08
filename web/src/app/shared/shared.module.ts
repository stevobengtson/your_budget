import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AngularMaterialModule } from './angular-material.module';
import { BlockUIModule } from 'ng-block-ui';

@NgModule({
    imports: [CommonModule, BlockUIModule.forRoot()],
    declarations: [],
    exports: [CommonModule, FormsModule, ReactiveFormsModule, AngularMaterialModule, BlockUIModule]
})
export class SharedModule { }