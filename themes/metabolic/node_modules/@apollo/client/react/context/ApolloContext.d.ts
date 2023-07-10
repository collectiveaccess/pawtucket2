import React from 'react';
import { ApolloClient } from '../../core';
export interface ApolloContextValue {
    client?: ApolloClient<object>;
    renderPromises?: Record<any, any>;
}
export declare function getApolloContext(): React.Context<ApolloContextValue>;
export { getApolloContext as resetApolloContext };
//# sourceMappingURL=ApolloContext.d.ts.map