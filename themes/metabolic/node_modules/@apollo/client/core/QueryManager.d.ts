/// <reference types="zen-observable" />
import { DocumentNode } from 'graphql';
import { ApolloLink, FetchResult } from '../link/core';
import { ApolloCache } from '../cache';
import { Observable, Concast } from '../utilities';
import { QueryOptions, WatchQueryOptions, SubscriptionOptions, MutationOptions, ErrorPolicy } from './watchQueryOptions';
import { ObservableQuery } from './ObservableQuery';
import { NetworkStatus } from './networkStatus';
import { ApolloQueryResult, OperationVariables } from './types';
import { LocalState } from './LocalState';
import { QueryInfo } from './QueryInfo';
interface MutationStoreValue {
    mutation: DocumentNode;
    variables: Record<string, any>;
    loading: boolean;
    error: Error | null;
}
export declare class QueryManager<TStore> {
    cache: ApolloCache<TStore>;
    link: ApolloLink;
    readonly assumeImmutableResults: boolean;
    readonly ssrMode: boolean;
    private queryDeduplication;
    private clientAwareness;
    private localState;
    private onBroadcast?;
    mutationStore?: {
        [mutationId: string]: MutationStoreValue;
    };
    private queries;
    private fetchCancelFns;
    constructor({ cache, link, queryDeduplication, onBroadcast, ssrMode, clientAwareness, localState, assumeImmutableResults, }: {
        cache: ApolloCache<TStore>;
        link: ApolloLink;
        queryDeduplication?: boolean;
        onBroadcast?: () => void;
        ssrMode?: boolean;
        clientAwareness?: Record<string, string>;
        localState?: LocalState<TStore>;
        assumeImmutableResults?: boolean;
    });
    stop(): void;
    private cancelPendingFetches;
    mutate<T>({ mutation, variables, optimisticResponse, updateQueries, refetchQueries, awaitRefetchQueries, update: updateWithProxyFn, errorPolicy, fetchPolicy, context, }: MutationOptions): Promise<FetchResult<T>>;
    markMutationResult<TData>(mutation: {
        mutationId: string;
        result: FetchResult<TData>;
        document: DocumentNode;
        variables?: OperationVariables;
        errorPolicy: ErrorPolicy;
        updateQueries: MutationOptions<TData>["updateQueries"];
        update?: (cache: ApolloCache<TStore>, result: FetchResult<TData>) => void;
    }, cache?: ApolloCache<TStore>): void;
    markMutationOptimistic<TData>(optimisticResponse: any, mutation: {
        mutationId: string;
        document: DocumentNode;
        variables?: OperationVariables;
        errorPolicy: ErrorPolicy;
        updateQueries: MutationOptions<TData>["updateQueries"];
        update?: (cache: ApolloCache<TStore>, result: FetchResult<TData>) => void;
    }): void;
    fetchQuery<TData, TVars>(queryId: string, options: WatchQueryOptions<TVars, TData>, networkStatus?: NetworkStatus): Promise<ApolloQueryResult<TData>>;
    getQueryStore(): Record<string, Pick<QueryInfo, "variables" | "graphQLErrors" | "networkError" | "networkStatus">>;
    resetErrors(queryId: string): void;
    private transformCache;
    transform(document: DocumentNode): Readonly<{
        document: Readonly<DocumentNode>;
        hasClientExports: boolean;
        hasForcedResolvers: boolean;
        clientQuery: Readonly<DocumentNode> | null;
        serverQuery: Readonly<DocumentNode> | null;
        defaultVars: Readonly<Record<string, any>>;
    }>;
    private getVariables;
    watchQuery<T, TVariables = OperationVariables>(options: WatchQueryOptions<TVariables, T>): ObservableQuery<T, TVariables>;
    query<TData, TVars = OperationVariables>(options: QueryOptions<TVars, TData>): Promise<ApolloQueryResult<TData>>;
    private queryIdCounter;
    generateQueryId(): string;
    private requestIdCounter;
    generateRequestId(): number;
    private mutationIdCounter;
    generateMutationId(): string;
    stopQueryInStore(queryId: string): void;
    private stopQueryInStoreNoBroadcast;
    clearStore(): Promise<void>;
    resetStore(): Promise<ApolloQueryResult<any>[]>;
    reFetchObservableQueries(includeStandby?: boolean): Promise<ApolloQueryResult<any>[]>;
    setObservableQuery(observableQuery: ObservableQuery<any, any>): void;
    startGraphQLSubscription<T = any>({ query, fetchPolicy, errorPolicy, variables, context, }: SubscriptionOptions): Observable<FetchResult<T>>;
    stopQuery(queryId: string): void;
    private stopQueryNoBroadcast;
    removeQuery(queryId: string): void;
    broadcastQueries(): void;
    getLocalState(): LocalState<TStore>;
    private inFlightLinkObservables;
    private getObservableFromLink;
    private getResultsFromLink;
    fetchQueryObservable<TData, TVars>(queryId: string, options: WatchQueryOptions<TVars, TData>, networkStatus?: NetworkStatus): Concast<ApolloQueryResult<TData>>;
    private fetchQueryByPolicy;
    private getQuery;
    private prepareContext;
}
export {};
//# sourceMappingURL=QueryManager.d.ts.map