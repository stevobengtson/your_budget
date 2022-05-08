import { HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, Observable, throwError, of } from 'rxjs';
import { AuthService } from '../services/auth.service';

@Injectable()
export class JwtInterceptor implements HttpInterceptor {
    constructor(private router: Router, private authService: AuthService) {}

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        const idToken = localStorage.getItem("id_token");
        let cloned = req.clone(); 
        
        if  (idToken) {
            cloned = req.clone({headers: req.headers.set("Authorization", "Bearer " + idToken)});
        }

        return next.handle(cloned).pipe(catchError(x => this.handleAuthError(x)));
    }

    private handleAuthError(err: HttpErrorResponse): Observable<any> {
        if (err.status === 401 || err.status === 403) {
            this.authService.logout();
            this.router.navigateByUrl(`/login`);
            return of(err.message);
        }
        return throwError(() => new Error(err.message));
    }
}
