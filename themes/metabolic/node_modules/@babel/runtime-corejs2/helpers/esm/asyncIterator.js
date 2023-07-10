import _Symbol from "@babel/runtime-corejs2/core-js/symbol";
import _Symbol$iterator from "@babel/runtime-corejs2/core-js/symbol/iterator";
export default function _asyncIterator(iterable) {
  var method;

  if (typeof _Symbol !== "undefined") {
    if (_Symbol.asyncIterator) method = iterable[_Symbol.asyncIterator];
    if (method == null && _Symbol$iterator) method = iterable[_Symbol$iterator];
  }

  if (method == null) method = iterable["@@asyncIterator"];
  if (method == null) method = iterable["@@iterator"];
  if (method == null) throw new TypeError("Object is not async iterable");
  return method.call(iterable);
}