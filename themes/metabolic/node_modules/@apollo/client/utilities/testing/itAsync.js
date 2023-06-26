function wrap(key) {
    return function (message, callback, timeout) { return (key ? it[key] : it)(message, function () {
        var _this = this;
        return new Promise(function (resolve, reject) { return callback.call(_this, resolve, reject); });
    }, timeout); };
}
var wrappedIt = wrap();
export function itAsync() {
    var args = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        args[_i] = arguments[_i];
    }
    return wrappedIt.apply(this, args);
}
(function (itAsync) {
    itAsync.only = wrap("only");
    itAsync.skip = wrap("skip");
    itAsync.todo = wrap("todo");
})(itAsync || (itAsync = {}));
//# sourceMappingURL=itAsync.js.map