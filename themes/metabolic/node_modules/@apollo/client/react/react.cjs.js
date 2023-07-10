'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var context = require('./context');
var hooks = require('./hooks');
var parser = require('./parser');



Object.keys(hooks).forEach(function (k) {
	if (k !== 'default') exports[k] = hooks[k];
});
exports.ApolloConsumer = context.ApolloConsumer;
exports.ApolloProvider = context.ApolloProvider;
exports.getApolloContext = context.getApolloContext;
exports.resetApolloContext = context.resetApolloContext;
exports.DocumentType = parser.DocumentType;
exports.operationName = parser.operationName;
exports.parser = parser.parser;
//# sourceMappingURL=react.cjs.js.map
