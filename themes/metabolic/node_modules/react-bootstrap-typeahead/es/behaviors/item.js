import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["label", "onClick", "option", "position"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

import scrollIntoView from 'scroll-into-view-if-needed';
import React, { useCallback, useEffect, useRef } from 'react';
import PropTypes from 'prop-types';
import { useTypeaheadContext } from '../core/Context';
import { getDisplayName, getMenuItemId, preventInputBlur, warn } from '../utils';
import { optionType } from '../propTypes';
var propTypes = {
  option: optionType.isRequired,
  position: PropTypes.number
};
export var useItem = function useItem(_ref) {
  var label = _ref.label,
      onClick = _ref.onClick,
      option = _ref.option,
      position = _ref.position,
      props = _objectWithoutProperties(_ref, _excluded);

  var _useTypeaheadContext = useTypeaheadContext(),
      activeIndex = _useTypeaheadContext.activeIndex,
      id = _useTypeaheadContext.id,
      isOnlyResult = _useTypeaheadContext.isOnlyResult,
      onActiveItemChange = _useTypeaheadContext.onActiveItemChange,
      onInitialItemChange = _useTypeaheadContext.onInitialItemChange,
      onMenuItemClick = _useTypeaheadContext.onMenuItemClick,
      setItem = _useTypeaheadContext.setItem;

  var itemRef = useRef(null);
  useEffect(function () {
    if (position === 0) {
      onInitialItemChange(option);
    }
  });
  useEffect(function () {
    if (position === activeIndex) {
      onActiveItemChange(option); // Automatically scroll the menu as the user keys through it.

      var node = itemRef.current;
      node && scrollIntoView(node, {
        block: 'nearest',
        boundary: node.parentNode,
        inline: 'nearest',
        scrollMode: 'if-needed'
      });
    }
  });
  var handleClick = useCallback(function (e) {
    onMenuItemClick(option, e);
    onClick && onClick(e);
  }, [onClick, onMenuItemClick, option]);
  var active = isOnlyResult || activeIndex === position; // Update the item's position in the item stack.

  setItem(option, position);
  return _objectSpread(_objectSpread({}, props), {}, {
    active: active,
    'aria-label': label,
    'aria-selected': active,
    id: getMenuItemId(id, position),
    onClick: handleClick,
    onMouseDown: preventInputBlur,
    ref: itemRef,
    role: 'option'
  });
};
export var withItem = function withItem(Component) {
  var displayName = "withItem(".concat(getDisplayName(Component), ")");

  var WrappedMenuItem = function WrappedMenuItem(props) {
    return /*#__PURE__*/React.createElement(Component, useItem(props));
  };

  WrappedMenuItem.displayName = displayName;
  WrappedMenuItem.propTypes = propTypes;
  return WrappedMenuItem;
};
export default function menuItemContainer(Component) {
  /* istanbul ignore next */
  warn(false, 'The `menuItemContainer` export is deprecated; use `withItem` instead.');
  /* istanbul ignore next */

  return withItem(Component);
}