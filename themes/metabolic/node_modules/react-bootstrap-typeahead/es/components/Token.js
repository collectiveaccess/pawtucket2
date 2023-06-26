import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["active", "children", "className", "onRemove", "tabIndex"];
import cx from 'classnames';
import React, { forwardRef } from 'react';
import ClearButton from './ClearButton';
import { withToken } from '../behaviors/token';
import { isFunction } from '../utils';
var InteractiveToken = /*#__PURE__*/forwardRef(function (_ref, ref) {
  var active = _ref.active,
      children = _ref.children,
      className = _ref.className,
      onRemove = _ref.onRemove,
      tabIndex = _ref.tabIndex,
      props = _objectWithoutProperties(_ref, _excluded);

  return /*#__PURE__*/React.createElement("div", _extends({}, props, {
    className: cx('rbt-token', 'rbt-token-removeable', {
      'rbt-token-active': !!active
    }, className),
    ref: ref,
    tabIndex: tabIndex || 0
  }), children, /*#__PURE__*/React.createElement(ClearButton, {
    className: "rbt-token-remove-button",
    label: "Remove",
    onClick: onRemove,
    tabIndex: -1
  }));
});

var StaticToken = function StaticToken(_ref2) {
  var children = _ref2.children,
      className = _ref2.className,
      disabled = _ref2.disabled,
      href = _ref2.href;
  var classnames = cx('rbt-token', {
    'rbt-token-disabled': disabled
  }, className);

  if (href && !disabled) {
    return /*#__PURE__*/React.createElement("a", {
      className: classnames,
      href: href
    }, children);
  }

  return /*#__PURE__*/React.createElement("div", {
    className: classnames
  }, children);
};
/**
 * Token
 *
 * Individual token component, generally displayed within the TokenizerInput
 * component, but can also be rendered on its own.
 */


var Token = /*#__PURE__*/forwardRef(function (props, ref) {
  var disabled = props.disabled,
      onRemove = props.onRemove,
      readOnly = props.readOnly;
  return !disabled && !readOnly && isFunction(onRemove) ? /*#__PURE__*/React.createElement(InteractiveToken, _extends({}, props, {
    ref: ref
  })) : /*#__PURE__*/React.createElement(StaticToken, props);
});
export default withToken(Token);