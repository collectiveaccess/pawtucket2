"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _invariant = _interopRequireDefault(require("invariant"));

var _getStringLabelKey = _interopRequireDefault(require("./getStringLabelKey"));

var _nodash = require("./nodash");

/**
 * Retrieves the display string from an option. Options can be the string
 * themselves, or an object with a defined display string. Anything else throws
 * an error.
 */
function getOptionLabel(option, labelKey) {
  // Handle internally created options first.
  if (!(0, _nodash.isString)(option) && (option.paginationOption || option.customOption)) {
    return option[(0, _getStringLabelKey["default"])(labelKey)];
  }

  var optionLabel;

  if ((0, _nodash.isFunction)(labelKey)) {
    optionLabel = labelKey(option);
  } else if ((0, _nodash.isString)(option)) {
    optionLabel = option;
  } else {
    // `option` is an object and `labelKey` is a string.
    optionLabel = option[labelKey];
  }

  !(0, _nodash.isString)(optionLabel) ? process.env.NODE_ENV !== "production" ? (0, _invariant["default"])(false, 'One or more options does not have a valid label string. Check the ' + '`labelKey` prop to ensure that it matches the correct option key and ' + 'provides a string for filtering and display.') : invariant(false) : void 0;
  return optionLabel;
}

var _default = getOptionLabel;
exports["default"] = _default;