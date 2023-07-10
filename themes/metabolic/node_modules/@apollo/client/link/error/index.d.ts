/// <reference types="zen-observable" />
import { GraphQLError, ExecutionResult } from 'graphql';
import { ApolloLink, Operation, FetchResult, NextLink } from '../core';
import { Observable } from '../../utilities';
import { ServerError } from '../utils';
import { ServerParseError } from '../http';
export interface ErrorResponse {
    graphQLErrors?: ReadonlyArray<GraphQLError>;
    networkError?: Error | ServerError | ServerParseError;
    response?: ExecutionResult;
    operation: Operation;
    forward: NextLink;
}
export declare namespace ErrorLink {
    interface ErrorHandler {
        (error: ErrorResponse): Observable<FetchResult> | void;
    }
}
export import ErrorHandler = ErrorLink.ErrorHandler;
export declare function onError(errorHandler: ErrorHandler): ApolloLink;
export declare class ErrorLink extends ApolloLink {
    private link;
    constructor(errorHandler: ErrorLink.ErrorHandler);
    request(operation: Operation, forward: NextLink): Observable<FetchResult> | null;
}
//# sourceMappingURL=index.d.ts.map