import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs/internal/Observable";
import { environment } from "src/environments/environment";

@Injectable({
    providedIn: 'root'
})
export class BaseApiService<T, C> {
    protected basePath: string = '';

    constructor(protected httpClient: HttpClient) { }

    getList(): Observable<C> {
        return this.httpClient.get<C>(this.buildUrl());
    }

    getItem(uuid: string): Observable<T> {
        return this.httpClient.get<T>(this.buildUrl(uuid));
    }

    create(data: T): Observable<T> {
        return this.httpClient.post<T>(this.buildUrl(), data);
    }

    update(uuid: string, data: T): Observable<T> {
        return this.httpClient.put<T>(this.buildUrl(uuid), data);
    }

    delete(uuid: string): Observable<T> {
        return this.httpClient.delete<T>(this.buildUrl(uuid));
    }

    getListFromResource(resource: string, resourceUuid: string): Observable<C> {
        return this.httpClient.get<C>(this.buildUrl(resourceUuid, resource));
    }

    protected buildUrl(uuid: string = '', resource: string | null = null): string {
        if (resource !== null) {
            return environment.apiUrl + '/' + resource + '/' + uuid + '/' + this.basePath;
        } else {
            return environment.apiUrl + '/' + this.basePath + '/' + uuid;
        }
    }
}