import { SelectionSetNode, DocumentNode } from 'graphql';
import { FragmentMap, Reference } from '../../utilities';
import { NormalizedCache, ReadMergeModifyContext } from './types';
import { StoreReader } from './readFromStore';
import { InMemoryCache } from './inMemoryCache';
export interface WriteContext extends ReadMergeModifyContext {
    readonly written: {
        [dataId: string]: SelectionSetNode[];
    };
    readonly fragmentMap?: FragmentMap;
    merge<T>(existing: T, incoming: T): T;
}
export interface WriteToStoreOptions {
    query: DocumentNode;
    result: Object;
    dataId?: string;
    store: NormalizedCache;
    variables?: Object;
}
export declare class StoreWriter {
    readonly cache: InMemoryCache;
    private reader?;
    constructor(cache: InMemoryCache, reader?: StoreReader | undefined);
    writeToStore({ query, result, dataId, store, variables, }: WriteToStoreOptions): Reference | undefined;
    private processSelectionSet;
    private processFieldValue;
    private applyMerges;
}
//# sourceMappingURL=writeToStore.d.ts.map