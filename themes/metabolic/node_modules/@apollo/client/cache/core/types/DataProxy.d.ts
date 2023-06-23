import { DocumentNode } from 'graphql';
import { TypedDocumentNode } from '@graphql-typed-document-node/core';
import { MissingFieldError } from './common';
export declare namespace DataProxy {
    interface Query<TVariables, TData> {
        query: DocumentNode | TypedDocumentNode<TData, TVariables>;
        variables?: TVariables;
        id?: string;
    }
    interface Fragment<TVariables, TData> {
        id?: string;
        fragment: DocumentNode | TypedDocumentNode<TData, TVariables>;
        fragmentName?: string;
        variables?: TVariables;
    }
    interface ReadQueryOptions<TData, TVariables> extends Query<TVariables, TData> {
        returnPartialData?: boolean;
        optimistic?: boolean;
    }
    interface ReadFragmentOptions<TData, TVariables> extends Fragment<TVariables, TData> {
        returnPartialData?: boolean;
        optimistic?: boolean;
    }
    interface WriteQueryOptions<TData, TVariables> extends Query<TVariables, TData> {
        data: TData;
        broadcast?: boolean;
    }
    interface WriteFragmentOptions<TData, TVariables> extends Fragment<TVariables, TData> {
        data: TData;
        broadcast?: boolean;
    }
    type DiffResult<T> = {
        result?: T;
        complete?: boolean;
        missing?: MissingFieldError[];
        fromOptimisticTransaction?: boolean;
    };
}
export interface DataProxy {
    readQuery<QueryType, TVariables = any>(options: DataProxy.ReadQueryOptions<QueryType, TVariables>, optimistic?: boolean): QueryType | null;
    readFragment<FragmentType, TVariables = any>(options: DataProxy.ReadFragmentOptions<FragmentType, TVariables>, optimistic?: boolean): FragmentType | null;
    writeQuery<TData = any, TVariables = any>(options: DataProxy.WriteQueryOptions<TData, TVariables>): void;
    writeFragment<TData = any, TVariables = any>(options: DataProxy.WriteFragmentOptions<TData, TVariables>): void;
}
//# sourceMappingURL=DataProxy.d.ts.map