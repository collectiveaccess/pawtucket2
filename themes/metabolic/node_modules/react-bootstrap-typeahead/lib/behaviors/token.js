"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = tokenContainer;
exports.withToken = exports.useToken = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _slicedToArray2 = _interopRequireDefault(require("@babel/runtime/helpers/slicedToArray"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireWildcard(require("react"));

var _useRootClose = _interopRequireDefault(require("react-overlays/useRootClose"));

var _utils = require("../utils");

var _constants = require("../constants");

var _propTypes2 = require("../propTypes");

var _excluded = ["onBlur", "onClick", "onFocus", "onRemove", "option"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

var propTypes = {
  onBlur: _propTypes["default"].func,
  onClick: _propTypes["default"].func,
  onFocus: _propTypes["default"].func,
  onRemove: _propTypes["default"].func,
  option: _propTypes2.optionType.isRequired
};

var useToken = function useToken(_ref) {
  var onBlur = _ref.onBlur,
      onClick = _ref.onClick,
      onFocus = _ref.onFocus,
      onRemove = _ref.onRemove,
      option = _ref.option,
      props = (0, _objectWithoutProperties2["default"])(_ref, _excluded);

  var _useState = (0, _react.useState)(false),
      _useState2 = (0, _slicedToArray2["default"])(_useState, 2),
      active = _useState2[0],
      setActive = _useState2[1];

  var _useState3 = (0, _react.useState)(null),
      _useState4 = (0, _slicedToArray2["default"])(_useState3, 2),
      rootElement = _useState4[0],
      attachRef = _useState4[1];

  var handleActiveChange = function handleActiveChange(e, isActive, callback) {
    e.stopPropagation();
    setActive(isActive);
    typeof callback === 'function' && callback(e);
  };

  var handleBlur = function handleBlur(e) {
    handleActiveChange(e, false, onBlur);
  };

  var handleClick = function handleClick(e) {
    handleActiveChange(e, true, onClick);
  };

  var handleFocus = function handleFocus(e) {
    handleActiveChange(e, true, onFocus);
  };

  var handleRemove = function handleRemove() {
    onRemove && onRemove(option);
  };

  var handleKeyDown = function handleKeyDown(e) {
    switch (e.keyCode) {
      case _constants.BACKSPACE:
        if (active) {
          // Prevent backspace keypress from triggering the browser "back"
          // action.
          e.preventDefault();
          handleRemove();
        }

        break;

      default:
        break;
    }
  };

  (0, _useRootClose["default"])(rootElement, handleBlur, _objectSpread(_objectSpread({}, props), {}, {
    disabled: !active
  }));
  return _objectSpread(_objectSpread({}, props), {}, {
    active: active,
    onBlur: handleBlur,
    onClick: handleClick,
    onFocus: handleFocus,
    onKeyDown: handleKeyDown,
    onRemove: (0, _utils.isFunction)(onRemove) ? handleRemove : undefined,
    ref: attachRef
  });
};

exports.useToken = useToken;

var withToken = function withToken(Component) {
  var displayName = "withToken(".concat((0, _utils.getDisplayName)(Component), ")");

  var WrappedToken = function WrappedToken(props) {
    return /*#__PURE__*/_react["default"].createElement(Component, useToken(props));
  };

  WrappedToken.displayName = displayName;
  WrappedToken.propTypes = propTypes;
  return WrappedToken;
};

exports.withToken = withToken;

function tokenContainer(Component) {
  /* istanbul ignore next */
  (0, _utils.warn)(false, 'The `tokenContainer` export is deprecated; use `withToken` instead.');
  /* istanbul ignore next */

  return withToken(Component);
}