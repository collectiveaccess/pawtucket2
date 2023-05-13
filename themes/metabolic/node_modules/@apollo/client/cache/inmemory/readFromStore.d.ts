import { SelectionSetNode } from 'graphql';
import { Reference, StoreObject } from '../../utilities';
import { Cache } from '../core/types/Cache';
import { DiffQueryAgainstStoreOptions, ReadMergeModifyContext } from './types';
import { InMemoryCache } from './inMemoryCache';
import { MissingFieldError } from '../core/types/common';
export declare type VariableMap = {
    [name: string]: any;
};
export declare type ExecResult<R = any> = {
    result: R;
    missing?: MissingFieldError[];
};
export interface StoreReaderConfig {
    cache: InMemoryCache;
    addTypename?: boolean;
}
export declare class StoreReader {
    private config;
    constructor(config: StoreReaderConfig);
    diffQueryAgainstStore<T>({ store, query, rootId, variables, returnPartialData, }: DiffQueryAgainstStoreOptions): Cache.DiffResult<T>;
    isFresh(result: Record<string, any>, parent: StoreObject | Reference, selectionSet: SelectionSetNode, context: ReadMergeModifyContext): boolean;
    private executeSelectionSet;
    private execSelectionSetImpl;
    private knownResults;
    private executeSubSelectedArray;
    private execSubSelectedArrayImpl;
}
//# sourceMappingURL=readFromStore.d.ts.map