import './fixPolyfills';
import { DocumentNode } from 'graphql';
import { ApolloCache } from '../core/cache';
import { Cache } from '../core/types/Cache';
import { StoreObject, Reference } from '../../utilities';
import { ApolloReducerConfig, NormalizedCacheObject } from './types';
import { makeVar } from './reactiveVars';
import { PossibleTypesMap, Policies, TypePolicies } from './policies';
export interface InMemoryCacheConfig extends ApolloReducerConfig {
    resultCaching?: boolean;
    possibleTypes?: PossibleTypesMap;
    typePolicies?: TypePolicies;
}
export declare class InMemoryCache extends ApolloCache<NormalizedCacheObject> {
    private data;
    private optimisticData;
    protected config: InMemoryCacheConfig;
    private watches;
    private addTypename;
    private typenameDocumentCache;
    private storeReader;
    private storeWriter;
    readonly policies: Policies;
    readonly makeVar: typeof makeVar;
    constructor(config?: InMemoryCacheConfig);
    restore(data: NormalizedCacheObject): this;
    extract(optimistic?: boolean): NormalizedCacheObject;
    read<T>(options: Cache.ReadOptions): T | null;
    write(options: Cache.WriteOptions): Reference | undefined;
    modify(options: Cache.ModifyOptions): boolean;
    diff<T>(options: Cache.DiffOptions): Cache.DiffResult<T>;
    watch(watch: Cache.WatchOptions): () => void;
    gc(): string[];
    retain(rootId: string, optimistic?: boolean): number;
    release(rootId: string, optimistic?: boolean): number;
    identify(object: StoreObject | Reference): string | undefined;
    evict(options: Cache.EvictOptions): boolean;
    reset(): Promise<void>;
    removeOptimistic(idToRemove: string): void;
    private txCount;
    performTransaction(transaction: (cache: InMemoryCache) => any, optimisticId?: string | null): void;
    transformDocument(document: DocumentNode): DocumentNode;
    protected broadcastWatches(fromOptimisticTransaction?: boolean): void;
    private maybeBroadcastWatch;
    private watchDep;
    private broadcastWatch;
}
//# sourceMappingURL=inMemoryCache.d.ts.map