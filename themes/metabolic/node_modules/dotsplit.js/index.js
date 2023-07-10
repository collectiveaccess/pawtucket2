'use strict'

var toString = Object.prototype.toString

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
  var idx = -1
  var str = compact(normalize(string).split('.'))
  var end = str.length
  var out = []

  while (++idx < end) {
    out.push(todots(str[idx]))
  }

  return out
}

/**
 * Replace escapes with a placeholder.
 *
 * @param  {String} string
 * Dot-delimited string.
 *
 * @return {String}
 * Dot-delimited string with placeholders in place of escapes.
 */

function normalize (string) {
  return (toString.call(string) === '[object String]' ? string : '').replace(/\\\./g, '\uffff')
}

/**
 * Drop empty values from array.
 *
 * @param  {Array} array
 * Array of strings.
 *
 * @return {Array}
 * Array of strings (empty values dropped).
 */

function compact (arr) {
  var idx = -1
  var end = arr.length
  var out = []

  while (++idx < end) {
    if (arr[idx]) out.push(arr[idx])
  }

  return out
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

/*!
 * exports.
 */

module.exports = dotsplit
