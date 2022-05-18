import { Injectable } from '@angular/core';
import { BaseCollection, BaseData } from './base-data.interface';
import { environment } from "../../../environments/environment";
import { BaseApiService } from './base-api.service';

export interface UserData extends BaseData {
  email: string;
  roles?: Array<string>;
  password: string;
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
export class UserApiService extends BaseApiService<UserData, UserCollection> {
  override basePath = 'users';

  authenticate(email: string, password: string) {
    return this.httpClient.post<AuthResponse>(environment.apiUrl + '/authentication_token', {
      email, password
    });
  }
}
