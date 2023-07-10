"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _classnames = _interopRequireDefault(require("classnames"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireWildcard(require("react"));

var _MenuItem = require("./MenuItem");

var _utils = require("../utils");

var _propTypes2 = require("../propTypes");

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

var MenuDivider = function MenuDivider(props) {
  return /*#__PURE__*/_react["default"].createElement("div", {
    className: "dropdown-divider",
    role: "separator"
  });
};

var MenuHeader = function MenuHeader(props) {
  return (
    /*#__PURE__*/
    // eslint-disable-next-line jsx-a11y/role-has-required-aria-props
    _react["default"].createElement("div", (0, _extends2["default"])({}, props, {
      className: "dropdown-header",
      role: "heading"
    }))
  );
};

var propTypes = {
  'aria-label': _propTypes["default"].string,

  /**
   * Message to display in the menu if there are no valid results.
   */
  emptyLabel: _propTypes["default"].node,

  /**
   * Needed for accessibility.
   */
  id: (0, _propTypes2.checkPropType)(_propTypes["default"].oneOfType([_propTypes["default"].number, _propTypes["default"].string]), _propTypes2.isRequiredForA11y),

  /**
   * Maximum height of the dropdown menu.
   */
  maxHeight: _propTypes["default"].string
};
var defaultProps = {
  'aria-label': 'menu-options',
  emptyLabel: 'No matches found.',
  maxHeight: '300px'
};

/**
 * Menu component that handles empty state when passed a set of results.
 */
var Menu = /*#__PURE__*/function (_React$Component) {
  (0, _inherits2["default"])(Menu, _React$Component);

  var _super = _createSuper(Menu);

  function Menu() {
    (0, _classCallCheck2["default"])(this, Menu);
    return _super.apply(this, arguments);
  }

  (0, _createClass2["default"])(Menu, [{
    key: "componentDidUpdate",
    value: function componentDidUpdate(prevProps) {
      var _this$props = this.props,
          inputHeight = _this$props.inputHeight,
          scheduleUpdate = _this$props.scheduleUpdate; // Update the menu position if the height of the input changes.

      if (inputHeight !== prevProps.inputHeight) {
        scheduleUpdate();
      }
    }
  }, {
    key: "render",
    value: function render() {
      var _this$props2 = this.props,
          children = _this$props2.children,
          className = _this$props2.className,
          emptyLabel = _this$props2.emptyLabel,
          id = _this$props2.id,
          innerRef = _this$props2.innerRef,
          maxHeight = _this$props2.maxHeight,
          style = _this$props2.style,
          text = _this$props2.text;
      var contents = _react.Children.count(children) === 0 ? /*#__PURE__*/_react["default"].createElement(_MenuItem.BaseMenuItem, {
        disabled: true,
        role: "option"
      }, emptyLabel) : children;
      return (
        /*#__PURE__*/

        /* eslint-disable jsx-a11y/interactive-supports-focus */
        _react["default"].createElement("div", {
          "aria-label": this.props['aria-label'],
          className: (0, _classnames["default"])('rbt-menu', 'dropdown-menu', 'show', className),
          id: id,
          key: // Force a re-render if the text changes to ensure that menu
          // positioning updates correctly.
          text,
          onMouseDown: // Prevent input from blurring when clicking on the menu scrollbar.
          _utils.preventInputBlur,
          ref: innerRef,
          role: "listbox",
          style: _objectSpread(_objectSpread({}, style), {}, {
            display: 'block',
            maxHeight: maxHeight,
            overflow: 'auto'
          })
        }, contents)
        /* eslint-enable jsx-a11y/interactive-supports-focus */

      );
    }
  }]);
  return Menu;
}(_react["default"].Component);

(0, _defineProperty2["default"])(Menu, "propTypes", propTypes);
(0, _defineProperty2["default"])(Menu, "defaultProps", defaultProps);
(0, _defineProperty2["default"])(Menu, "Divider", MenuDivider);
(0, _defineProperty2["default"])(Menu, "Header", MenuHeader);
var _default = Menu;
exports["default"] = _default;