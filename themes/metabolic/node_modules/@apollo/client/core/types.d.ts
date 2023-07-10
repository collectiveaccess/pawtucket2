import { DocumentNode, GraphQLError } from 'graphql';
import { FetchResult } from '../link/core';
import { ApolloError } from '../errors';
import { QueryInfo } from './QueryInfo';
import { NetworkStatus } from './networkStatus';
import { Resolver } from './LocalState';
export { TypedDocumentNode } from '@graphql-typed-document-node/core';
export declare type QueryListener = (queryInfo: QueryInfo) => void;
export declare type OperationVariables = Record<string, any>;
export declare type PureQueryOptions = {
    query: DocumentNode;
    variables?: {
        [key: string]: any;
    };
    context?: any;
};
export declare type ApolloQueryResult<T> = {
    data: T;
    errors?: ReadonlyArray<GraphQLError>;
    error?: ApolloError;
    loading: boolean;
    networkStatus: NetworkStatus;
    partial?: boolean;
};
export declare type MutationQueryReducer<T> = (previousResult: Record<string, any>, options: {
    mutationResult: FetchResult<T>;
    queryName: string | undefined;
    queryVariables: Record<string, any>;
}) => Record<string, any>;
export declare type MutationQueryReducersMap<T = {
    [key: string]: any;
}> = {
    [queryName: string]: MutationQueryReducer<T>;
};
export interface Resolvers {
    [key: string]: {
        [field: string]: Resolver;
    };
}
//# sourceMappingURL=types.d.ts.map