import Observable from 'zen-observable';
import 'symbol-observable';
var prototype = Observable.prototype;
var fakeObsSymbol = '@@observable';
if (!prototype[fakeObsSymbol]) {
    prototype[fakeObsSymbol] = function () { return this; };
}
export { Observable };
//# sourceMappingURL=Observable.js.map