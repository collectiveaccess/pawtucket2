import { DocumentNode } from 'graphql';
import { ApolloClient } from '../../core';
import { DocumentType } from '../parser';
import { CommonOptions } from '../types/types';
export declare abstract class OperationData<TOptions = any> {
    isMounted: boolean;
    previousOptions: CommonOptions<TOptions>;
    context: any;
    client: ApolloClient<object>;
    private options;
    constructor(options?: CommonOptions<TOptions>, context?: any);
    getOptions(): CommonOptions<TOptions>;
    setOptions(newOptions: CommonOptions<TOptions>, storePrevious?: boolean): void;
    abstract execute(...args: any): any;
    abstract afterExecute(...args: any): void | (() => void);
    abstract cleanup(): void;
    protected unmount(): void;
    protected refreshClient(): {
        client: ApolloClient<object>;
        isNew: boolean;
    };
    protected verifyDocumentType(document: DocumentNode, type: DocumentType): void;
}
//# sourceMappingURL=OperationData.d.ts.map