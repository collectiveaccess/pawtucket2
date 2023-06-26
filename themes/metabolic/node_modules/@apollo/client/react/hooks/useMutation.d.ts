import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { MutationHookOptions, MutationTuple } from '../types/types';
import { OperationVariables } from '../../core';
export declare function useMutation<TData = any, TVariables = OperationVariables>(mutation: DocumentNode | TypedDocumentNode<TData, TVariables>, options?: MutationHookOptions<TData, TVariables>): MutationTuple<TData, TVariables>;
//# sourceMappingURL=useMutation.d.ts.map