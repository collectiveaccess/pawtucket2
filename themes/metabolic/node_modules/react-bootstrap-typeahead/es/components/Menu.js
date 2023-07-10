import _classCallCheck from "@babel/runtime/helpers/classCallCheck";
import _createClass from "@babel/runtime/helpers/createClass";
import _inherits from "@babel/runtime/helpers/inherits";
import _possibleConstructorReturn from "@babel/runtime/helpers/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime/helpers/getPrototypeOf";
import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _extends from "@babel/runtime/helpers/extends";

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

import cx from 'classnames';
import PropTypes from 'prop-types';
import React, { Children } from 'react';
import { BaseMenuItem } from './MenuItem';
import { preventInputBlur } from '../utils';
import { checkPropType, isRequiredForA11y } from '../propTypes';

var MenuDivider = function MenuDivider(props) {
  return /*#__PURE__*/React.createElement("div", {
    className: "dropdown-divider",
    role: "separator"
  });
};

var MenuHeader = function MenuHeader(props) {
  return (
    /*#__PURE__*/
    // eslint-disable-next-line jsx-a11y/role-has-required-aria-props
    React.createElement("div", _extends({}, props, {
      className: "dropdown-header",
      role: "heading"
    }))
  );
};

var propTypes = {
  'aria-label': PropTypes.string,

  /**
   * Message to display in the menu if there are no valid results.
   */
  emptyLabel: PropTypes.node,

  /**
   * Needed for accessibility.
   */
  id: checkPropType(PropTypes.oneOfType([PropTypes.number, PropTypes.string]), isRequiredForA11y),

  /**
   * Maximum height of the dropdown menu.
   */
  maxHeight: PropTypes.string
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
  _inherits(Menu, _React$Component);

  var _super = _createSuper(Menu);

  function Menu() {
    _classCallCheck(this, Menu);

    return _super.apply(this, arguments);
  }

  _createClass(Menu, [{
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
      var contents = Children.count(children) === 0 ? /*#__PURE__*/React.createElement(BaseMenuItem, {
        disabled: true,
        role: "option"
      }, emptyLabel) : children;
      return (
        /*#__PURE__*/

        /* eslint-disable jsx-a11y/interactive-supports-focus */
        React.createElement("div", {
          "aria-label": this.props['aria-label'],
          className: cx('rbt-menu', 'dropdown-menu', 'show', className),
          id: id,
          key: // Force a re-render if the text changes to ensure that menu
          // positioning updates correctly.
          text,
          onMouseDown: // Prevent input from blurring when clicking on the menu scrollbar.
          preventInputBlur,
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
}(React.Component);

_defineProperty(Menu, "propTypes", propTypes);

_defineProperty(Menu, "defaultProps", defaultProps);

_defineProperty(Menu, "Divider", MenuDivider);

_defineProperty(Menu, "Header", MenuHeader);

export default Menu;