"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.head = head;
exports.isFunction = isFunction;
exports.isString = isString;
exports.noop = noop;
exports.pick = pick;
exports.uniqueId = uniqueId;
exports.valuesPolyfill = valuesPolyfill;
exports.values = values;
var idCounter = 0;

function head(arr) {
  return Array.isArray(arr) && arr.length ? arr[0] : undefined;
}

function isFunction(value) {
  return typeof value === 'function';
}

function isString(value) {
  return typeof value === 'string';
}

function noop() {}

function pick(obj, keys) {
  var result = {};
  keys.forEach(function (k) {
    if (Object.prototype.hasOwnProperty.call(obj, k)) {
      result[k] = obj[k];
    }
  });
  return result;
}

function uniqueId(prefix) {
  idCounter += 1;
  return (prefix == null ? '' : String(prefix)) + idCounter;
} // Export for testing purposes.


function valuesPolyfill(obj) {
  return Object.keys(obj).reduce(function (accum, key) {
    if (Object.prototype.propertyIsEnumerable.call(obj, key)) {
      accum.push(obj[key]);
    }

    return accum;
  }, []);
}

function values(obj) {
  return isFunction(Object.values) ? Object.values(obj) : valuesPolyfill(obj);
}