import { ObservableQuery } from '../../core/ObservableQuery';
import { ApolloQueryResult } from '../../core/types';
import { ObservableSubscription } from '../../utilities/observables/Observable';
export default function subscribeAndCount(reject: (reason: any) => any, observable: ObservableQuery<any>, cb: (handleCount: number, result: ApolloQueryResult<any>) => any): ObservableSubscription;
//# sourceMappingURL=subscribeAndCount.d.ts.map