/**
 * PUBLIC API
 */
/**
 * @desc Interface for internal types augmentation
 * @example ```
 * declare module 'typesafe-actions' {
 *   export type RootAction = ActionType<typeof import('./root-action').default>;
 *   export interface Types {
 *     RootAction: RootAction;
 *   }
 * } ```
 */
export interface Types {
}
/**
 * @desc Type representing Type Constant
 */
export declare type TypeConstant = string;
/**
 * @desc Type representing Generic Action
 */
export declare type Action<TType extends TypeConstant = TypeConstant> = {
    type: TType;
};
/**
 * @desc Type representing Generic ActionCreator
 */
export declare type ActionCreator<TType extends TypeConstant = TypeConstant> = (...args: any[]) => Action<TType>;
/**
 * @desc Type representing Generic Reducer
 */
export declare type Reducer<TState, TAction extends Action> = (state: TState | undefined, action: TAction) => TState;
/**
 * @desc Action without Payload
 */
export declare type EmptyAction<TType extends TypeConstant> = {
    type: TType;
};
/**
 * @desc Action with only Payload
 */
export declare type PayloadAction<TType extends TypeConstant, TPayload> = {
    type: TType;
    payload: TPayload;
};
/**
 * @desc Action with both Payload and Meta
 */
export declare type PayloadMetaAction<TType extends TypeConstant, TPayload, TMeta> = {
    type: TType;
    payload: TPayload;
    meta: TMeta;
};
/**
 * @desc Action Creator producing EmptyAction
 */
export declare type EmptyActionCreator<TType extends TypeConstant> = () => EmptyAction<TType>;
/**
 * @desc Action Creator producing PayloadAction
 */
export declare type PayloadActionCreator<TType extends TypeConstant, TPayload> = (payload: TPayload) => PayloadAction<TType, TPayload>;
/**
 * @desc Action Creator producing PayloadMetaAction
 */
export declare type PayloadMetaActionCreator<TType extends TypeConstant, TPayload, TMeta> = (payload: TPayload, meta: TMeta) => PayloadMetaAction<TType, TPayload, TMeta>;
/**
 * @desc Type representing type getter on Action Creator instance
 */
export interface ActionCreatorTypeMetadata<TType extends TypeConstant> {
    getType?: () => TType;
}
/**
 * @desc Infers Action union-type from action-creator map object
 */
export declare type ActionType<TActionCreatorOrMap extends any> = TActionCreatorOrMap extends ActionCreator<TypeConstant> ? ReturnType<TActionCreatorOrMap> : TActionCreatorOrMap extends Record<any, any> ? {
    [K in keyof TActionCreatorOrMap]: ActionType<TActionCreatorOrMap[K]>;
}[keyof TActionCreatorOrMap] : TActionCreatorOrMap extends infer R ? never : never;
/**
 * @desc Infers State object from reducer map object
 */
export declare type StateType<TReducerOrMap extends any> = TReducerOrMap extends Reducer<any, any> ? ReturnType<TReducerOrMap> : TReducerOrMap extends Record<any, any> ? {
    [K in keyof TReducerOrMap]: StateType<TReducerOrMap[K]>;
} : never;
/**
 * @desc todo
 */
export declare type ActionBuilder<TType extends TypeConstant, TPayload extends any = undefined, TMeta extends any = undefined> = [TMeta] extends [undefined] ? [TPayload] extends [undefined] ? unknown extends TPayload ? PayloadAction<TType, TPayload> : unknown extends TMeta ? PayloadMetaAction<TType, TPayload, TMeta> : EmptyAction<TType> : PayloadAction<TType, TPayload> : PayloadMetaAction<TType, TPayload, TMeta>;
/**
 * @desc todo
 */
export declare type ActionCreatorBuilder<TType extends TypeConstant, TPayload extends any = undefined, TMeta extends any = undefined> = [TMeta] extends [undefined] ? [TPayload] extends [undefined] ? unknown extends TPayload ? PayloadActionCreator<TType, TPayload> : unknown extends TMeta ? PayloadMetaActionCreator<TType, TPayload, TMeta> : EmptyActionCreator<TType> : PayloadActionCreator<TType, TPayload> : PayloadMetaActionCreator<TType, TPayload, TMeta>;
/**
 * @desc todo
 */
export declare type AsyncActionCreatorBuilder<TRequest extends [TType1, TPayload1] | [TType1, [TPayload1, TMeta1]] | [TType1, TArgs1, TPayload1] | [TType1, TArgs1, [TPayload1, TMeta1]], TSuccess extends [TType2, TPayload2] | [TType2, [TPayload2, TMeta2]] | [TType2, TArgs2, TPayload2] | [TType2, TArgs2, [TPayload2, TMeta2]], TFailure extends [TType3, TPayload3] | [TType3, [TPayload3, TMeta3]] | [TType3, TArgs3, TPayload3] | [TType3, TArgs3, [TPayload3, TMeta3]], TCancel extends [TType4, TPayload4] | [TType4, [TPayload4, TMeta4]] | [TType4, TArgs4, TPayload4] | [TType4, TArgs4, [TPayload4, TMeta4]] = never, TType1 extends TypeConstant = TRequest[0], TPayload1 = TRequest extends [TType1, any, [any, any]] ? TRequest[2][0] : TRequest extends [TType1, any, any] ? TRequest[2] : TRequest extends [TType1, [any, any]] ? TRequest[1][0] : TRequest[1], TMeta1 = TRequest extends [TType1, any, [any, any]] ? TRequest[2][1] : TRequest extends [TType1, [any, any]] ? TRequest[1][1] : never, TArgs1 extends any[] = TRequest extends [TType1, any, any] ? TRequest[1] : never, TType2 extends TypeConstant = TSuccess[0], TPayload2 = TSuccess extends [TType2, any, [any, any]] ? TSuccess[2][0] : TSuccess extends [TType2, any, any] ? TSuccess[2] : TSuccess extends [TType2, [any, any]] ? TSuccess[1][0] : TSuccess[1], TMeta2 = TSuccess extends [TType2, any, [any, any]] ? TSuccess[2][1] : TSuccess extends [TType2, [any, any]] ? TSuccess[1][1] : never, TArgs2 extends any[] = TSuccess extends [TType2, any, any] ? TSuccess[1] : never, TType3 extends TypeConstant = TFailure[0], TPayload3 = TFailure extends [TType3, any, [any, any]] ? TFailure[2][0] : TFailure extends [TType3, any, any] ? TFailure[2] : TFailure extends [TType3, [any, any]] ? TFailure[1][0] : TFailure[1], TMeta3 = TFailure extends [TType3, any, [any, any]] ? TFailure[2][1] : TFailure extends [TType3, [any, any]] ? TFailure[1][1] : never, TArgs3 extends any[] = TFailure extends [TType3, any, any] ? TFailure[1] : never, TType4 extends TypeConstant = TCancel[0], TPayload4 = TCancel extends [TType4, any, [any, any]] ? TCancel[2][0] : TCancel extends [TType4, any, any] ? TCancel[2] : TCancel extends [TType4, [any, any]] ? TCancel[1][0] : TCancel[1], TMeta4 = TCancel extends [TType4, any, [any, any]] ? TCancel[2][1] : TCancel extends [TType4, [any, any]] ? TCancel[1][1] : never, TArgs4 extends any[] = TCancel extends [TType4, any, any] ? TCancel[1] : never> = [TCancel] extends [never] ? {
    request: [TArgs1] extends [never] ? ActionCreatorBuilder<TType1, TPayload1, TMeta1> : (...args: TArgs1) => ActionBuilder<TType1, TPayload1, TMeta1>;
    success: [TArgs2] extends [never] ? ActionCreatorBuilder<TType2, TPayload2, TMeta2> : (...args: TArgs2) => ActionBuilder<TType2, TPayload2, TMeta2>;
    failure: [TArgs3] extends [never] ? ActionCreatorBuilder<TType3, TPayload3, TMeta3> : (...args: TArgs3) => ActionBuilder<TType3, TPayload3, TMeta3>;
} : {
    request: [TArgs1] extends [never] ? ActionCreatorBuilder<TType1, TPayload1, TMeta1> : (...args: TArgs1) => ActionBuilder<TType1, TPayload1, TMeta1>;
    success: [TArgs2] extends [never] ? ActionCreatorBuilder<TType2, TPayload2, TMeta2> : (...args: TArgs2) => ActionBuilder<TType2, TPayload2, TMeta2>;
    failure: [TArgs3] extends [never] ? ActionCreatorBuilder<TType3, TPayload3, TMeta3> : (...args: TArgs3) => ActionBuilder<TType3, TPayload3, TMeta3>;
    cancel: [TArgs4] extends [never] ? ActionCreatorBuilder<TType4, TPayload4, TMeta4> : (...args: TArgs4) => ActionBuilder<TType4, TPayload4, TMeta4>;
};
/**
 * INTERNAL API
 */
/** @private */
export declare type ResolveType<T extends any> = T extends (...args: any[]) => {} ? T : {
    [K in keyof T]: T[K];
};
/** @private */
export declare type ExcludeNever<T extends object> = Pick<T, {
    [Key in keyof T]: T[Key] extends never ? never : Key;
}[keyof T]>;
