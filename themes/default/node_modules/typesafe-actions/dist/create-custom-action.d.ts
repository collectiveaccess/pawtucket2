import { TypeConstant, ResolveType, ActionCreatorTypeMetadata } from './type-helpers';
/**
 * @description create custom action-creator using constructor function with injected type argument
 */
export declare function createCustomAction<TType extends TypeConstant, TArgs extends any[] = [], TReturn extends any = {}>(type: TType, createHandler?: (...args: TArgs) => TReturn): ((...args: TArgs) => ResolveType<{
    type: TType;
} & TReturn>) & ActionCreatorTypeMetadata<TType>;
