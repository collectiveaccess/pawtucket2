import { TypeConstant, ActionCreator, ActionCreatorTypeMetadata } from './type-helpers';
/**
 * @description get the "type literal" of a given action-creator
 */
export declare function getType<TType extends TypeConstant>(actionCreator: ActionCreator<TType> & ActionCreatorTypeMetadata<TType>): TType;
