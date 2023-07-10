/// <reference types="zen-observable" />
import { DocumentNode, GraphQLError } from 'graphql';
import { Cache, ApolloCache } from '../cache';
import { WatchQueryOptions, ErrorPolicy } from './watchQueryOptions';
import { ObservableQuery } from './ObservableQuery';
import { QueryListener } from './types';
import { FetchResult } from '../link/core';
import { NetworkStatus } from './networkStatus';
import { ApolloError } from '../errors';
export declare type QueryStoreValue = Pick<QueryInfo, "variables" | "networkStatus" | "networkError" | "graphQLErrors">;
export declare class QueryInfo {
    private cache;
    listeners: Set<QueryListener>;
    document: DocumentNode | null;
    lastRequestId: number;
    subscriptions: Set<ZenObservable.Subscription>;
    variables?: Record<string, any>;
    networkStatus?: NetworkStatus;
    networkError?: Error | null;
    graphQLErrors?: ReadonlyArray<GraphQLError>;
    stopped: boolean;
    constructor(cache: ApolloCache<any>);
    init(query: {
        document: DocumentNode;
        variables: Record<string, any> | undefined;
        networkStatus?: NetworkStatus;
        observableQuery?: ObservableQuery<any>;
        lastRequestId?: number;
    }): this;
    private dirty;
    private notifyTimeout?;
    private diff;
    reset(): void;
    getDiff(variables?: Record<string, any> | undefined): Cache.DiffResult<any>;
    setDiff(diff: Cache.DiffResult<any> | null): void;
    readonly observableQuery: ObservableQuery<any> | null;
    private oqListener?;
    setObservableQuery(oq: ObservableQuery<any> | null): void;
    notify(): void;
    private shouldNotify;
    stop(): void;
    private cancel;
    private lastWatch?;
    private updateWatch;
    private lastWrite?;
    private shouldWrite;
    markResult<T>(result: FetchResult<T>, options: Pick<WatchQueryOptions, "variables" | "fetchPolicy" | "errorPolicy">, allowCacheWrite: boolean): void;
    markReady(): NetworkStatus;
    markError(error: ApolloError): ApolloError;
}
export declare function shouldWriteResult<T>(result: FetchResult<T>, errorPolicy?: ErrorPolicy): boolean;
//# sourceMappingURL=QueryInfo.d.ts.map