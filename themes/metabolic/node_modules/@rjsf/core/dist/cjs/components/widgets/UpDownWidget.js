"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _react = _interopRequireDefault(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _utils = require("../../utils");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function UpDownWidget(props) {
  var BaseInput = props.registry.widgets.BaseInput;
  return _react["default"].createElement(BaseInput, _extends({
    type: "number"
  }, props, (0, _utils.rangeSpec)(props.schema)));
}

if (process.env.NODE_ENV !== "production") {
  UpDownWidget.propTypes = {
    value: _propTypes["default"].oneOfType([_propTypes["default"].number, _propTypes["default"].string])
  };
}

var _default = UpDownWidget;
exports["default"] = _default;