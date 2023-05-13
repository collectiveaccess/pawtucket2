"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _assertThisInitialized2 = _interopRequireDefault(require("@babel/runtime/helpers/assertThisInitialized"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _slicedToArray2 = _interopRequireDefault(require("@babel/runtime/helpers/slicedToArray"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _classnames = _interopRequireDefault(require("classnames"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireWildcard(require("react"));

var _useRootClose = _interopRequireDefault(require("react-overlays/useRootClose"));

var _Typeahead = _interopRequireDefault(require("../core/Typeahead"));

var _ClearButton = _interopRequireDefault(require("./ClearButton"));

var _Loader = _interopRequireDefault(require("./Loader"));

var _Overlay = _interopRequireDefault(require("./Overlay"));

var _Token = _interopRequireDefault(require("./Token"));

var _TypeaheadInputMulti = _interopRequireDefault(require("./TypeaheadInputMulti"));

var _TypeaheadInputSingle = _interopRequireDefault(require("./TypeaheadInputSingle"));

var _TypeaheadMenu = _interopRequireDefault(require("./TypeaheadMenu"));

var _utils = require("../utils");

var _propTypes2 = require("../propTypes");

var _excluded = ["children", "onRootClose"],
    _excluded2 = ["getInputProps"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

var propTypes = {
  /**
   * Displays a button to clear the input when there are selections.
   */
  clearButton: _propTypes["default"].bool,

  /**
   * Props to be applied directly to the input. `onBlur`, `onChange`,
   * `onFocus`, and `onKeyDown` are ignored.
   */
  inputProps: (0, _propTypes2.checkPropType)(_propTypes["default"].object, _propTypes2.inputPropsType),

  /**
   * Bootstrap 4 only. Adds the `is-invalid` classname to the `form-control`.
   */
  isInvalid: _propTypes["default"].bool,

  /**
   * Indicate whether an asynchronous data fetch is happening.
   */
  isLoading: _propTypes["default"].bool,

  /**
   * Bootstrap 4 only. Adds the `is-valid` classname to the `form-control`.
   */
  isValid: _propTypes["default"].bool,

  /**
   * Callback for custom input rendering.
   */
  renderInput: _propTypes["default"].func,

  /**
   * Callback for custom menu rendering.
   */
  renderMenu: _propTypes["default"].func,

  /**
   * Callback for custom menu rendering.
   */
  renderToken: _propTypes["default"].func,

  /**
   * Specifies the size of the input.
   */
  size: _propTypes2.sizeType
};
var defaultProps = {
  clearButton: false,
  inputProps: {},
  isInvalid: false,
  isLoading: false,
  isValid: false,
  renderMenu: function renderMenu(results, menuProps, props) {
    return /*#__PURE__*/_react["default"].createElement(_TypeaheadMenu["default"], (0, _extends2["default"])({}, menuProps, {
      labelKey: props.labelKey,
      options: results,
      text: props.text
    }));
  },
  renderToken: function renderToken(option, props, idx) {
    return /*#__PURE__*/_react["default"].createElement(_Token["default"], {
      disabled: props.disabled,
      key: idx,
      onRemove: props.onRemove,
      option: option,
      tabIndex: props.tabIndex
    }, (0, _utils.getOptionLabel)(option, props.labelKey));
  }
};

function getOverlayProps(props) {
  return (0, _utils.pick)(props, ['align', 'dropup', 'flip', 'positionFixed']);
}

var RootClose = function RootClose(_ref) {
  var children = _ref.children,
      onRootClose = _ref.onRootClose,
      props = (0, _objectWithoutProperties2["default"])(_ref, _excluded);

  var _useState = (0, _react.useState)(null),
      _useState2 = (0, _slicedToArray2["default"])(_useState, 2),
      rootElement = _useState2[0],
      attachRef = _useState2[1];

  (0, _useRootClose["default"])(rootElement, onRootClose, props);
  return children(attachRef);
};

var TypeaheadComponent = /*#__PURE__*/function (_React$Component) {
  (0, _inherits2["default"])(TypeaheadComponent, _React$Component);

  var _super = _createSuper(TypeaheadComponent);

  function TypeaheadComponent() {
    var _this;

    (0, _classCallCheck2["default"])(this, TypeaheadComponent);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_referenceElement", void 0);
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "referenceElementRef", function (referenceElement) {
      _this._referenceElement = referenceElement;
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_renderInput", function (inputProps, props) {
      var _this$props = _this.props,
          isInvalid = _this$props.isInvalid,
          isValid = _this$props.isValid,
          multiple = _this$props.multiple,
          renderInput = _this$props.renderInput,
          renderToken = _this$props.renderToken,
          size = _this$props.size;

      if ((0, _utils.isFunction)(renderInput)) {
        return renderInput(inputProps, props);
      }

      var commonProps = _objectSpread(_objectSpread({}, inputProps), {}, {
        isInvalid: isInvalid,
        isValid: isValid,
        size: size
      });

      if (!multiple) {
        return /*#__PURE__*/_react["default"].createElement(_TypeaheadInputSingle["default"], commonProps);
      }

      var labelKey = props.labelKey,
          onRemove = props.onRemove,
          selected = props.selected;
      return /*#__PURE__*/_react["default"].createElement(_TypeaheadInputMulti["default"], (0, _extends2["default"])({}, commonProps, {
        selected: selected
      }), selected.map(function (option, idx) {
        return renderToken(option, _objectSpread(_objectSpread({}, commonProps), {}, {
          labelKey: labelKey,
          onRemove: onRemove
        }), idx);
      }));
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_renderMenu", function (results, menuProps, props) {
      var _this$props2 = _this.props,
          emptyLabel = _this$props2.emptyLabel,
          id = _this$props2.id,
          maxHeight = _this$props2.maxHeight,
          newSelectionPrefix = _this$props2.newSelectionPrefix,
          paginationText = _this$props2.paginationText,
          renderMenu = _this$props2.renderMenu,
          renderMenuItemChildren = _this$props2.renderMenuItemChildren;
      return renderMenu(results, _objectSpread(_objectSpread({}, menuProps), {}, {
        emptyLabel: emptyLabel,
        id: id,
        maxHeight: maxHeight,
        newSelectionPrefix: newSelectionPrefix,
        paginationText: paginationText,
        renderMenuItemChildren: renderMenuItemChildren
      }), props);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_renderAux", function (_ref2) {
      var onClear = _ref2.onClear,
          selected = _ref2.selected;
      var _this$props3 = _this.props,
          clearButton = _this$props3.clearButton,
          disabled = _this$props3.disabled,
          isLoading = _this$props3.isLoading,
          size = _this$props3.size;
      var content;

      if (isLoading) {
        content = /*#__PURE__*/_react["default"].createElement(_Loader["default"], null);
      } else if (clearButton && !disabled && selected.length) {
        content = /*#__PURE__*/_react["default"].createElement(_ClearButton["default"], {
          onClick: onClear,
          onFocus: function onFocus(e) {
            // Prevent the main input from auto-focusing again.
            e.stopPropagation();
          },
          onMouseDown: _utils.preventInputBlur,
          size: size
        });
      }

      return content ? /*#__PURE__*/_react["default"].createElement("div", {
        className: (0, _classnames["default"])('rbt-aux', {
          'rbt-aux-lg': (0, _utils.isSizeLarge)(size)
        })
      }, content) : null;
    });
    return _this;
  }

  (0, _createClass2["default"])(TypeaheadComponent, [{
    key: "render",
    value: function render() {
      var _this2 = this;

      var _this$props4 = this.props,
          children = _this$props4.children,
          className = _this$props4.className,
          instanceRef = _this$props4.instanceRef,
          open = _this$props4.open,
          options = _this$props4.options,
          style = _this$props4.style;
      return /*#__PURE__*/_react["default"].createElement(_Typeahead["default"], (0, _extends2["default"])({}, this.props, {
        options: options,
        ref: instanceRef
      }), function (_ref3) {
        var getInputProps = _ref3.getInputProps,
            props = (0, _objectWithoutProperties2["default"])(_ref3, _excluded2);
        var hideMenu = props.hideMenu,
            isMenuShown = props.isMenuShown,
            results = props.results;

        var auxContent = _this2._renderAux(props);

        return /*#__PURE__*/_react["default"].createElement(RootClose, {
          disabled: open || !isMenuShown,
          onRootClose: hideMenu
        }, function (ref) {
          return /*#__PURE__*/_react["default"].createElement("div", {
            className: (0, _classnames["default"])('rbt', {
              'has-aux': !!auxContent
            }, className),
            ref: ref,
            style: _objectSpread(_objectSpread({}, style), {}, {
              outline: 'none',
              position: 'relative'
            }),
            tabIndex: -1
          }, _this2._renderInput(_objectSpread(_objectSpread({}, getInputProps(_this2.props.inputProps)), {}, {
            referenceElementRef: _this2.referenceElementRef
          }), props), /*#__PURE__*/_react["default"].createElement(_Overlay["default"], (0, _extends2["default"])({}, getOverlayProps(_this2.props), {
            isMenuShown: isMenuShown,
            referenceElement: _this2._referenceElement
          }), function (menuProps) {
            return _this2._renderMenu(results, menuProps, props);
          }), auxContent, (0, _utils.isFunction)(children) ? children(props) : children);
        });
      });
    }
  }]);
  return TypeaheadComponent;
}(_react["default"].Component);

(0, _defineProperty2["default"])(TypeaheadComponent, "propTypes", propTypes);
(0, _defineProperty2["default"])(TypeaheadComponent, "defaultProps", defaultProps);

var _default = /*#__PURE__*/(0, _react.forwardRef)(function (props, ref) {
  return /*#__PURE__*/_react["default"].createElement(TypeaheadComponent, (0, _extends2["default"])({}, props, {
    instanceRef: ref
  }));
});

exports["default"] = _default;