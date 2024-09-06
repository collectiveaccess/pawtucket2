'use strict';

var callBound = require('call-bind/callBound');
var $TypeError = require('es-errors/type');

var Call = require('es-abstract/2024/Call');
var Get = require('es-abstract/2024/Get');
var HasProperty = require('es-abstract/2024/HasProperty');
var IsCallable = require('es-abstract/2024/IsCallable');
var LengthOfArrayLike = require('es-abstract/2024/LengthOfArrayLike');
var ToObject = require('es-object-atoms/ToObject');
var ToString = require('es-abstract/2024/ToString');

var isString = require('is-string');

var $split = callBound('String.prototype.split');

// Check failure of by-index access of string characters (IE < 9) and failure of `0 in boxedString` (Rhino)
var boxedString = Object('a');
var splitString = boxedString[0] !== 'a' || !(0 in boxedString);

module.exports = function forEach(callbackfn) {
	var thisO = ToObject(this);
	var O = splitString && isString(this) ? $split(this, '') : thisO;

	var len = LengthOfArrayLike(O);

	if (!IsCallable(callbackfn)) {
		throw new $TypeError('Array.prototype.forEach callback must be a function');
	}

	var thisArg;
	if (arguments.length > 1) {
		thisArg = arguments[1];
	}

	var k = 0;
	while (k < len) {
		var Pk = ToString(k);
		var kPresent = HasProperty(O, Pk);
		if (kPresent) {
			var kValue = Get(O, Pk);
			Call(callbackfn, thisArg, [kValue, k, O]);
		}
		k += 1;
	}

	return void undefined;
};
