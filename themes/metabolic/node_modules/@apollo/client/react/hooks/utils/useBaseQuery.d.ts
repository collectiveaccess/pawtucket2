import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { QueryHookOptions, QueryTuple, QueryResult } from '../../types/types';
import { OperationVariables } from '../../../core';
export declare function useBaseQuery<TData = any, TVariables = OperationVariables>(query: DocumentNode | TypedDocumentNode<TData, TVariables>, options?: QueryHookOptions<TData, TVariables>, lazy?: boolean): QueryTuple<TData, TVariables> | QueryResult<TData, TVariables>;
//# sourceMappingURL=useBaseQuery.d.ts.map