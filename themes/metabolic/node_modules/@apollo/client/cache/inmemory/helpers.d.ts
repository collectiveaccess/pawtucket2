import { SelectionSetNode } from 'graphql';
import { NormalizedCache } from './types';
import { Reference, StoreValue, StoreObject, DeepMerger } from '../../utilities';
export declare const hasOwn: (v: string | number | symbol) => boolean;
export declare function getTypenameFromStoreObject(store: NormalizedCache, objectOrReference: StoreObject | Reference): string | undefined;
export declare const TypeOrFieldNameRegExp: RegExp;
export declare function fieldNameFromStoreName(storeFieldName: string): string;
export declare function selectionSetMatchesResult(selectionSet: SelectionSetNode, result: Record<string, any>, variables?: Record<string, any>): boolean;
export declare function storeValueIsStoreObject(value: StoreValue): value is StoreObject;
export declare function makeProcessedFieldsMerger(): DeepMerger<any[]>;
//# sourceMappingURL=helpers.d.ts.map