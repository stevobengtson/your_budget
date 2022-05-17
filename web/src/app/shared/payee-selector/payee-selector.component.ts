import { Component } from '@angular/core';

@Component({
  selector: 'app-payee-selector',
  templateUrl: './payee-selector.component.html',
  styleUrls: ['./payee-selector.component.scss']
})
export class PayeeSelectorComponent {
  options: string[] = ['One', 'Two', 'Three'];
}
