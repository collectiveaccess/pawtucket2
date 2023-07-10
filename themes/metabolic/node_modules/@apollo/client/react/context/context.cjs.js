'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

function _interopDefault (ex) { return (ex && (typeof ex === 'object') && 'default' in ex) ? ex['default'] : ex; }

var React = _interopDefault(require('react'));
var tsInvariant = require('ts-invariant');
var utilities = require('../../utilities');

var cache = new (utilities.canUseWeakMap ? WeakMap : Map)();
function getApolloContext() {
    var context = cache.get(React.createContext);
    if (!context) {
        context = React.createContext({});
        context.displayName = 'ApolloContext';
        cache.set(React.createContext, context);
    }
    return context;
}

var ApolloConsumer = function (props) {
    var ApolloContext = getApolloContext();
    return React.createElement(ApolloContext.Consumer, null, function (context) {
        process.env.NODE_ENV === "production" ? tsInvariant.invariant(context && context.client, 27) : tsInvariant.invariant(context && context.client, 'Could not find "client" in the context of ApolloConsumer. ' +
            'Wrap the root component in an <ApolloProvider>.');
        return props.children(context.client);
    });
};

var ApolloProvider = function (_a) {
    var client = _a.client, children = _a.children;
    var ApolloContext = getApolloContext();
    return React.createElement(ApolloContext.Consumer, null, function (context) {
        if (context === void 0) { context = {}; }
        if (client && context.client !== client) {
            context = Object.assign({}, context, { client: client });
        }
        process.env.NODE_ENV === "production" ? tsInvariant.invariant(context.client, 28) : tsInvariant.invariant(context.client, 'ApolloProvider was not passed a client instance. Make ' +
            'sure you pass in your client via the "client" prop.');
        return (React.createElement(ApolloContext.Provider, { value: context }, children));
    });
};

exports.ApolloConsumer = ApolloConsumer;
exports.ApolloProvider = ApolloProvider;
exports.getApolloContext = getApolloContext;
exports.resetApolloContext = getApolloContext;
//# sourceMappingURL=context.cjs.js.map
