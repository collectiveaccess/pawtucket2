import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
import _classCallCheck from "@babel/runtime/helpers/classCallCheck";
import _createClass from "@babel/runtime/helpers/createClass";
import _assertThisInitialized from "@babel/runtime/helpers/assertThisInitialized";
import _inherits from "@babel/runtime/helpers/inherits";
import _possibleConstructorReturn from "@babel/runtime/helpers/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime/helpers/getPrototypeOf";
import _defineProperty from "@babel/runtime/helpers/defineProperty";
var _excluded = ["children", "className", "inputClassName", "inputRef", "placeholder", "referenceElementRef", "selected", "shouldSelectHint"];

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

/* eslint-disable jsx-a11y/no-static-element-interactions */

/* eslint-disable jsx-a11y/click-events-have-key-events */
import cx from 'classnames';
import React from 'react';
import Hint from './Hint';
import Input from './Input';
import { isSelectable } from '../utils';
import withClassNames from '../behaviors/classNames';
import { BACKSPACE } from '../constants';

var TypeaheadInputMulti = /*#__PURE__*/function (_React$Component) {
  _inherits(TypeaheadInputMulti, _React$Component);

  var _super = _createSuper(TypeaheadInputMulti);

  function TypeaheadInputMulti() {
    var _this;

    _classCallCheck(this, TypeaheadInputMulti);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));

    _defineProperty(_assertThisInitialized(_this), "wrapperRef", /*#__PURE__*/React.createRef());

    _defineProperty(_assertThisInitialized(_this), "_input", void 0);

    _defineProperty(_assertThisInitialized(_this), "getInputRef", function (input) {
      _this._input = input;

      _this.props.inputRef(input);
    });

    _defineProperty(_assertThisInitialized(_this), "_handleClick", function (e) {
      // Prevent clicks on the input from bubbling up to the container,
      // which then re-focuses the input.
      e.stopPropagation();

      _this.props.onClick(e);
    });

    _defineProperty(_assertThisInitialized(_this), "_handleContainerClickOrFocus", function (e) {
      // Don't focus the input if it's disabled.
      if (_this.props.disabled) {
        e.currentTarget.blur();
        return;
      } // Move cursor to the end if the user clicks outside the actual input.


      var inputNode = _this._input;

      if (!inputNode) {
        return;
      }

      if (isSelectable(inputNode)) {
        inputNode.selectionStart = inputNode.value.length;
      }

      inputNode.focus();
    });

    _defineProperty(_assertThisInitialized(_this), "_handleKeyDown", function (e) {
      var _this$props = _this.props,
          onKeyDown = _this$props.onKeyDown,
          selected = _this$props.selected,
          value = _this$props.value;

      switch (e.keyCode) {
        case BACKSPACE:
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

  _createClass(TypeaheadInputMulti, [{
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
          props = _objectWithoutProperties(_this$props2, _excluded);

      return /*#__PURE__*/React.createElement("div", {
        className: cx('rbt-input-multi', className),
        disabled: props.disabled,
        onClick: this._handleContainerClickOrFocus,
        onFocus: this._handleContainerClickOrFocus,
        ref: referenceElementRef,
        tabIndex: -1
      }, /*#__PURE__*/React.createElement("div", {
        className: "rbt-input-wrapper",
        ref: this.wrapperRef
      }, children, /*#__PURE__*/React.createElement(Hint, {
        shouldSelect: shouldSelectHint
      }, /*#__PURE__*/React.createElement(Input, _extends({}, props, {
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
}(React.Component);

export default withClassNames(TypeaheadInputMulti);