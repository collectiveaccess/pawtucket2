import _extends from "@babel/runtime/helpers/extends";
import cx from 'classnames';
import React from 'react';
var Input = /*#__PURE__*/React.forwardRef(function (props, ref) {
  return /*#__PURE__*/React.createElement("input", _extends({}, props, {
    className: cx('rbt-input-main', props.className),
    ref: ref
  }));
});
export default Input;