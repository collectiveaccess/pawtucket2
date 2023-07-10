import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { ApolloCache } from '../cache';
import { FetchResult } from '../link/core';
import { MutationQueryReducersMap } from './types';
import { PureQueryOptions, OperationVariables } from './types';
export declare type FetchPolicy = 'cache-first' | 'network-only' | 'cache-only' | 'no-cache' | 'standby';
export declare type WatchQueryFetchPolicy = FetchPolicy | 'cache-and-network';
export declare type ErrorPolicy = 'none' | 'ignore' | 'all';
export interface QueryOptions<TVariables = OperationVariables, TData = any> {
    query: DocumentNode | TypedDocumentNode<TData, TVariables>;
    variables?: TVariables;
    errorPolicy?: ErrorPolicy;
    context?: any;
    fetchPolicy?: FetchPolicy;
    pollInterval?: number;
    notifyOnNetworkStatusChange?: boolean;
    returnPartialData?: boolean;
    partialRefetch?: boolean;
}
export interface WatchQueryOptions<TVariables = OperationVariables, TData = any> extends Omit<QueryOptions<TVariables, TData>, 'fetchPolicy'> {
    fetchPolicy?: WatchQueryFetchPolicy;
    nextFetchPolicy?: WatchQueryFetchPolicy | ((this: WatchQueryOptions<TVariables, TData>, lastFetchPolicy: WatchQueryFetchPolicy) => WatchQueryFetchPolicy);
}
export interface FetchMoreQueryOptions<TVariables, K extends keyof TVariables, TData = any> {
    query?: DocumentNode | TypedDocumentNode<TData, TVariables>;
    variables?: Pick<TVariables, K>;
    context?: any;
}
export declare type UpdateQueryFn<TData = any, TSubscriptionVariables = OperationVariables, TSubscriptionData = TData> = (previousQueryResult: TData, options: {
    subscriptionData: {
        data: TSubscriptionData;
    };
    variables?: TSubscriptionVariables;
}) => TData;
export declare type SubscribeToMoreOptions<TData = any, TSubscriptionVariables = OperationVariables, TSubscriptionData = TData> = {
    document: DocumentNode | TypedDocumentNode<TSubscriptionData, TSubscriptionVariables>;
    variables?: TSubscriptionVariables;
    updateQuery?: UpdateQueryFn<TData, TSubscriptionVariables, TSubscriptionData>;
    onError?: (error: Error) => void;
    context?: Record<string, any>;
};
export interface SubscriptionOptions<TVariables = OperationVariables, TData = any> {
    query: DocumentNode | TypedDocumentNode<TData, TVariables>;
    variables?: TVariables;
    fetchPolicy?: FetchPolicy;
    errorPolicy?: ErrorPolicy;
    context?: Record<string, any>;
}
export declare type RefetchQueryDescription = Array<string | PureQueryOptions>;
export interface MutationBaseOptions<T = {
    [key: string]: any;
}, TVariables = OperationVariables> {
    optimisticResponse?: T | ((vars: TVariables) => T);
    updateQueries?: MutationQueryReducersMap<T>;
    refetchQueries?: ((result: FetchResult<T>) => RefetchQueryDescription) | RefetchQueryDescription;
    awaitRefetchQueries?: boolean;
    update?: MutationUpdaterFn<T>;
    errorPolicy?: ErrorPolicy;
    variables?: TVariables;
}
export interface MutationOptions<T = {
    [key: string]: any;
}, TVariables = OperationVariables> extends MutationBaseOptions<T, TVariables> {
    mutation: DocumentNode | TypedDocumentNode<T, TVariables>;
    context?: any;
    fetchPolicy?: Extract<FetchPolicy, 'no-cache'>;
}
export declare type MutationUpdaterFn<T = {
    [key: string]: any;
}> = (cache: ApolloCache<T>, mutationResult: FetchResult<T>) => void;
//# sourceMappingURL=watchQueryOptions.d.ts.map