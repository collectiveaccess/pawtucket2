"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = defaultFilterBy;

var _fastDeepEqual = _interopRequireDefault(require("fast-deep-equal"));

var _getOptionProperty = _interopRequireDefault(require("./getOptionProperty"));

var _nodash = require("./nodash");

var _stripDiacritics = _interopRequireDefault(require("./stripDiacritics"));

var _warn = _interopRequireDefault(require("./warn"));

function isMatch(input, string, props) {
  var searchStr = input;
  var str = string;

  if (!props.caseSensitive) {
    searchStr = searchStr.toLowerCase();
    str = str.toLowerCase();
  }

  if (props.ignoreDiacritics) {
    searchStr = (0, _stripDiacritics["default"])(searchStr);
    str = (0, _stripDiacritics["default"])(str);
  }

  return str.indexOf(searchStr) !== -1;
}
/**
 * Default algorithm for filtering results.
 */


function defaultFilterBy(option, props) {
  var filterBy = props.filterBy,
      labelKey = props.labelKey,
      multiple = props.multiple,
      selected = props.selected,
      text = props.text; // Don't show selected options in the menu for the multi-select case.

  if (multiple && selected.some(function (o) {
    return (0, _fastDeepEqual["default"])(o, option);
  })) {
    return false;
  }

  if ((0, _nodash.isFunction)(labelKey) && isMatch(text, labelKey(option), props)) {
    return true;
  }

  var fields = filterBy.slice();

  if ((0, _nodash.isString)(labelKey)) {
    // Add the `labelKey` field to the list of fields if it isn't already there.
    if (fields.indexOf(labelKey) === -1) {
      fields.unshift(labelKey);
    }
  }

  if ((0, _nodash.isString)(option)) {
    (0, _warn["default"])(fields.length <= 1, 'You cannot filter by properties when `option` is a string.');
    return isMatch(text, option, props);
  }

  return fields.some(function (field) {
    var value = (0, _getOptionProperty["default"])(option, field);

    if (!(0, _nodash.isString)(value)) {
      (0, _warn["default"])(false, 'Fields passed to `filterBy` should have string values. Value will ' + 'be converted to a string; results may be unexpected.');
      value = String(value);
    }

    return isMatch(text, value, props);
  });
}