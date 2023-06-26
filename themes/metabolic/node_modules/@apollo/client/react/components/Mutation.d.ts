/// <reference types="react" />
import PropTypes from 'prop-types';
import { OperationVariables } from '../../core';
import { MutationComponentOptions } from './types';
export declare function Mutation<TData = any, TVariables = OperationVariables>(props: MutationComponentOptions<TData, TVariables>): JSX.Element | null;
export declare namespace Mutation {
    var propTypes: {
        mutation: PropTypes.Validator<object>;
        variables: PropTypes.Requireable<object>;
        optimisticResponse: PropTypes.Requireable<object>;
        refetchQueries: PropTypes.Requireable<((...args: any[]) => any) | (string | object | null | undefined)[]>;
        awaitRefetchQueries: PropTypes.Requireable<boolean>;
        update: PropTypes.Requireable<(...args: any[]) => any>;
        children: PropTypes.Validator<(...args: any[]) => any>;
        onCompleted: PropTypes.Requireable<(...args: any[]) => any>;
        onError: PropTypes.Requireable<(...args: any[]) => any>;
        fetchPolicy: PropTypes.Requireable<string>;
    };
}
export interface Mutation<TData, TVariables> {
    propTypes: PropTypes.InferProps<MutationComponentOptions<TData, TVariables>>;
}
//# sourceMappingURL=Mutation.d.ts.map