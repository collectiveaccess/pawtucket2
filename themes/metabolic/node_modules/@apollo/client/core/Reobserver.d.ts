import { WatchQueryOptions } from './watchQueryOptions';
import { NetworkStatus } from './networkStatus';
import { ApolloQueryResult } from './types';
import { Observer, Concast } from '../utilities';
export declare class Reobserver<TData, TVars> {
    private observer;
    private options;
    private fetch;
    private shouldFetch;
    constructor(observer: Observer<ApolloQueryResult<TData>>, options: WatchQueryOptions<TVars, TData>, fetch: (options: WatchQueryOptions<TVars, TData>, newNetworkStatus?: NetworkStatus) => Concast<ApolloQueryResult<TData>>, shouldFetch: false | (() => boolean));
    private concast?;
    reobserve(newOptions?: Partial<WatchQueryOptions<TVars, TData>>, newNetworkStatus?: NetworkStatus): Promise<ApolloQueryResult<TData>>;
    updateOptions(newOptions: Partial<WatchQueryOptions<TVars, TData>>): this;
    stop(): void;
    private pollingInfo?;
    private updatePolling;
}
//# sourceMappingURL=Reobserver.d.ts.map