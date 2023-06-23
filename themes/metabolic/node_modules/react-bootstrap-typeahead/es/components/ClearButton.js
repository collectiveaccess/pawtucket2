import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["className", "label", "onClick", "onKeyDown", "size"];
import cx from 'classnames';
import React from 'react';
import PropTypes from 'prop-types';
import { isSizeLarge, noop } from '../utils';
import { sizeType } from '../propTypes';
import { BACKSPACE } from '../constants';
var propTypes = {
  label: PropTypes.string,
  onClick: PropTypes.func,
  onKeyDown: PropTypes.func,
  size: sizeType
};
var defaultProps = {
  label: 'Clear',
  onClick: noop,
  onKeyDown: noop
};

/**
 * ClearButton
 *
 * http://getbootstrap.com/css/#helper-classes-close
 */
var ClearButton = function ClearButton(_ref) {
  var className = _ref.className,
      label = _ref.label,
      _onClick = _ref.onClick,
      _onKeyDown = _ref.onKeyDown,
      size = _ref.size,
      props = _objectWithoutProperties(_ref, _excluded);

  return /*#__PURE__*/React.createElement("button", _extends({}, props, {
    "aria-label": label,
    className: cx('close', 'rbt-close', {
      'rbt-close-lg': isSizeLarge(size)
    }, className),
    onClick: function onClick(e) {
      e.stopPropagation();

      _onClick(e);
    },
    onKeyDown: function onKeyDown(e) {
      // Prevent browser from navigating back.
      if (e.keyCode === BACKSPACE) {
        e.preventDefault();
      }

      _onKeyDown(e);
    },
    type: "button"
  }), /*#__PURE__*/React.createElement("span", {
    "aria-hidden": "true"
  }, "\xD7"), /*#__PURE__*/React.createElement("span", {
    className: "sr-only visually-hidden"
  }, label));
};

ClearButton.propTypes = propTypes;
ClearButton.defaultProps = defaultProps;
export default ClearButton;