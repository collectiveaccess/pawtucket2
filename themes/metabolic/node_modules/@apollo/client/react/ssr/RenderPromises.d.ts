/// <reference types="react" />
import { ObservableQuery } from '../../core';
import { QueryDataOptions } from '../types/types';
import { QueryData } from '../data/QueryData';
export declare class RenderPromises {
    private queryPromises;
    private queryInfoTrie;
    clear(): void;
    registerSSRObservable<TData, TVariables>(observable: ObservableQuery<any, TVariables>, props: QueryDataOptions<TData, TVariables>): void;
    getSSRObservable<TData, TVariables>(props: QueryDataOptions<TData, TVariables>): ObservableQuery<any, any> | null;
    addQueryPromise<TData, TVariables>(queryInstance: QueryData<TData, TVariables>, finish: () => React.ReactNode): React.ReactNode;
    hasPromises(): boolean;
    consumeAndAwaitPromises(): Promise<any[]>;
    private lookupQueryInfo;
}
//# sourceMappingURL=RenderPromises.d.ts.map