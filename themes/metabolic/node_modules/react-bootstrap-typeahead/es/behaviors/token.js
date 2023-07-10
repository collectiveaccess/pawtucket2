import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _slicedToArray from "@babel/runtime/helpers/slicedToArray";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["onBlur", "onClick", "onFocus", "onRemove", "option"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

import PropTypes from 'prop-types';
import React, { useState } from 'react';
import useRootClose from "react-overlays/useRootClose";
import { getDisplayName, isFunction, warn } from '../utils';
import { BACKSPACE } from '../constants';
import { optionType } from '../propTypes';
var propTypes = {
  onBlur: PropTypes.func,
  onClick: PropTypes.func,
  onFocus: PropTypes.func,
  onRemove: PropTypes.func,
  option: optionType.isRequired
};
export var useToken = function useToken(_ref) {
  var onBlur = _ref.onBlur,
      onClick = _ref.onClick,
      onFocus = _ref.onFocus,
      onRemove = _ref.onRemove,
      option = _ref.option,
      props = _objectWithoutProperties(_ref, _excluded);

  var _useState = useState(false),
      _useState2 = _slicedToArray(_useState, 2),
      active = _useState2[0],
      setActive = _useState2[1];

  var _useState3 = useState(null),
      _useState4 = _slicedToArray(_useState3, 2),
      rootElement = _useState4[0],
      attachRef = _useState4[1];

  var handleActiveChange = function handleActiveChange(e, isActive, callback) {
    e.stopPropagation();
    setActive(isActive);
    typeof callback === 'function' && callback(e);
  };

  var handleBlur = function handleBlur(e) {
    handleActiveChange(e, false, onBlur);
  };

  var handleClick = function handleClick(e) {
    handleActiveChange(e, true, onClick);
  };

  var handleFocus = function handleFocus(e) {
    handleActiveChange(e, true, onFocus);
  };

  var handleRemove = function handleRemove() {
    onRemove && onRemove(option);
  };

  var handleKeyDown = function handleKeyDown(e) {
    switch (e.keyCode) {
      case BACKSPACE:
        if (active) {
          // Prevent backspace keypress from triggering the browser "back"
          // action.
          e.preventDefault();
          handleRemove();
        }

        break;

      default:
        break;
    }
  };

  useRootClose(rootElement, handleBlur, _objectSpread(_objectSpread({}, props), {}, {
    disabled: !active
  }));
  return _objectSpread(_objectSpread({}, props), {}, {
    active: active,
    onBlur: handleBlur,
    onClick: handleClick,
    onFocus: handleFocus,
    onKeyDown: handleKeyDown,
    onRemove: isFunction(onRemove) ? handleRemove : undefined,
    ref: attachRef
  });
};
export var withToken = function withToken(Component) {
  var displayName = "withToken(".concat(getDisplayName(Component), ")");

  var WrappedToken = function WrappedToken(props) {
    return /*#__PURE__*/React.createElement(Component, useToken(props));
  };

  WrappedToken.displayName = displayName;
  WrappedToken.propTypes = propTypes;
  return WrappedToken;
};
export default function tokenContainer(Component) {
  /* istanbul ignore next */
  warn(false, 'The `tokenContainer` export is deprecated; use `withToken` instead.');
  /* istanbul ignore next */

  return withToken(Component);
}