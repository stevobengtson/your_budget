import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  public loginValid = true;
  public email = '';
  public password = '';

  private readonly returnUrl: string;

  constructor(
    private _route: ActivatedRoute,
    private _router: Router,
    private _authService: AuthService
  ) {
    this.returnUrl = this._route.snapshot.queryParams['returnUrl'] || '/dashboard';
  }

  public onSubmit(): void {
    this.loginValid = true;

    this._authService.login(this.email, this.password).subscribe({
      next: _ => {
        this.loginValid = true;
        this._router.navigateByUrl(this.returnUrl);
      },
      error: _ => this.loginValid = false
    });
  }
}