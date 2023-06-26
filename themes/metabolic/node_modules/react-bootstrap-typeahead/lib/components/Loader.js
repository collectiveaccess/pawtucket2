"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireDefault(require("react"));

var propTypes = {
  label: _propTypes["default"].string
};
var defaultProps = {
  label: 'Loading...'
};

var Loader = function Loader(_ref) {
  var label = _ref.label;
  return /*#__PURE__*/_react["default"].createElement("div", {
    className: "rbt-loader spinner-border spinner-border-sm",
    role: "status"
  }, /*#__PURE__*/_react["default"].createElement("span", {
    className: "sr-only visually-hidden"
  }, label));
};

Loader.propTypes = propTypes;
Loader.defaultProps = defaultProps;
var _default = Loader;
exports["default"] = _default;