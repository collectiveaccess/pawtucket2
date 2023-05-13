import { OperationData } from './OperationData';
import { SubscriptionDataOptions, SubscriptionResult } from '../types/types';
export declare class SubscriptionData<TData = any, TVariables = any> extends OperationData<SubscriptionDataOptions<TData, TVariables>> {
    private setResult;
    private currentObservable;
    constructor({ options, context, setResult }: {
        options: SubscriptionDataOptions<TData, TVariables>;
        context: any;
        setResult: any;
    });
    execute(result: SubscriptionResult<TData>): {
        variables: TVariables | undefined;
        loading: boolean;
        data?: TData | undefined;
        error?: import("../..").ApolloError | undefined;
    };
    afterExecute(): void;
    cleanup(): void;
    private initialize;
    private startSubscription;
    private getLoadingResult;
    private updateResult;
    private updateCurrentData;
    private updateError;
    private completeSubscription;
    private endSubscription;
}
//# sourceMappingURL=SubscriptionData.d.ts.map