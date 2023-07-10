"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _classnames = _interopRequireDefault(require("classnames"));

var _react = _interopRequireWildcard(require("react"));

var _ClearButton = _interopRequireDefault(require("./ClearButton"));

var _token = require("../behaviors/token");

var _utils = require("../utils");

var _excluded = ["active", "children", "className", "onRemove", "tabIndex"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

var InteractiveToken = /*#__PURE__*/(0, _react.forwardRef)(function (_ref, ref) {
  var active = _ref.active,
      children = _ref.children,
      className = _ref.className,
      onRemove = _ref.onRemove,
      tabIndex = _ref.tabIndex,
      props = (0, _objectWithoutProperties2["default"])(_ref, _excluded);
  return /*#__PURE__*/_react["default"].createElement("div", (0, _extends2["default"])({}, props, {
    className: (0, _classnames["default"])('rbt-token', 'rbt-token-removeable', {
      'rbt-token-active': !!active
    }, className),
    ref: ref,
    tabIndex: tabIndex || 0
  }), children, /*#__PURE__*/_react["default"].createElement(_ClearButton["default"], {
    className: "rbt-token-remove-button",
    label: "Remove",
    onClick: onRemove,
    tabIndex: -1
  }));
});

var StaticToken = function StaticToken(_ref2) {
  var children = _ref2.children,
      className = _ref2.className,
      disabled = _ref2.disabled,
      href = _ref2.href;
  var classnames = (0, _classnames["default"])('rbt-token', {
    'rbt-token-disabled': disabled
  }, className);

  if (href && !disabled) {
    return /*#__PURE__*/_react["default"].createElement("a", {
      className: classnames,
      href: href
    }, children);
  }

  return /*#__PURE__*/_react["default"].createElement("div", {
    className: classnames
  }, children);
};
/**
 * Token
 *
 * Individual token component, generally displayed within the TokenizerInput
 * component, but can also be rendered on its own.
 */


var Token = /*#__PURE__*/(0, _react.forwardRef)(function (props, ref) {
  var disabled = props.disabled,
      onRemove = props.onRemove,
      readOnly = props.readOnly;
  return !disabled && !readOnly && (0, _utils.isFunction)(onRemove) ? /*#__PURE__*/_react["default"].createElement(InteractiveToken, (0, _extends2["default"])({}, props, {
    ref: ref
  })) : /*#__PURE__*/_react["default"].createElement(StaticToken, props);
});

var _default = (0, _token.withToken)(Token);

exports["default"] = _default;