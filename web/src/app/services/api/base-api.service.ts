import { HttpClient, HttpParams } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs/internal/Observable";
import { environment } from "src/environments/environment";

export class Filter {
    private _page: number | null = null;
    private _limit: number | null = null;
    private _orderBy: Map<string, string> | null = null;
    protected defaultLimit: number = 25;

    public set page(value: number) {
        this._page = value;
    }

    public set limit(value: number) {
        this._limit = value;
    }

    public addOrderBy(property: string, orderValue: string = 'asc') {
        if (this._orderBy == null) {
            this._orderBy = new Map<string, string>();
        }

        this._orderBy.set(property, orderValue);
    }

    public toString(): string {
        let params = new HttpParams();

        if (this._page !== null) {
            params = params.set('page', this._page);
            if (this._limit !== null) {
                params = params.set('itemsPerPage', this._limit);
            } else {
                params = params.set('itemsPerPage', environment.defaultPageLimit);
            }
        }

        if (this._orderBy !== null) {
            for (let [key, value] of this._orderBy) {
                params = params.set('order[' + key + ']', value);
            }
        }

        if (params.keys().length === 0) {
            return '';
        }

        return  '?' + params.toString();        
    }
}

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

    getListFromResource(resource: string, resourceUuid: string, filter: Filter): Observable<C> {
        return this.httpClient.get<C>(this.buildUrl(resourceUuid, filter, resource));
    }

    protected buildUrl(uuid: string = '', filter: Filter | null = null, resource: string | null = null): string {
        let outUrl = environment.apiUrl + '/'; 

        outUrl += (resource !== null ? resource : this.basePath);
        outUrl += '/' + uuid;
        outUrl += (resource !== null ? '/' + this.basePath : '');

        return outUrl + filter?.toString();
    }
}