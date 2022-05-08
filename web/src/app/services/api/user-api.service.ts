import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BaseCollection, BaseData } from './base-data.interface';
import { environment } from "../../../environments/environment";

export interface UserData extends BaseData {
  email: string;
  roles: Array<string>;
}

export interface UserCollection extends BaseCollection<UserData> {
}

export interface AuthResponse {
  token: string;
  data: UserData;
}

@Injectable({
  providedIn: 'root'
})
export class UserApiService {

  constructor(private http: HttpClient) { }

  list() {
    return this.http.get<UserCollection>(environment.apiUrl + '/users');
  }

  get(id: string) {
    return this.http.get<UserData>(environment.apiUrl + '/users/' + id);
  }

  create(email: string, password: string) {
    return this.http.post<UserData>(environment.apiUrl + '/users', {
      email,
      plainPassword: password
    });
  }

  authenticate(email: string, password: string) {
    return this.http.post<AuthResponse>(environment.apiUrl + '/authentication_token', {
      email, password
    });
  }
}
