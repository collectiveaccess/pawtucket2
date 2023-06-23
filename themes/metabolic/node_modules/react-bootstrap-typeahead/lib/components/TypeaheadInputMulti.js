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

var _assertThisInitialized2 = _interopRequireDefault(require("@babel/runtime/helpers/assertThisInitialized"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _classnames = _interopRequireDefault(require("classnames"));

var _react = _interopRequireDefault(require("react"));

var _Hint = _interopRequireDefault(require("./Hint"));

var _Input = _interopRequireDefault(require("./Input"));

var _utils = require("../utils");

var _classNames = _interopRequireDefault(require("../behaviors/classNames"));

var _constants = require("../constants");

var _excluded = ["children", "className", "inputClassName", "inputRef", "placeholder", "referenceElementRef", "selected", "shouldSelectHint"];

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

var TypeaheadInputMulti = /*#__PURE__*/function (_React$Component) {
  (0, _inherits2["default"])(TypeaheadInputMulti, _React$Component);

  var _super = _createSuper(TypeaheadInputMulti);

  function TypeaheadInputMulti() {
    var _this;

    (0, _classCallCheck2["default"])(this, TypeaheadInputMulti);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "wrapperRef", /*#__PURE__*/_react["default"].createRef());
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_input", void 0);
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "getInputRef", function (input) {
      _this._input = input;

      _this.props.inputRef(input);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_handleClick", function (e) {
      // Prevent clicks on the input from bubbling up to the container,
      // which then re-focuses the input.
      e.stopPropagation();

      _this.props.onClick(e);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_handleContainerClickOrFocus", function (e) {
      // Don't focus the input if it's disabled.
      if (_this.props.disabled) {
        e.currentTarget.blur();
        return;
      } // Move cursor to the end if the user clicks outside the actual input.


      var inputNode = _this._input;

      if (!inputNode) {
        return;
      }

      if ((0, _utils.isSelectable)(inputNode)) {
        inputNode.selectionStart = inputNode.value.length;
      }

      inputNode.focus();
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "_handleKeyDown", function (e) {
      var _this$props = _this.props,
          onKeyDown = _this$props.onKeyDown,
          selected = _this$props.selected,
          value = _this$props.value;

      switch (e.keyCode) {
        case _constants.BACKSPACE:
          if (e.currentTarget === _this._input && selected.length && !value) {
            // Prevent browser from going back.
            e.preventDefault(); // If the input is selected and there is no text, focus the last
            // token when the user hits backspace.

            if (_this.wrapperRef.current) {
              var children = _this.wrapperRef.current.children;
              var lastToken = children[children.length - 2];
              lastToken && lastToken.focus();
            }
          }

          break;

        default:
          break;
      }

      onKeyDown(e);
    });
    return _this;
  }

  (0, _createClass2["default"])(TypeaheadInputMulti, [{
    key: "render",
    value: function render() {
      var _this$props2 = this.props,
          children = _this$props2.children,
          className = _this$props2.className,
          inputClassName = _this$props2.inputClassName,
          inputRef = _this$props2.inputRef,
          placeholder = _this$props2.placeholder,
          referenceElementRef = _this$props2.referenceElementRef,
          selected = _this$props2.selected,
          shouldSelectHint = _this$props2.shouldSelectHint,
          props = (0, _objectWithoutProperties2["default"])(_this$props2, _excluded);
      return /*#__PURE__*/_react["default"].createElement("div", {
        className: (0, _classnames["default"])('rbt-input-multi', className),
        disabled: props.disabled,
        onClick: this._handleContainerClickOrFocus,
        onFocus: this._handleContainerClickOrFocus,
        ref: referenceElementRef,
        tabIndex: -1
      }, /*#__PURE__*/_react["default"].createElement("div", {
        className: "rbt-input-wrapper",
        ref: this.wrapperRef
      }, children, /*#__PURE__*/_react["default"].createElement(_Hint["default"], {
        shouldSelect: shouldSelectHint
      }, /*#__PURE__*/_react["default"].createElement(_Input["default"], (0, _extends2["default"])({}, props, {
        className: inputClassName,
        onClick: this._handleClick,
        onKeyDown: this._handleKeyDown,
        placeholder: selected.length ? '' : placeholder,
        ref: this.getInputRef,
        style: {
          backgroundColor: 'transparent',
          border: 0,
          boxShadow: 'none',
          cursor: 'inherit',
          outline: 'none',
          padding: 0,
          width: '100%',
          zIndex: 1
        }
      })))));
    }
  }]);
  return TypeaheadInputMulti;
}(_react["default"].Component);

var _default = (0, _classNames["default"])(TypeaheadInputMulti);

exports["default"] = _default;