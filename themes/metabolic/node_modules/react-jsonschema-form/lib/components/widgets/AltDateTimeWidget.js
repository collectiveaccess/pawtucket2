"use strict";

var _interopRequireDefault = require("@babel/runtime-corejs2/helpers/interopRequireDefault");

var _Object$defineProperty = require("@babel/runtime-corejs2/core-js/object/define-property");

_Object$defineProperty(exports, "__esModule", {
  value: true
});

exports["default"] = void 0;

var _objectSpread2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/objectSpread"));

var _extends2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/extends"));

var _react = _interopRequireDefault(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _AltDateWidget = _interopRequireDefault(require("./AltDateWidget"));

function AltDateTimeWidget(props) {
  var AltDateWidget = props.registry.widgets.AltDateWidget;
  return _react["default"].createElement(AltDateWidget, (0, _extends2["default"])({
    time: true
  }, props));
}

if (process.env.NODE_ENV !== "production") {
  AltDateTimeWidget.propTypes = {
    schema: _propTypes["default"].object.isRequired,
    id: _propTypes["default"].string.isRequired,
    value: _propTypes["default"].string,
    required: _propTypes["default"].bool,
    onChange: _propTypes["default"].func,
    options: _propTypes["default"].object
  };
}

AltDateTimeWidget.defaultProps = (0, _objectSpread2["default"])({}, _AltDateWidget["default"].defaultProps, {
  time: true
});
var _default = AltDateTimeWidget;
exports["default"] = _default;