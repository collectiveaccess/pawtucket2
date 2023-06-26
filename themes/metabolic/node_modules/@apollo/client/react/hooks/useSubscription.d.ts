import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { SubscriptionHookOptions } from '../types/types';
import { OperationVariables } from '../../core';
export declare function useSubscription<TData = any, TVariables = OperationVariables>(subscription: DocumentNode | TypedDocumentNode<TData, TVariables>, options?: SubscriptionHookOptions<TData, TVariables>): {
    variables: TVariables | undefined;
    loading: boolean;
    data?: TData | undefined;
    error?: import("../../errors").ApolloError | undefined;
};
//# sourceMappingURL=useSubscription.d.ts.map