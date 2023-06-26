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
