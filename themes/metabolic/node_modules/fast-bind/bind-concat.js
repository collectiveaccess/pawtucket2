'use strict';
module.exports = function(boundThis) {
  var f = this
    , ret

  if (arguments.length < 2)
    ret = function() {
      if (this instanceof ret) {
        var ret_ = f.apply(this, arguments)
        return Object(ret_) === ret_
          ? ret_
          : this
      }
      else
        return f.apply(boundThis, arguments)
    }
  else {
    var boundArgs = new Array(arguments.length - 1)
    for (var i = 1; i < arguments.length; i++)
      boundArgs[i - 1] = arguments[i]

    ret = function() {
      var args = new Array(arguments.length)
      for (var i = 0; i < arguments.length; i++)
        args[i] = arguments[i]
      return f.apply(boundThis, boundArgs.concat(args))
    }
  }

  ret.prototype = f.prototype
  return ret
}
