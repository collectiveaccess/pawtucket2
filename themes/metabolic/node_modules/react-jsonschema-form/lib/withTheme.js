"use strict";

var _interopRequireWildcard = require("@babel/runtime-corejs2/helpers/interopRequireWildcard");

var _interopRequireDefault = require("@babel/runtime-corejs2/helpers/interopRequireDefault");

var _Object$defineProperty = require("@babel/runtime-corejs2/core-js/object/define-property");

_Object$defineProperty(exports, "__esModule", {
  value: true
});

exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/extends"));

var _objectSpread2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/objectSpread"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/objectWithoutProperties"));

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/createClass"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/getPrototypeOf"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/inherits"));

var _react = _interopRequireWildcard(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _ = _interopRequireDefault(require("./"));

function withTheme(themeProps) {
  return (
    /*#__PURE__*/
    function (_Component) {
      (0, _inherits2["default"])(_class, _Component);

      function _class() {
        (0, _classCallCheck2["default"])(this, _class);
        return (0, _possibleConstructorReturn2["default"])(this, (0, _getPrototypeOf2["default"])(_class).apply(this, arguments));
      }

      (0, _createClass2["default"])(_class, [{
        key: "render",
        value: function render() {
          var _this$props = this.props,
              fields = _this$props.fields,
              widgets = _this$props.widgets,
              directProps = (0, _objectWithoutProperties2["default"])(_this$props, ["fields", "widgets"]);
          fields = (0, _objectSpread2["default"])({}, themeProps.fields, fields);
          widgets = (0, _objectSpread2["default"])({}, themeProps.widgets, widgets);
          return _react["default"].createElement(_["default"], (0, _extends2["default"])({}, themeProps, directProps, {
            fields: fields,
            widgets: widgets
          }));
        }
      }]);
      return _class;
    }(_react.Component)
  );
}

withTheme.propTypes = {
  widgets: _propTypes["default"].object,
  fields: _propTypes["default"].object
};
var _default = withTheme;
exports["default"] = _default;