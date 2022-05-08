import { Injectable } from '@angular/core';
import { BehaviorSubject, from, map, Observable } from 'rxjs';


@Injectable({
    providedIn: 'root'
})
export class BlockUIService {
    private _blockSub$: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
    public get isBlocked$(): Observable<boolean> {
        return this._blockSub$.asObservable();
    }

    public block() {
        this._blockSub$.next(true);
    }

    public unblock() {
        this._blockSub$.next(false);
    }
}
