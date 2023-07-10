"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _classnames = _interopRequireDefault(require("classnames"));

var _react = _interopRequireDefault(require("react"));

var _utils = require("../utils");

var _excluded = ["className", "isInvalid", "isValid", "size"];

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function withClassNames(Component) {
  // Use a class instead of function component to support refs.

  /* eslint-disable-next-line react/prefer-stateless-function */
  var WrappedComponent = /*#__PURE__*/function (_React$Component) {
    (0, _inherits2["default"])(WrappedComponent, _React$Component);

    var _super = _createSuper(WrappedComponent);

    function WrappedComponent() {
      (0, _classCallCheck2["default"])(this, WrappedComponent);
      return _super.apply(this, arguments);
    }

    (0, _createClass2["default"])(WrappedComponent, [{
      key: "render",
      value: function render() {
        var _this$props = this.props,
            className = _this$props.className,
            isInvalid = _this$props.isInvalid,
            isValid = _this$props.isValid,
            size = _this$props.size,
            props = (0, _objectWithoutProperties2["default"])(_this$props, _excluded);
        return /*#__PURE__*/_react["default"].createElement(Component, (0, _extends2["default"])({}, props, {
          className: (0, _classnames["default"])('form-control', 'rbt-input', {
            'form-control-lg': (0, _utils.isSizeLarge)(size),
            'form-control-sm': (0, _utils.isSizeSmall)(size),
            'is-invalid': isInvalid,
            'is-valid': isValid
          }, className)
        }));
      }
    }]);
    return WrappedComponent;
  }(_react["default"].Component);

  (0, _defineProperty2["default"])(WrappedComponent, "displayName", "withClassNames(".concat((0, _utils.getDisplayName)(Component), ")"));
  return WrappedComponent;
}

var _default = withClassNames;
exports["default"] = _default;