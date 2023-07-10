"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _react = _interopRequireDefault(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function UnsupportedField(_ref) {
  var schema = _ref.schema,
      idSchema = _ref.idSchema,
      reason = _ref.reason;
  return _react["default"].createElement("div", {
    className: "unsupported-field"
  }, _react["default"].createElement("p", null, "Unsupported field schema", idSchema && idSchema.$id && _react["default"].createElement("span", null, " for", " field ", _react["default"].createElement("code", null, idSchema.$id)), reason && _react["default"].createElement("em", null, ": ", reason), "."), schema && _react["default"].createElement("pre", null, JSON.stringify(schema, null, 2)));
}

if (process.env.NODE_ENV !== "production") {
  UnsupportedField.propTypes = {
    schema: _propTypes["default"].object.isRequired,
    idSchema: _propTypes["default"].object,
    reason: _propTypes["default"].string
  };
}

var _default = UnsupportedField;
exports["default"] = _default;