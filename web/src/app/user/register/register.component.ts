import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { UserApiService, UserData } from '../../services/api/user-api.service';

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent {
    public email = '';
    public password = '';

    constructor(private userApiService: UserApiService, private router: Router) { }

    public onSubmit(): void {
        this.userApiService.create(this.email, this.password).subscribe((user: UserData) => {
            this.router.navigate(['/login']);
        });
    }
}
