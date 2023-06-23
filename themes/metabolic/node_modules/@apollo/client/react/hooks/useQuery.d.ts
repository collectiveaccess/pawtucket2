import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { QueryHookOptions, QueryResult } from '../types/types';
import { OperationVariables } from '../../core';
export declare function useQuery<TData = any, TVariables = OperationVariables>(query: DocumentNode | TypedDocumentNode<TData, TVariables>, options?: QueryHookOptions<TData, TVariables>): QueryResult<TData, TVariables>;
//# sourceMappingURL=useQuery.d.ts.map