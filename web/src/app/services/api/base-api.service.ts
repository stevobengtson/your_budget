import { HttpClient, HttpParams } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { catchError, of, Subject, tap } from "rxjs";
import { Observable } from "rxjs/internal/Observable";
import { environment } from "src/environments/environment";
import { BaseData, BaseCollection } from "./base-data.interface";

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

        return  params.toString();        
    }
}

export class UrlBuilder {
    private basePath: string = '';
    private uuid: string | null = null;
    private preresource: string | null = null;
    private preresourceUuid: string | null = null;
    private subresource: string | null = null;
    private filterDetails: string | null = null;

    public constructor(basePath: string) {
        this.basePath = basePath;
    }

    public get url(): string {
        let fullUrl = environment.apiUrl;

        if (this.preresource !== null) {
            fullUrl += '/' + this.preresource + '/' + this.preresourceUuid;
        }

        fullUrl += '/' + this.basePath;

        if (this.uuid !== null) {
            fullUrl += '/' + this.uuid;
        }

        if (this.subresource !== null) {
            fullUrl += '/' + this.subresource;
        }

        if (this.filterDetails !== null) {
            fullUrl += '?' + this.filterDetails;
        }

        return fullUrl;
    }

    public addUuid(uuid: string | null): UrlBuilder {
        this.uuid = uuid;
        return this;
    }

    public addPreresource(preresource: string | null): UrlBuilder {
        this.preresource = preresource;
        return this;
    }

    public addPreresourceUuid(preresourceUuid: string | null): UrlBuilder {
        this.preresourceUuid = preresourceUuid;
        return this;
    }

    public addSubresource(subresource: string | null): UrlBuilder {
        this.subresource = subresource;
        return this;
    }

    public addFilter(filter: Filter | null = null): UrlBuilder {
        if (filter !== null) {
            this.filterDetails = filter.toString();
        }
        return this;
    }
}

/**
 * This is the base api service, all other api services extend from here.
 * basePath must be updated with the correct path:
 * ie: for /users basePath should be "users"
 * T is a class that extends the BaseData
 * C is a class that extends the BaseCollection
 * 
 * Note: Use the cache service with this to cache repeated calls to the
 * api service for the get calls. Has a low timeout.
 */
@Injectable({
    providedIn: 'root'
})
export class BaseApiService<T extends BaseData, C extends BaseCollection<T>> {
    // Override with path, example: "transactions"
    protected basePath: string = '';
    // Hold our local data
    protected dataCollection: C | null = null;
    protected selectedData: T | null = null;
    // Observables
    public dataCollection$: Subject<C|null>;
    public selectedData$: Subject<T|null>;

    constructor(protected httpClient: HttpClient) {
        this.dataCollection$ = new Subject<C|null>();
        this.selectedData$ = new Subject<T|null>();
    }

    /**
     * Select a single entity from the local collection if available.
     * @param id UUid of the data to select.
     */
    selecteData(id: string): T | null {
        if (this.dataCollection === null) {
            return null;
        }

        let data: T | null = <T|null>this.dataCollection["hydra:member"].find((data: BaseData) => data.id == id);
        this.setSelectedData(data);
        return data;
    }

    toStringOrNull(value: any): string | null {
        if (value === null) {
            return null;
        }
        return value + '';
    }

    /**
     * Get a list of entities from the API.
     */
    getList(filter: Filter | null = null): Observable<C> {
        let urlBuilder = new UrlBuilder(this.basePath);
        urlBuilder.addFilter(filter);

        return this.httpClient.get<C>(urlBuilder.url)
            .pipe(
                tap((data: C) => this.setCollectionData(data)),
                catchError(this.handleError<C>('getList', null))
            );
    }

    /**
     * Get a single entity from the API.
     */
    getItem(uuid: string): Observable<T> {
        let urlBuilder = new UrlBuilder(this.basePath);
        return this.httpClient.get<T>(urlBuilder.addUuid(uuid).url)
            .pipe(
                tap((data: T) => this.setSelectedData(data)),
                catchError(this.handleError<T>('getItem', null))
            );
    }

    /**
     * Create a single entity.
     */
    create(data: T): Observable<T> {
        let urlBuilder = new UrlBuilder(this.basePath);
        return this.httpClient.post<T>(urlBuilder.url, data);
    }

    /**
     * Update a single existing entity.
     */
    update(uuid: string, data: T): Observable<T> {
        let urlBuilder = new UrlBuilder(this.basePath);
        return this.httpClient.put<T>(urlBuilder.addUuid(uuid).url, data);
    }

    /**
     * Delete a single existing entity.
     */
    delete(uuid: string): Observable<T> {
        let urlBuilder = new UrlBuilder(this.basePath);
        return this.httpClient.delete<T>(urlBuilder.addUuid(uuid).url);
    }

    /**
     * Get a list of entities from a sub resource of another resource
     * Example: /users/{id}/budgets
     *  - We can get a list of budgtes from the user resource.
     *  getListFromResource('users', 'uuid')
     */
    getListFromResource(resource: string, resourceUuid: string, filter: Filter | null = null): Observable<C> {
        let urlBuilder = new UrlBuilder(this.basePath);
        urlBuilder.addFilter(filter).addPreresource(resource).addPreresourceUuid(resourceUuid);

        return this.httpClient.get<C>(urlBuilder.url)
            .pipe(
                tap((data: C) => this.setCollectionData(data)),
                catchError(this.handleError<C>('getList', null))
            );
    }

    protected setCollectionData(data: C | null): void
    {
        this.dataCollection = data;
        this.dataCollection$.next(data);
    }

    protected setSelectedData(data: T | null): void
    {
        this.selectedData = data;
        this.selectedData$.next(data);
    }

    protected handleError<X>(operation = 'operation', result?: X | null)
    {
        return (error: any): Observable<X> => {
            console.error(operation, error);
            return of(result as X);
          };
    }

}