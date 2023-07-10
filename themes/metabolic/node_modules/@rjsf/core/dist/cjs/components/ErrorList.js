"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = ErrorList;

var _react = _interopRequireDefault(require("react"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function ErrorList(props) {
  var errors = props.errors;
  return _react["default"].createElement("div", {
    className: "panel panel-danger errors"
  }, _react["default"].createElement("div", {
    className: "panel-heading"
  }, _react["default"].createElement("h3", {
    className: "panel-title"
  }, "Errors")), _react["default"].createElement("ul", {
    className: "list-group"
  }, errors.map(function (error, i) {
    return _react["default"].createElement("li", {
      key: i,
      className: "list-group-item text-danger"
    }, error.stack);
  })));
}