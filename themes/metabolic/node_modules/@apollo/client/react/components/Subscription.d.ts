/// <reference types="react" />
import PropTypes from 'prop-types';
import { OperationVariables } from '../../core';
import { SubscriptionComponentOptions } from './types';
export declare function Subscription<TData = any, TVariables = OperationVariables>(props: SubscriptionComponentOptions<TData, TVariables>): JSX.Element | null;
export declare namespace Subscription {
    var propTypes: {
        subscription: PropTypes.Validator<object>;
        variables: PropTypes.Requireable<object>;
        children: PropTypes.Requireable<(...args: any[]) => any>;
        onSubscriptionData: PropTypes.Requireable<(...args: any[]) => any>;
        onSubscriptionComplete: PropTypes.Requireable<(...args: any[]) => any>;
        shouldResubscribe: PropTypes.Requireable<boolean | ((...args: any[]) => any)>;
    };
}
export interface Subscription<TData, TVariables> {
    propTypes: PropTypes.InferProps<SubscriptionComponentOptions<TData, TVariables>>;
}
//# sourceMappingURL=Subscription.d.ts.map