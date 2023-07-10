'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

function _interopDefault (ex) { return (ex && (typeof ex === 'object') && 'default' in ex) ? ex['default'] : ex; }

var tslib = require('tslib');
var PropTypes = _interopDefault(require('prop-types'));
var hooks = require('../hooks');

function Query(props) {
    var children = props.children, query = props.query, options = tslib.__rest(props, ["children", "query"]);
    var result = hooks.useQuery(query, options);
    return children && result ? children(result) : null;
}
Query.propTypes = {
    client: PropTypes.object,
    children: PropTypes.func.isRequired,
    fetchPolicy: PropTypes.string,
    notifyOnNetworkStatusChange: PropTypes.bool,
    onCompleted: PropTypes.func,
    onError: PropTypes.func,
    pollInterval: PropTypes.number,
    query: PropTypes.object.isRequired,
    variables: PropTypes.object,
    ssr: PropTypes.bool,
    partialRefetch: PropTypes.bool,
    returnPartialData: PropTypes.bool
};

function Mutation(props) {
    var _a = hooks.useMutation(props.mutation, props), runMutation = _a[0], result = _a[1];
    return props.children ? props.children(runMutation, result) : null;
}
Mutation.propTypes = {
    mutation: PropTypes.object.isRequired,
    variables: PropTypes.object,
    optimisticResponse: PropTypes.oneOfType([PropTypes.object, PropTypes.func]),
    refetchQueries: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.oneOfType([PropTypes.string, PropTypes.object])),
        PropTypes.func
    ]),
    awaitRefetchQueries: PropTypes.bool,
    update: PropTypes.func,
    children: PropTypes.func.isRequired,
    onCompleted: PropTypes.func,
    onError: PropTypes.func,
    fetchPolicy: PropTypes.string
};

function Subscription(props) {
    var result = hooks.useSubscription(props.subscription, props);
    return props.children && result ? props.children(result) : null;
}
Subscription.propTypes = {
    subscription: PropTypes.object.isRequired,
    variables: PropTypes.object,
    children: PropTypes.func,
    onSubscriptionData: PropTypes.func,
    onSubscriptionComplete: PropTypes.func,
    shouldResubscribe: PropTypes.oneOfType([PropTypes.func, PropTypes.bool])
};

exports.Mutation = Mutation;
exports.Query = Query;
exports.Subscription = Subscription;
//# sourceMappingURL=components.cjs.js.map
