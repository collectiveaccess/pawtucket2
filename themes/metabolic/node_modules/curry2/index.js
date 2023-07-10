'use strict'

/*!
 * imports.
 */

var bind = Function.prototype.bind || require('fast-bind')

/*!
 * exports.
 */

module.exports = curry2

/**
 * Curry a binary function.
 *
 * @param {Function} fn
 * Binary function to curry.
 *
 * @param {Object} [self]
 * Function `this` context.
 *
 * @return {Function|*}
 * If partially applied, return unary function, otherwise, return result of full application.
 */

function curry2 (fn, self) {
  var out = function () {
    if (arguments.length === 0) return out

    return arguments.length > 1
      ? fn.apply(self, arguments)
      : bind.call(fn, self, arguments[0])
  }

  out.uncurry = function uncurry () {
    return fn
  }

  return out
}
