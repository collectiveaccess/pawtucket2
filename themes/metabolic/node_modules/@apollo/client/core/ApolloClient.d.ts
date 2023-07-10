/// <reference types="zen-observable" />
import { ExecutionResult, DocumentNode } from 'graphql';
import { ApolloLink, FetchResult, GraphQLRequest } from '../link/core';
import { ApolloCache, DataProxy } from '../cache';
import { Observable } from '../utilities';
import { UriFunction } from '../link/http';
import { ObservableQuery } from './ObservableQuery';
import { ApolloQueryResult, OperationVariables, Resolvers } from './types';
import { QueryOptions, WatchQueryOptions, MutationOptions, SubscriptionOptions } from './watchQueryOptions';
import { FragmentMatcher } from './LocalState';
export interface DefaultOptions {
    watchQuery?: Partial<WatchQueryOptions<any, any>>;
    query?: Partial<QueryOptions<any, any>>;
    mutate?: Partial<MutationOptions<any, any>>;
}
export declare type ApolloClientOptions<TCacheShape> = {
    uri?: string | UriFunction;
    credentials?: string;
    headers?: Record<string, string>;
    link?: ApolloLink;
    cache: ApolloCache<TCacheShape>;
    ssrForceFetchDelay?: number;
    ssrMode?: boolean;
    connectToDevTools?: boolean;
    queryDeduplication?: boolean;
    defaultOptions?: DefaultOptions;
    assumeImmutableResults?: boolean;
    resolvers?: Resolvers | Resolvers[];
    typeDefs?: string | string[] | DocumentNode | DocumentNode[];
    fragmentMatcher?: FragmentMatcher;
    name?: string;
    version?: string;
};
declare type OptionsUnion<TData, TVariables> = WatchQueryOptions<TVariables, TData> | QueryOptions<TVariables, TData> | MutationOptions<TData, TVariables>;
export declare function mergeOptions<TOptions extends OptionsUnion<any, any>>(defaults: Partial<TOptions>, options: TOptions): TOptions;
export declare class ApolloClient<TCacheShape> implements DataProxy {
    link: ApolloLink;
    cache: ApolloCache<TCacheShape>;
    disableNetworkFetches: boolean;
    version: string;
    queryDeduplication: boolean;
    defaultOptions: DefaultOptions;
    readonly typeDefs: ApolloClientOptions<TCacheShape>['typeDefs'];
    private queryManager;
    private devToolsHookCb;
    private resetStoreCallbacks;
    private clearStoreCallbacks;
    private localState;
    constructor(options: ApolloClientOptions<TCacheShape>);
    stop(): void;
    watchQuery<T = any, TVariables = OperationVariables>(options: WatchQueryOptions<TVariables, T>): ObservableQuery<T, TVariables>;
    query<T = any, TVariables = OperationVariables>(options: QueryOptions<TVariables, T>): Promise<ApolloQueryResult<T>>;
    mutate<T = any, TVariables = OperationVariables>(options: MutationOptions<T, TVariables>): Promise<FetchResult<T>>;
    subscribe<T = any, TVariables = OperationVariables>(options: SubscriptionOptions<TVariables, T>): Observable<FetchResult<T>>;
    readQuery<T = any, TVariables = OperationVariables>(options: DataProxy.Query<TVariables, T>, optimistic?: boolean): T | null;
    readFragment<T = any, TVariables = OperationVariables>(options: DataProxy.Fragment<TVariables, T>, optimistic?: boolean): T | null;
    writeQuery<TData = any, TVariables = OperationVariables>(options: DataProxy.WriteQueryOptions<TData, TVariables>): void;
    writeFragment<TData = any, TVariables = OperationVariables>(options: DataProxy.WriteFragmentOptions<TData, TVariables>): void;
    __actionHookForDevTools(cb: () => any): void;
    __requestRaw(payload: GraphQLRequest): Observable<ExecutionResult>;
    resetStore(): Promise<ApolloQueryResult<any>[] | null>;
    clearStore(): Promise<any[]>;
    onResetStore(cb: () => Promise<any>): () => void;
    onClearStore(cb: () => Promise<any>): () => void;
    reFetchObservableQueries(includeStandby?: boolean): Promise<ApolloQueryResult<any>[]>;
    extract(optimistic?: boolean): TCacheShape;
    restore(serializedState: TCacheShape): ApolloCache<TCacheShape>;
    addResolvers(resolvers: Resolvers | Resolvers[]): void;
    setResolvers(resolvers: Resolvers | Resolvers[]): void;
    getResolvers(): Resolvers;
    setLocalStateFragmentMatcher(fragmentMatcher: FragmentMatcher): void;
    setLink(newLink: ApolloLink): void;
}
export {};
//# sourceMappingURL=ApolloClient.d.ts.map