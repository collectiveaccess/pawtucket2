'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var tslib = require('tslib');
var core = require('../core');
var utilities = require('../../utilities');

function setContext(setter) {
    return new core.ApolloLink(function (operation, forward) {
        var request = tslib.__rest(operation, []);
        return new utilities.Observable(function (observer) {
            var handle;
            Promise.resolve(request)
                .then(function (req) { return setter(req, operation.getContext()); })
                .then(operation.setContext)
                .then(function () {
                handle = forward(operation).subscribe({
                    next: observer.next.bind(observer),
                    error: observer.error.bind(observer),
                    complete: observer.complete.bind(observer),
                });
            })
                .catch(observer.error.bind(observer));
            return function () {
                if (handle)
                    handle.unsubscribe();
            };
        });
    });
}

exports.setContext = setContext;
//# sourceMappingURL=context.cjs.js.map
