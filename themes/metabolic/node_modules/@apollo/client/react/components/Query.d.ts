/// <reference types="react" />
import PropTypes from 'prop-types';
import { OperationVariables } from '../../core';
import { QueryComponentOptions } from './types';
export declare function Query<TData = any, TVariables = OperationVariables>(props: QueryComponentOptions<TData, TVariables>): JSX.Element | null;
export declare namespace Query {
    var propTypes: {
        client: PropTypes.Requireable<object>;
        children: PropTypes.Validator<(...args: any[]) => any>;
        fetchPolicy: PropTypes.Requireable<string>;
        notifyOnNetworkStatusChange: PropTypes.Requireable<boolean>;
        onCompleted: PropTypes.Requireable<(...args: any[]) => any>;
        onError: PropTypes.Requireable<(...args: any[]) => any>;
        pollInterval: PropTypes.Requireable<number>;
        query: PropTypes.Validator<object>;
        variables: PropTypes.Requireable<object>;
        ssr: PropTypes.Requireable<boolean>;
        partialRefetch: PropTypes.Requireable<boolean>;
        returnPartialData: PropTypes.Requireable<boolean>;
    };
}
export interface Query<TData, TVariables> {
    propTypes: PropTypes.InferProps<QueryComponentOptions<TData, TVariables>>;
}
//# sourceMappingURL=Query.d.ts.map