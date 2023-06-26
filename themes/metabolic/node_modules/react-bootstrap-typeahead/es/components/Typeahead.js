import _classCallCheck from "@babel/runtime/helpers/classCallCheck";
import _createClass from "@babel/runtime/helpers/createClass";
import _assertThisInitialized from "@babel/runtime/helpers/assertThisInitialized";
import _inherits from "@babel/runtime/helpers/inherits";
import _possibleConstructorReturn from "@babel/runtime/helpers/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime/helpers/getPrototypeOf";
import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _slicedToArray from "@babel/runtime/helpers/slicedToArray";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
import _extends from "@babel/runtime/helpers/extends";
var _excluded = ["children", "onRootClose"],
    _excluded2 = ["getInputProps"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

import cx from 'classnames';
import PropTypes from 'prop-types';
import React, { forwardRef, useState } from 'react';
import useRootClose from "react-overlays/useRootClose";
import Typeahead from '../core/Typeahead';
import ClearButton from './ClearButton';
import Loader from './Loader';
import Overlay from './Overlay';
import Token from './Token';
import TypeaheadInputMulti from './TypeaheadInputMulti';
import TypeaheadInputSingle from './TypeaheadInputSingle';
import TypeaheadMenu from './TypeaheadMenu';
import { getOptionLabel, isFunction, isSizeLarge, pick, preventInputBlur } from '../utils';
import { checkPropType, inputPropsType, sizeType } from '../propTypes';
var propTypes = {
  /**
   * Displays a button to clear the input when there are selections.
   */
  clearButton: PropTypes.bool,

  /**
   * Props to be applied directly to the input. `onBlur`, `onChange`,
   * `onFocus`, and `onKeyDown` are ignored.
   */
  inputProps: checkPropType(PropTypes.object, inputPropsType),

  /**
   * Bootstrap 4 only. Adds the `is-invalid` classname to the `form-control`.
   */
  isInvalid: PropTypes.bool,

  /**
   * Indicate whether an asynchronous data fetch is happening.
   */
  isLoading: PropTypes.bool,

  /**
   * Bootstrap 4 only. Adds the `is-valid` classname to the `form-control`.
   */
  isValid: PropTypes.bool,

  /**
   * Callback for custom input rendering.
   */
  renderInput: PropTypes.func,

  /**
   * Callback for custom menu rendering.
   */
  renderMenu: PropTypes.func,

  /**
   * Callback for custom menu rendering.
   */
  renderToken: PropTypes.func,

  /**
   * Specifies the size of the input.
   */
  size: sizeType
};
var defaultProps = {
  clearButton: false,
  inputProps: {},
  isInvalid: false,
  isLoading: false,
  isValid: false,
  renderMenu: function renderMenu(results, menuProps, props) {
    return /*#__PURE__*/React.createElement(TypeaheadMenu, _extends({}, menuProps, {
      labelKey: props.labelKey,
      options: results,
      text: props.text
    }));
  },
  renderToken: function renderToken(option, props, idx) {
    return /*#__PURE__*/React.createElement(Token, {
      disabled: props.disabled,
      key: idx,
      onRemove: props.onRemove,
      option: option,
      tabIndex: props.tabIndex
    }, getOptionLabel(option, props.labelKey));
  }
};

function getOverlayProps(props) {
  return pick(props, ['align', 'dropup', 'flip', 'positionFixed']);
}

var RootClose = function RootClose(_ref) {
  var children = _ref.children,
      onRootClose = _ref.onRootClose,
      props = _objectWithoutProperties(_ref, _excluded);

  var _useState = useState(null),
      _useState2 = _slicedToArray(_useState, 2),
      rootElement = _useState2[0],
      attachRef = _useState2[1];

  useRootClose(rootElement, onRootClose, props);
  return children(attachRef);
};

var TypeaheadComponent = /*#__PURE__*/function (_React$Component) {
  _inherits(TypeaheadComponent, _React$Component);

  var _super = _createSuper(TypeaheadComponent);

  function TypeaheadComponent() {
    var _this;

    _classCallCheck(this, TypeaheadComponent);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));

    _defineProperty(_assertThisInitialized(_this), "_referenceElement", void 0);

    _defineProperty(_assertThisInitialized(_this), "referenceElementRef", function (referenceElement) {
      _this._referenceElement = referenceElement;
    });

    _defineProperty(_assertThisInitialized(_this), "_renderInput", function (inputProps, props) {
      var _this$props = _this.props,
          isInvalid = _this$props.isInvalid,
          isValid = _this$props.isValid,
          multiple = _this$props.multiple,
          renderInput = _this$props.renderInput,
          renderToken = _this$props.renderToken,
          size = _this$props.size;

      if (isFunction(renderInput)) {
        return renderInput(inputProps, props);
      }

      var commonProps = _objectSpread(_objectSpread({}, inputProps), {}, {
        isInvalid: isInvalid,
        isValid: isValid,
        size: size
      });

      if (!multiple) {
        return /*#__PURE__*/React.createElement(TypeaheadInputSingle, commonProps);
      }

      var labelKey = props.labelKey,
          onRemove = props.onRemove,
          selected = props.selected;
      return /*#__PURE__*/React.createElement(TypeaheadInputMulti, _extends({}, commonProps, {
        selected: selected
      }), selected.map(function (option, idx) {
        return renderToken(option, _objectSpread(_objectSpread({}, commonProps), {}, {
          labelKey: labelKey,
          onRemove: onRemove
        }), idx);
      }));
    });

    _defineProperty(_assertThisInitialized(_this), "_renderMenu", function (results, menuProps, props) {
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

    _defineProperty(_assertThisInitialized(_this), "_renderAux", function (_ref2) {
      var onClear = _ref2.onClear,
          selected = _ref2.selected;
      var _this$props3 = _this.props,
          clearButton = _this$props3.clearButton,
          disabled = _this$props3.disabled,
          isLoading = _this$props3.isLoading,
          size = _this$props3.size;
      var content;

      if (isLoading) {
        content = /*#__PURE__*/React.createElement(Loader, null);
      } else if (clearButton && !disabled && selected.length) {
        content = /*#__PURE__*/React.createElement(ClearButton, {
          onClick: onClear,
          onFocus: function onFocus(e) {
            // Prevent the main input from auto-focusing again.
            e.stopPropagation();
          },
          onMouseDown: preventInputBlur,
          size: size
        });
      }

      return content ? /*#__PURE__*/React.createElement("div", {
        className: cx('rbt-aux', {
          'rbt-aux-lg': isSizeLarge(size)
        })
      }, content) : null;
    });

    return _this;
  }

  _createClass(TypeaheadComponent, [{
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
      return /*#__PURE__*/React.createElement(Typeahead, _extends({}, this.props, {
        options: options,
        ref: instanceRef
      }), function (_ref3) {
        var getInputProps = _ref3.getInputProps,
            props = _objectWithoutProperties(_ref3, _excluded2);

        var hideMenu = props.hideMenu,
            isMenuShown = props.isMenuShown,
            results = props.results;

        var auxContent = _this2._renderAux(props);

        return /*#__PURE__*/React.createElement(RootClose, {
          disabled: open || !isMenuShown,
          onRootClose: hideMenu
        }, function (ref) {
          return /*#__PURE__*/React.createElement("div", {
            className: cx('rbt', {
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
          }), props), /*#__PURE__*/React.createElement(Overlay, _extends({}, getOverlayProps(_this2.props), {
            isMenuShown: isMenuShown,
            referenceElement: _this2._referenceElement
          }), function (menuProps) {
            return _this2._renderMenu(results, menuProps, props);
          }), auxContent, isFunction(children) ? children(props) : children);
        });
      });
    }
  }]);

  return TypeaheadComponent;
}(React.Component);

_defineProperty(TypeaheadComponent, "propTypes", propTypes);

_defineProperty(TypeaheadComponent, "defaultProps", defaultProps);

export default /*#__PURE__*/forwardRef(function (props, ref) {
  return /*#__PURE__*/React.createElement(TypeaheadComponent, _extends({}, props, {
    instanceRef: ref
  }));
});