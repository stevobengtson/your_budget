import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { Subject, takeUntil } from 'rxjs';
import { UserData } from './services/api/user-api.service';
import { AuthService } from './services/auth.service';
import { BlockUI, NgBlockUI } from 'ng-block-ui';
import { BlockUIService } from './services/block-ui.service';
import { CacheService } from './services/cache.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  public title = 'Your Budget';
  public isAuthenticated = false;
  public userData: UserData | null = null;
  private _destroySub$ = new Subject<void>();

  @BlockUI() blockUI!: NgBlockUI;

  constructor(
    private authService: AuthService,
    private router: Router,
    private blockUIService: BlockUIService,
    private cacheService: CacheService
  ) {

    this.blockUIService.isBlocked$.pipe(
      takeUntil(this._destroySub$)
    ).subscribe((isBlocked: boolean) => {
      isBlocked ? this.blockUI.start() : this.blockUI.stop();
    });

    authService.isAuthenticated$.pipe(
      takeUntil(this._destroySub$)
    ).subscribe((isAuthenticated: boolean) => this.isAuthenticated = isAuthenticated);

    authService.userData$.pipe(
      takeUntil(this._destroySub$)
    ).subscribe((userData: UserData | null) => this.userData = userData);
  }

  logout() {
    this.authService.logout();
    this.router.navigateByUrl('/login');
  }

  clearCache() {
    this.cacheService.cleanLocalStorage();
  }
}
