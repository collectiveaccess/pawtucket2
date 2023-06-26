!function(e){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var f;"undefined"!=typeof window?f=window:"undefined"!=typeof global?f=global:"undefined"!=typeof self&&(f=self),f.selectn=e()}}(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict'

var curry2 = require('curry2')
var debug = require('debug')('selectn')
var dotted = require('brackets2dots')
var splits = require('dotsplit.js')
var string = Object.prototype.toString

module.exports = curry2(selectn)

/**
 * Curried property accessor function that resolves deeply-nested object properties via dot/bracket-notation
 * string path while mitigating `TypeErrors` via friendly and composable API.
 *
 * @param {String|Array} path
 * Dot/bracket-notation string path or array.
 *
 * @param {Object} object
 * Object to access.
 *
 * @return {Function|*|undefined}
 * (1) returns `selectn/1` when partially applied.
 * (2) returns value at path if path exists.
 * (3) returns undefined if path does not exist.
 */
function selectn (path, object) {
  debug('arguments:', {
    path: path,
    object: object
  })

  var idx = -1
  var seg = string.call(path) === '[object Array]' ? path : splits(dotted(path))
  var end = seg.length
  var ref = end ? object : void 0

  while (++idx < end) {
    if (Object(ref) !== ref) return void 0
    ref = ref[seg[idx]]
  }

  debug('ref:', ref)
  return typeof ref === 'function' ? ref() : ref
}

},{"brackets2dots":6,"curry2":7,"debug":8,"dotsplit.js":10}],2:[function(require,module,exports){
'use strict'

/*!
 * imports.
 */

var curry2 = require('curry2')
var selectn = require('selectn')

/*!
 * imports (local).
 */

var expressions = require('./lib/expressions')

/*!
 * exports.
 */

module.exports = curry2(filter)

/**
 * Curried function deriving a new array containing items from given array for which predicate returns true.
 * Supports unary function, RegExp, dot/bracket-notation string path, and compound query object as predicate.
 *
 * @param {Function|String|Object} predicate
 * Unary function, RegExp, dot/bracket-notation string path, and compound query object.
 *
 * @param {Array} list
 * Array to evaluate.
 *
 * @return {Array}
 * New array containing items from given array for which predicate returns true.
 */

function filter (predicate, list) {
  var end = list.length
  var idx = -1
  var out = []

  while (++idx < end) {
    if (matchall(expressions(predicate, list[idx]))) out.push(list[idx])
  }

  return out
}

/**
 * Whether all given expressions evaluate to true.
 *
 * @param {Array} expressions
 * Expressions to evaluate.
 *
 * @return {Boolean}
 * Whether all given expressions evaluate to true.
 */

function matchall (expressions) {
  var end = expressions.length
  var idx = -1
  var out = false

  while (++idx < end) {
    var expression = expressions[idx]

    if (({}).toString.call(expression.predicate) === '[object Function]') {
      out = !!expression.predicate(expression.element)
    } else if (({}).toString.call(expression.predicate) === '[object RegExp]') {
      out = !!expression.predicate.exec(expression.element)
    } else if (expression.compare) {
      out = expression.predicate === expression.element
    } else {
      out = selectn(expression.predicate, expression.element)
    }

    if (out === false) {
      return out
    }
  }

  return out
}

},{"./lib/expressions":3,"curry2":7,"selectn":13}],3:[function(require,module,exports){
'use strict'

/*!
 * imports.
 */

var selectn = require('selectn')

/*!
 * exports.
 */

module.exports = expressions

/**
 * Creates and returns an array of expression objects.
 *
 * Example:
 *
 *  {
 *    predicate: 'received',
 *    element: 'received',
 *    compare: true
 *  }
 *
 *  {
 *    predicate: isBoolean,
 *    element: true
 *  }
 *
 *  {
 *    predicate: 'message.read',
 *    element: { message: { read: true } }
 *  }
 *
 * @param {Function|String|Object} predicate
 * Unary function, RegExp, dot/bracket-notation string path, and compound query object.
 *
 * @param {Array} list
 * Array to iterate over.
 *
 * @return {Array}
 * New array containing items from given array for which predicate returns true.
 */

function expressions (predicate, element) {
  var expressions = []

  if (isFunction(predicate) || isRegExp(predicate) || isString(predicate)) {
    expressions.push({predicate: predicate, element: element})
  } else {
    for (var key in predicate) {
      expressions.push({predicate: predicate[key], element: selectn(key, element), compare: true})
    }
  }

  return expressions
}

/**
 * Whether predicate is a RegExp instance.
 *
 * @param {*} predicate
 * Predicate value to test.
 *
 * @return {Boolean}
 * Whether predicate is a RegExp instance.
 */

function isRegExp (predicate) {
  return ({}).toString.call(predicate) === '[object RegExp]'
}

/**
 * Whether predicate is a function.
 *
 * @param {*} predicate
 * Predicate value to test.
 *
 * @return {Boolean}
 * Whether predicate is a function.
 */

function isFunction (predicate) {
  return ({}).toString.call(predicate) === '[object Function]'
}

/**
 * Whether predicate is a string.
 *
 * @param {*} predicate
 * Predicate value to test.
 *
 * @return {Boolean}
 * Whether predicate is a string.
 */

function isString (predicate) {
  return ({}).toString.call(predicate) === '[object String]'
}

},{"selectn":13}],4:[function(require,module,exports){
'use strict'

/*!
 * imports.
 */

var curry2 = require('curry2')
var selectn = require('selectn')

/*!
 * exports.
 */

module.exports = curry2(map)

/**
 * Curried function deriving new array values by applying provided function to each item/index of provided array.
 * Optionally, a dot-notation formatted string may be provided for item property access.
 *
 * @param {Function|String} fn
 * Function to apply to each item.
 *
 * @param {Array} list
 * Array to iterate over.
 *
 * @return {Array}
 * Array resulting from applying provided function `fn` to each item of `list`.
 */

function map (fn, list) {
  var end = list.length
  var idx = -1
  var out = []

  while (++idx < end) {
    out.push((typeof fn === 'string') ? selectn(fn, list[idx]) : fn(list[idx]))
  }

  return out
}

},{"curry2":5,"selectn":13}],5:[function(require,module,exports){
'use strict'

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
    return arguments.length > 1
    ? fn.call(self, arguments[0], arguments[1])
    : fn.bind(self, arguments[0])
  }

  out.uncurry = function uncurry () {
    return fn
  }

  return out
}

},{}],6:[function(require,module,exports){
'use strict';

/*!
 * exports.
 */

module.exports = brackets2dots;

/*!
 * regexp patterns.
 */

var REPLACE_BRACKETS = /\[([^\[\]]+)\]/g;
var LFT_RT_TRIM_DOTS = /^[.]*|[.]*$/g;

/**
 * Convert string with bracket notation to dot property notation.
 *
 * ### Examples:
 *
 *      brackets2dots('group[0].section.a.seat[3]')
 *      //=> 'group.0.section.a.seat.3'
 *
 *      brackets2dots('[0].section.a.seat[3]')
 *      //=> '0.section.a.seat.3'
 *
 *      brackets2dots('people[*].age')
 *      //=> 'people.*.age'
 *
 * @param  {String} string
 * original string
 *
 * @return {String}
 * dot/bracket-notation string
 */

function brackets2dots(string) {
  return ({}).toString.call(string) == '[object String]'
       ? string.replace(REPLACE_BRACKETS, '.$1').replace(LFT_RT_TRIM_DOTS, '')
       : ''
}

},{}],7:[function(require,module,exports){
'use strict'

/*!
 * imports.
 */

if (!Function.prototype.bind) Function.bind = require('fast-bind')

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
      : fn.bind(self, arguments[0])
  }

  out.uncurry = function uncurry () {
    return fn
  }

  return out
}

},{"fast-bind":11}],8:[function(require,module,exports){

/**
 * This is the web browser implementation of `debug()`.
 *
 * Expose `debug()` as the module.
 */

exports = module.exports = require('./debug');
exports.log = log;
exports.formatArgs = formatArgs;
exports.save = save;
exports.load = load;
exports.useColors = useColors;
exports.storage = 'undefined' != typeof chrome
               && 'undefined' != typeof chrome.storage
                  ? chrome.storage.local
                  : localstorage();

/**
 * Colors.
 */

exports.colors = [
  'lightseagreen',
  'forestgreen',
  'goldenrod',
  'dodgerblue',
  'darkorchid',
  'crimson'
];

/**
 * Currently only WebKit-based Web Inspectors, Firefox >= v31,
 * and the Firebug extension (any Firefox version) are known
 * to support "%c" CSS customizations.
 *
 * TODO: add a `localStorage` variable to explicitly enable/disable colors
 */

function useColors() {
  // is webkit? http://stackoverflow.com/a/16459606/376773
  return ('WebkitAppearance' in document.documentElement.style) ||
    // is firebug? http://stackoverflow.com/a/398120/376773
    (window.console && (console.firebug || (console.exception && console.table))) ||
    // is firefox >= v31?
    // https://developer.mozilla.org/en-US/docs/Tools/Web_Console#Styling_messages
    (navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31);
}

/**
 * Map %j to `JSON.stringify()`, since no Web Inspectors do that by default.
 */

exports.formatters.j = function(v) {
  return JSON.stringify(v);
};


/**
 * Colorize log arguments if enabled.
 *
 * @api public
 */

function formatArgs() {
  var args = arguments;
  var useColors = this.useColors;

  args[0] = (useColors ? '%c' : '')
    + this.namespace
    + (useColors ? ' %c' : ' ')
    + args[0]
    + (useColors ? '%c ' : ' ')
    + '+' + exports.humanize(this.diff);

  if (!useColors) return args;

  var c = 'color: ' + this.color;
  args = [args[0], c, 'color: inherit'].concat(Array.prototype.slice.call(args, 1));

  // the final "%c" is somewhat tricky, because there could be other
  // arguments passed either before or after the %c, so we need to
  // figure out the correct index to insert the CSS into
  var index = 0;
  var lastC = 0;
  args[0].replace(/%[a-z%]/g, function(match) {
    if ('%%' === match) return;
    index++;
    if ('%c' === match) {
      // we only are interested in the *last* %c
      // (the user may have provided their own)
      lastC = index;
    }
  });

  args.splice(lastC, 0, c);
  return args;
}

/**
 * Invokes `console.log()` when available.
 * No-op when `console.log` is not a "function".
 *
 * @api public
 */

function log() {
  // this hackery is required for IE8/9, where
  // the `console.log` function doesn't have 'apply'
  return 'object' === typeof console
    && console.log
    && Function.prototype.apply.call(console.log, console, arguments);
}

/**
 * Save `namespaces`.
 *
 * @param {String} namespaces
 * @api private
 */

function save(namespaces) {
  try {
    if (null == namespaces) {
      exports.storage.removeItem('debug');
    } else {
      exports.storage.debug = namespaces;
    }
  } catch(e) {}
}

/**
 * Load `namespaces`.
 *
 * @return {String} returns the previously persisted debug modes
 * @api private
 */

function load() {
  var r;
  try {
    r = exports.storage.debug;
  } catch(e) {}
  return r;
}

/**
 * Enable namespaces listed in `localStorage.debug` initially.
 */

exports.enable(load());

/**
 * Localstorage attempts to return the localstorage.
 *
 * This is necessary because safari throws
 * when a user disables cookies/localstorage
 * and you attempt to access it.
 *
 * @return {LocalStorage}
 * @api private
 */

function localstorage(){
  try {
    return window.localStorage;
  } catch (e) {}
}

},{"./debug":9}],9:[function(require,module,exports){

/**
 * This is the common logic for both the Node.js and web browser
 * implementations of `debug()`.
 *
 * Expose `debug()` as the module.
 */

exports = module.exports = debug;
exports.coerce = coerce;
exports.disable = disable;
exports.enable = enable;
exports.enabled = enabled;
exports.humanize = require('ms');

/**
 * The currently active debug mode names, and names to skip.
 */

exports.names = [];
exports.skips = [];

/**
 * Map of special "%n" handling functions, for the debug "format" argument.
 *
 * Valid key names are a single, lowercased letter, i.e. "n".
 */

exports.formatters = {};

/**
 * Previously assigned color.
 */

var prevColor = 0;

/**
 * Previous log timestamp.
 */

var prevTime;

/**
 * Select a color.
 *
 * @return {Number}
 * @api private
 */

function selectColor() {
  return exports.colors[prevColor++ % exports.colors.length];
}

/**
 * Create a debugger with the given `namespace`.
 *
 * @param {String} namespace
 * @return {Function}
 * @api public
 */

function debug(namespace) {

  // define the `disabled` version
  function disabled() {
  }
  disabled.enabled = false;

  // define the `enabled` version
  function enabled() {

    var self = enabled;

    // set `diff` timestamp
    var curr = +new Date();
    var ms = curr - (prevTime || curr);
    self.diff = ms;
    self.prev = prevTime;
    self.curr = curr;
    prevTime = curr;

    // add the `color` if not set
    if (null == self.useColors) self.useColors = exports.useColors();
    if (null == self.color && self.useColors) self.color = selectColor();

    var args = Array.prototype.slice.call(arguments);

    args[0] = exports.coerce(args[0]);

    if ('string' !== typeof args[0]) {
      // anything else let's inspect with %o
      args = ['%o'].concat(args);
    }

    // apply any `formatters` transformations
    var index = 0;
    args[0] = args[0].replace(/%([a-z%])/g, function(match, format) {
      // if we encounter an escaped % then don't increase the array index
      if (match === '%%') return match;
      index++;
      var formatter = exports.formatters[format];
      if ('function' === typeof formatter) {
        var val = args[index];
        match = formatter.call(self, val);

        // now we need to remove `args[index]` since it's inlined in the `format`
        args.splice(index, 1);
        index--;
      }
      return match;
    });

    if ('function' === typeof exports.formatArgs) {
      args = exports.formatArgs.apply(self, args);
    }
    var logFn = enabled.log || exports.log || console.log.bind(console);
    logFn.apply(self, args);
  }
  enabled.enabled = true;

  var fn = exports.enabled(namespace) ? enabled : disabled;

  fn.namespace = namespace;

  return fn;
}

/**
 * Enables a debug mode by namespaces. This can include modes
 * separated by a colon and wildcards.
 *
 * @param {String} namespaces
 * @api public
 */

function enable(namespaces) {
  exports.save(namespaces);

  var split = (namespaces || '').split(/[\s,]+/);
  var len = split.length;

  for (var i = 0; i < len; i++) {
    if (!split[i]) continue; // ignore empty strings
    namespaces = split[i].replace(/\*/g, '.*?');
    if (namespaces[0] === '-') {
      exports.skips.push(new RegExp('^' + namespaces.substr(1) + '$'));
    } else {
      exports.names.push(new RegExp('^' + namespaces + '$'));
    }
  }
}

/**
 * Disable debug output.
 *
 * @api public
 */

function disable() {
  exports.enable('');
}

/**
 * Returns true if the given mode name is enabled, false otherwise.
 *
 * @param {String} name
 * @return {Boolean}
 * @api public
 */

function enabled(name) {
  var i, len;
  for (i = 0, len = exports.skips.length; i < len; i++) {
    if (exports.skips[i].test(name)) {
      return false;
    }
  }
  for (i = 0, len = exports.names.length; i < len; i++) {
    if (exports.names[i].test(name)) {
      return true;
    }
  }
  return false;
}

/**
 * Coerce `val`.
 *
 * @param {Mixed} val
 * @return {Mixed}
 * @api private
 */

function coerce(val) {
  if (val instanceof Error) return val.stack || val.message;
  return val;
}

},{"ms":12}],10:[function(require,module,exports){
'use strict'

/*!
 * imports.
 */

var dotted = require('arraymap')(todots)
var compact = require('array.filter')(String)
var toString = Object.prototype.toString

/*!
 * exports.
 */

module.exports = dotsplit

/**
 * Transform dot-delimited strings to array of strings.
 *
 * @param  {String} string
 * Dot-delimited string.
 *
 * @return {Array}
 * Array of strings.
 */

function dotsplit (string) {
  return dotted(normalize(string))
}

/**
 * Normalize string by:
 *
 * (1) Dropping falsey values (empty, null, etc.)
 * (2) Replacing escapes with a placeholder.
 * (3) Splitting string on `.` delimiter.
 * (4) Dropping empty values from resulting array.
 *
 * @param  {String} string
 * Dot-delimited string.
 *
 * @return {Array}
 * Array of strings.
 */

function normalize (string) {
  return compact(
    (toString.call(string) === '[object String]' ? string : '')
    .replace(/\\\./g, '\uffff')
    .split('.')
  )
}

/**
 * Change placeholder to dots.
 *
 * @param  {String} string
 * Dot-delimited string with placeholders.
 *
 * @return {String}
 * Dot-delimited string without placeholders.
 */

function todots (string) {
  return string.replace(/\uffff/g, '.')
}

},{"array.filter":2,"arraymap":4}],11:[function(require,module,exports){
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
      var boundLen = boundArgs.length
        , args = new Array(boundLen + arguments.length)
        , i
      for (i = 0; i < boundLen; i++)
        args[i] = boundArgs[i]
      for (i = 0; i < arguments.length; i++)
        args[boundLen + i] = arguments[i]

      if (this instanceof ret) {
        var ret_ = f.apply(this, args)
        return Object(ret_) === ret_
          ? ret_
          : this
      }
      else
        return f.apply(boundThis, args)
    }
  }

  ret.prototype = f.prototype
  return ret
}

},{}],12:[function(require,module,exports){
/**
 * Helpers.
 */

var s = 1000;
var m = s * 60;
var h = m * 60;
var d = h * 24;
var y = d * 365.25;

/**
 * Parse or format the given `val`.
 *
 * Options:
 *
 *  - `long` verbose formatting [false]
 *
 * @param {String|Number} val
 * @param {Object} options
 * @return {String|Number}
 * @api public
 */

module.exports = function(val, options){
  options = options || {};
  if ('string' == typeof val) return parse(val);
  return options.long
    ? long(val)
    : short(val);
};

/**
 * Parse the given `str` and return milliseconds.
 *
 * @param {String} str
 * @return {Number}
 * @api private
 */

function parse(str) {
  str = '' + str;
  if (str.length > 10000) return;
  var match = /^((?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|years?|yrs?|y)?$/i.exec(str);
  if (!match) return;
  var n = parseFloat(match[1]);
  var type = (match[2] || 'ms').toLowerCase();
  switch (type) {
    case 'years':
    case 'year':
    case 'yrs':
    case 'yr':
    case 'y':
      return n * y;
    case 'days':
    case 'day':
    case 'd':
      return n * d;
    case 'hours':
    case 'hour':
    case 'hrs':
    case 'hr':
    case 'h':
      return n * h;
    case 'minutes':
    case 'minute':
    case 'mins':
    case 'min':
    case 'm':
      return n * m;
    case 'seconds':
    case 'second':
    case 'secs':
    case 'sec':
    case 's':
      return n * s;
    case 'milliseconds':
    case 'millisecond':
    case 'msecs':
    case 'msec':
    case 'ms':
      return n;
  }
}

/**
 * Short format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */

function short(ms) {
  if (ms >= d) return Math.round(ms / d) + 'd';
  if (ms >= h) return Math.round(ms / h) + 'h';
  if (ms >= m) return Math.round(ms / m) + 'm';
  if (ms >= s) return Math.round(ms / s) + 's';
  return ms + 'ms';
}

/**
 * Long format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */

function long(ms) {
  return plural(ms, d, 'day')
    || plural(ms, h, 'hour')
    || plural(ms, m, 'minute')
    || plural(ms, s, 'second')
    || ms + ' ms';
}

/**
 * Pluralization helper.
 */

function plural(ms, n, name) {
  if (ms < n) return;
  if (ms < n * 1.5) return Math.floor(ms / n) + ' ' + name;
  return Math.ceil(ms / n) + ' ' + name + 's';
}

},{}],13:[function(require,module,exports){
/*!
 * exports.
 */

module.exports = selectn;

/**
 * Select n-levels deep into an object given a dot/bracket-notation query.
 * If partially applied, returns a function accepting the second argument.
 *
 * ### Examples:
 *
 *      selectn('name.first', contact);
 *
 *      selectn('addresses[0].street', contact);
 *
 *      contacts.map(selectn('name.first'));
 *
 * @param  {String | Array} query
 * dot/bracket-notation query string or array of properties
 *
 * @param  {Object} object
 * object to access
 *
 * @return {Function}
 * accessor function that accepts an object to be queried
 */

function selectn(query) {
  var parts;

  if (Array.isArray(query)) {
    parts = query;
  }
  else {
    // normalize query to `.property` access (i.e. `a.b[0]` becomes `a.b.0`)
    query = query.replace(/\[(\d+)\]/g, '.$1');
    parts = query.split('.');
  }

  /**
   * Accessor function that accepts an object to be queried
   *
   * @private
   *
   * @param  {Object} object
   * object to access
   *
   * @return {Mixed}
   * value at given reference or undefined if it does not exist
   */

  function accessor(object) {
    var ref = (object != null) ? object : (1, eval)('this');
    var len = parts.length;
    var idx = 0;

    // iteratively save each segment's reference
    for (; idx < len; idx += 1) {
      if (ref != null) ref = ref[parts[idx]];
    }

    return ref;
  }

  // curry accessor function allowing partial application
  return arguments.length > 1
       ? accessor(arguments[1])
       : accessor;
}

},{}]},{},[1])(1)
});