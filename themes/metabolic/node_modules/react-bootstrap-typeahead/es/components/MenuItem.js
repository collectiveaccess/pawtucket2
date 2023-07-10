import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["active", "children", "className", "disabled", "onClick"];
import cx from 'classnames';
import React from 'react';
import { withItem } from '../behaviors/item';
var BaseMenuItem = /*#__PURE__*/React.forwardRef(function (_ref, ref) {
  var active = _ref.active,
      children = _ref.children,
      className = _ref.className,
      disabled = _ref.disabled,
      _onClick = _ref.onClick,
      props = _objectWithoutProperties(_ref, _excluded);

  return /*#__PURE__*/React.createElement("a", _extends({}, props, {
    className: cx('dropdown-item', {
      active: active,
      disabled: disabled
    }, className),
    href: props.href || '#',
    onClick: function onClick(e) {
      e.preventDefault();
      !disabled && _onClick && _onClick(e);
    },
    ref: ref
  }), children);
});
export { BaseMenuItem };
export default withItem(BaseMenuItem);