import { Injectable } from '@angular/core';
import { BehaviorSubject, map, Observable } from 'rxjs';
import { AuthResponse, UserApiService, UserData } from './api/user-api.service';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  public redirectUrl: string | null = null;

  private _authSub$: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
  public get isAuthenticated$(): Observable<boolean> {
    return this._authSub$.asObservable();
  }

  private _userSub$: BehaviorSubject<UserData | null> = new BehaviorSubject<UserData | null>(null);
  public get userData$(): Observable<UserData | null> {
    return this._userSub$.asObservable();
  }

  constructor(private userApiService: UserApiService) {
    this.loadAuthData();
  }

  public get isAuthenticated(): boolean {
    return this._authSub$.value;
  }

  public get userData(): UserData | null {
    return this._userSub$.value;
  }

  login(email: string, password: string): Observable<void> {
    return this.userApiService.authenticate(email, password).pipe(
      map((auth: AuthResponse) => this.handleSignInResponse(auth))
    );
  }

  logout() {
    localStorage.removeItem('id_token');
    localStorage.removeItem('user_data');
    this._authSub$.next(false);
    this._userSub$.next(null);
  }

  private handleSignInResponse(auth: AuthResponse): void {
    localStorage.setItem('id_token', auth.token);
    localStorage.setItem('user_data', JSON.stringify(auth.data));
    this._authSub$.next(true);
    this._userSub$.next(auth.data);
  }

  private loadAuthData() {
    let idToken = localStorage.getItem('id_token');
    let strUserData = localStorage.getItem('user_data');
    let userData = strUserData == null ? null : JSON.parse(strUserData);
    this._authSub$.next(idToken !== null);
    this._userSub$.next(userData);    
  }
}
