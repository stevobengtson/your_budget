import { NgModule } from "@angular/core";
import { RouterModule } from "@angular/router";
import { SharedModule } from "../shared/shared.module";
import { LoginComponent } from "./login/login.component";
import { RegisterComponent } from "./register/register.component";

@NgModule({
    declarations: [
        LoginComponent,
        RegisterComponent
    ],
    imports: [
        RouterModule,
        SharedModule
    ]
})
export class UserModule { }
