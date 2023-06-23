/// <reference types="zen-observable" />
import { NetworkStatus } from './networkStatus';
import { Observable } from '../utilities';
import { ApolloError } from '../errors';
import { QueryManager } from './QueryManager';
import { ApolloQueryResult, OperationVariables } from './types';
import { WatchQueryOptions, FetchMoreQueryOptions, SubscribeToMoreOptions } from './watchQueryOptions';
import { QueryInfo } from './QueryInfo';
export interface FetchMoreOptions<TData = any, TVariables = OperationVariables> {
    updateQuery?: (previousQueryResult: TData, options: {
        fetchMoreResult?: TData;
        variables?: TVariables;
    }) => TData;
}
export interface UpdateQueryOptions<TVariables> {
    variables?: TVariables;
}
export declare class ObservableQuery<TData = any, TVariables = OperationVariables> extends Observable<ApolloQueryResult<TData>> {
    readonly options: WatchQueryOptions<TVariables, TData>;
    readonly queryId: string;
    readonly queryName?: string;
    get variables(): TVariables | undefined;
    private isTornDown;
    private queryManager;
    private observers;
    private subscriptions;
    private lastResult;
    private lastResultSnapshot;
    private lastError;
    private queryInfo;
    constructor({ queryManager, queryInfo, options, }: {
        queryManager: QueryManager<any>;
        queryInfo: QueryInfo;
        options: WatchQueryOptions<TVariables, TData>;
    });
    result(): Promise<ApolloQueryResult<TData>>;
    getCurrentResult(saveAsLastResult?: boolean): ApolloQueryResult<TData>;
    isDifferentFromLastResult(newResult: ApolloQueryResult<TData>): boolean;
    getLastResult(): ApolloQueryResult<TData>;
    getLastError(): ApolloError;
    resetLastResults(): void;
    resetQueryStoreErrors(): void;
    refetch(variables?: Partial<TVariables>): Promise<ApolloQueryResult<TData>>;
    fetchMore<K extends keyof TVariables>(fetchMoreOptions: FetchMoreQueryOptions<TVariables, K, TData> & FetchMoreOptions<TData, TVariables>): Promise<ApolloQueryResult<TData>>;
    subscribeToMore<TSubscriptionData = TData, TSubscriptionVariables = TVariables>(options: SubscribeToMoreOptions<TData, TSubscriptionVariables, TSubscriptionData>): () => void;
    setOptions(newOptions: Partial<WatchQueryOptions<TVariables, TData>>): Promise<ApolloQueryResult<TData>>;
    setVariables(variables: TVariables): Promise<ApolloQueryResult<TData> | void>;
    updateQuery<TVars = TVariables>(mapFn: (previousQueryResult: TData, options: Pick<WatchQueryOptions<TVars, TData>, "variables">) => TData): void;
    startPolling(pollInterval: number): void;
    stopPolling(): void;
    private updateLastResult;
    private onSubscribe;
    private reobserver?;
    private getReobserver;
    private newReobserver;
    reobserve(newOptions?: Partial<WatchQueryOptions<TVariables, TData>>, newNetworkStatus?: NetworkStatus): Promise<ApolloQueryResult<TData>>;
    private observe;
    private observer;
    hasObservers(): boolean;
    private tearDownQuery;
}
//# sourceMappingURL=ObservableQuery.d.ts.map