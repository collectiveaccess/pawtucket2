import { DocumentNode } from 'graphql';
import { StoreObject, Reference } from '../../utilities';
import { DataProxy } from './types/DataProxy';
import { Cache } from './types/Cache';
export declare type Transaction<T> = (c: ApolloCache<T>) => void;
export declare abstract class ApolloCache<TSerialized> implements DataProxy {
    abstract read<T, TVariables = any>(query: Cache.ReadOptions<TVariables, T>): T | null;
    abstract write<TResult = any, TVariables = any>(write: Cache.WriteOptions<TResult, TVariables>): Reference | undefined;
    abstract diff<T>(query: Cache.DiffOptions): Cache.DiffResult<T>;
    abstract watch(watch: Cache.WatchOptions): () => void;
    abstract reset(): Promise<void>;
    abstract evict(options: Cache.EvictOptions): boolean;
    abstract restore(serializedState: TSerialized): ApolloCache<TSerialized>;
    abstract extract(optimistic?: boolean): TSerialized;
    abstract removeOptimistic(id: string): void;
    abstract performTransaction(transaction: Transaction<TSerialized>, optimisticId?: string | null): void;
    recordOptimisticTransaction(transaction: Transaction<TSerialized>, optimisticId: string): void;
    transformDocument(document: DocumentNode): DocumentNode;
    identify(object: StoreObject | Reference): string | undefined;
    gc(): string[];
    modify(options: Cache.ModifyOptions): boolean;
    transformForLink(document: DocumentNode): DocumentNode;
    readQuery<QueryType, TVariables = any>(options: Cache.ReadQueryOptions<QueryType, TVariables>, optimistic?: boolean): QueryType | null;
    private getFragmentDoc;
    readFragment<FragmentType, TVariables = any>(options: Cache.ReadFragmentOptions<FragmentType, TVariables>, optimistic?: boolean): FragmentType | null;
    writeQuery<TData = any, TVariables = any>(options: Cache.WriteQueryOptions<TData, TVariables>): Reference | undefined;
    writeFragment<TData = any, TVariables = any>(options: Cache.WriteFragmentOptions<TData, TVariables>): Reference | undefined;
}
//# sourceMappingURL=cache.d.ts.map