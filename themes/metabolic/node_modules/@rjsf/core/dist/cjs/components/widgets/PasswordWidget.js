"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _react = _interopRequireDefault(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function PasswordWidget(props) {
  var BaseInput = props.registry.widgets.BaseInput;
  return _react["default"].createElement(BaseInput, _extends({
    type: "password"
  }, props));
}

if (process.env.NODE_ENV !== "production") {
  PasswordWidget.propTypes = {
    value: _propTypes["default"].string
  };
}

var _default = PasswordWidget;
exports["default"] = _default;