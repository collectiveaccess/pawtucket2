"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.checkPropType = checkPropType;
exports.caseSensitiveType = caseSensitiveType;
exports.deprecated = deprecated;
exports.defaultInputValueType = defaultInputValueType;
exports.defaultSelectedType = defaultSelectedType;
exports.highlightOnlyResultType = highlightOnlyResultType;
exports.ignoreDiacriticsType = ignoreDiacriticsType;
exports.inputPropsType = inputPropsType;
exports.isRequiredForA11y = isRequiredForA11y;
exports.labelKeyType = labelKeyType;
exports.selectedType = selectedType;
exports.optionType = exports.sizeType = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _utils = require("./utils");

var _constants = require("./constants");

var INPUT_PROPS_BLACKLIST = [{
  alt: 'onBlur',
  prop: 'onBlur'
}, {
  alt: 'onInputChange',
  prop: 'onChange'
}, {
  alt: 'onFocus',
  prop: 'onFocus'
}, {
  alt: 'onKeyDown',
  prop: 'onKeyDown'
}];

var sizeType = _propTypes["default"].oneOf((0, _utils.values)(_constants.SIZE));
/**
 * Allows additional warnings or messaging related to prop validation.
 */


exports.sizeType = sizeType;

function checkPropType(validator, callback) {
  return function (props, propName, componentName) {
    _propTypes["default"].checkPropTypes((0, _defineProperty2["default"])({}, propName, validator), props, 'prop', componentName);

    (0, _utils.isFunction)(callback) && callback(props, propName, componentName);
  };
}

function caseSensitiveType(props, propName, componentName) {
  var caseSensitive = props.caseSensitive,
      filterBy = props.filterBy;
  (0, _utils.warn)(!caseSensitive || typeof filterBy !== 'function', 'Your `filterBy` function will override the `caseSensitive` prop.');
}

function deprecated(validator, reason) {
  return function (props, propName, componentName) {
    if (props[propName] != null) {
      (0, _utils.warn)(false, "The `".concat(propName, "` prop is deprecated. ").concat(reason));
    }

    return _propTypes["default"].checkPropTypes((0, _defineProperty2["default"])({}, propName, validator), props, 'prop', componentName);
  };
}

function defaultInputValueType(props, propName, componentName) {
  var defaultInputValue = props.defaultInputValue,
      defaultSelected = props.defaultSelected,
      multiple = props.multiple,
      selected = props.selected;
  var name = defaultSelected.length ? 'defaultSelected' : 'selected';
  (0, _utils.warn)(!(!multiple && defaultInputValue && (defaultSelected.length || selected && selected.length)), "`defaultInputValue` will be overridden by the value from `".concat(name, "`."));
}

function defaultSelectedType(props, propName, componentName) {
  var defaultSelected = props.defaultSelected,
      multiple = props.multiple;
  (0, _utils.warn)(multiple || defaultSelected.length <= 1, 'You are passing multiple options to the `defaultSelected` prop of a ' + 'Typeahead in single-select mode. The selections will be truncated to a ' + 'single selection.');
}

function highlightOnlyResultType(props, propName, componentName) {
  var allowNew = props.allowNew,
      highlightOnlyResult = props.highlightOnlyResult;
  (0, _utils.warn)(!(highlightOnlyResult && allowNew), '`highlightOnlyResult` will not work with `allowNew`.');
}

function ignoreDiacriticsType(props, propName, componentName) {
  var filterBy = props.filterBy,
      ignoreDiacritics = props.ignoreDiacritics;
  (0, _utils.warn)(ignoreDiacritics || typeof filterBy !== 'function', 'Your `filterBy` function will override the `ignoreDiacritics` prop.');
}

function inputPropsType(props, propName, componentName) {
  var inputProps = props.inputProps;

  if (!(inputProps && Object.prototype.toString.call(inputProps) === '[object Object]')) {
    return;
  } // Blacklisted properties.


  INPUT_PROPS_BLACKLIST.forEach(function (_ref) {
    var alt = _ref.alt,
        prop = _ref.prop;
    var msg = alt ? " Use the top-level `".concat(alt, "` prop instead.") : null;
    (0, _utils.warn)(!inputProps[prop], "The `".concat(prop, "` property of `inputProps` will be ignored.").concat(msg));
  });
}

function isRequiredForA11y(props, propName, componentName) {
  (0, _utils.warn)(props[propName] != null, "The prop `".concat(propName, "` is required to make `").concat(componentName, "` ") + 'accessible for users of assistive technologies such as screen readers.');
}

function labelKeyType(props, propName, componentName) {
  var allowNew = props.allowNew,
      labelKey = props.labelKey;
  (0, _utils.warn)(!((0, _utils.isFunction)(labelKey) && allowNew), '`labelKey` must be a string when `allowNew={true}`.');
}

var optionType = _propTypes["default"].oneOfType([_propTypes["default"].object, _propTypes["default"].string]);

exports.optionType = optionType;

function selectedType(props, propName, componentName) {
  var multiple = props.multiple,
      onChange = props.onChange,
      selected = props.selected;
  (0, _utils.warn)(multiple || !selected || selected.length <= 1, 'You are passing multiple options to the `selected` prop of a Typeahead ' + 'in single-select mode. This may lead to unexpected behaviors or errors.');
  (0, _utils.warn)(!selected || selected && (0, _utils.isFunction)(onChange), 'You provided a `selected` prop without an `onChange` handler. If you ' + 'want the typeahead to be uncontrolled, use `defaultSelected`. ' + 'Otherwise, set `onChange`.');
}