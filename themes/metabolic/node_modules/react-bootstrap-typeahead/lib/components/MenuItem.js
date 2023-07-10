"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = exports.BaseMenuItem = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _classnames = _interopRequireDefault(require("classnames"));

var _react = _interopRequireDefault(require("react"));

var _item = require("../behaviors/item");

var _excluded = ["active", "children", "className", "disabled", "onClick"];

var BaseMenuItem = /*#__PURE__*/_react["default"].forwardRef(function (_ref, ref) {
  var active = _ref.active,
      children = _ref.children,
      className = _ref.className,
      disabled = _ref.disabled,
      _onClick = _ref.onClick,
      props = (0, _objectWithoutProperties2["default"])(_ref, _excluded);
  return /*#__PURE__*/_react["default"].createElement("a", (0, _extends2["default"])({}, props, {
    className: (0, _classnames["default"])('dropdown-item', {
      active: active,
      disabled: disabled
    }, className),
    href: props.href || '#',
    onClick: function onClick(e) {
      e.preventDefault();
      !disabled && _onClick && _onClick(e);
    },
    ref: ref
  }), children);
});

exports.BaseMenuItem = BaseMenuItem;

var _default = (0, _item.withItem)(BaseMenuItem);

exports["default"] = _default;