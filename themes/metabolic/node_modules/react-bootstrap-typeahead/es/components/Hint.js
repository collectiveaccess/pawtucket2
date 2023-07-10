import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
import _defineProperty from "@babel/runtime/helpers/defineProperty";
var _excluded = ["className"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

import invariant from 'invariant';
import React, { cloneElement, useEffect, useRef } from 'react';
import { useTypeaheadContext } from '../core/Context';
import { isSelectable } from '../utils';
import { RETURN, RIGHT, TAB } from '../constants';

// IE doesn't seem to get the composite computed value (eg: 'padding',
// 'borderStyle', etc.), so generate these from the individual values.
function interpolateStyle(styles, attr) {
  var subattr = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';

  // Title-case the sub-attribute.
  if (subattr) {
    /* eslint-disable-next-line no-param-reassign */
    subattr = subattr.replace(subattr[0], subattr[0].toUpperCase());
  }

  return ['Top', 'Right', 'Bottom', 'Left'].map(function (dir) {
    return styles[attr + dir + subattr];
  }).join(' ');
}

function copyStyles(inputNode, hintNode) {
  if (!inputNode || !hintNode) {
    return;
  }

  var inputStyle = window.getComputedStyle(inputNode);
  /* eslint-disable no-param-reassign */

  hintNode.style.borderStyle = interpolateStyle(inputStyle, 'border', 'style');
  hintNode.style.borderWidth = interpolateStyle(inputStyle, 'border', 'width');
  hintNode.style.fontSize = inputStyle.fontSize;
  hintNode.style.height = inputStyle.height;
  hintNode.style.lineHeight = inputStyle.lineHeight;
  hintNode.style.margin = interpolateStyle(inputStyle, 'margin');
  hintNode.style.padding = interpolateStyle(inputStyle, 'padding');
  /* eslint-enable no-param-reassign */
}

export function defaultShouldSelect(e, state) {
  var shouldSelectHint = false;
  var currentTarget = e.currentTarget,
      keyCode = e.keyCode;

  if (keyCode === RIGHT) {
    // For selectable input types ("text", "search"), only select the hint if
    // it's at the end of the input value. For non-selectable types ("email",
    // "number"), always select the hint.
    shouldSelectHint = isSelectable(currentTarget) ? currentTarget.selectionStart === currentTarget.value.length : true;
  }

  if (keyCode === TAB) {
    // Prevent input from blurring on TAB.
    e.preventDefault();
    shouldSelectHint = true;
  }

  if (keyCode === RETURN) {
    shouldSelectHint = !!state.selectHintOnEnter;
  }

  return typeof state.shouldSelect === 'function' ? state.shouldSelect(shouldSelectHint, e) : shouldSelectHint;
}
export var useHint = function useHint(_ref) {
  var children = _ref.children,
      shouldSelect = _ref.shouldSelect;
  !(React.Children.count(children) === 1) ? process.env.NODE_ENV !== "production" ? invariant(false, '`useHint` expects one child.') : invariant(false) : void 0;

  var _useTypeaheadContext = useTypeaheadContext(),
      hintText = _useTypeaheadContext.hintText,
      initialItem = _useTypeaheadContext.initialItem,
      inputNode = _useTypeaheadContext.inputNode,
      onAdd = _useTypeaheadContext.onAdd,
      selectHintOnEnter = _useTypeaheadContext.selectHintOnEnter;

  var hintRef = useRef(null);

  var onKeyDown = function onKeyDown(e) {
    if (hintText && initialItem && defaultShouldSelect(e, {
      selectHintOnEnter: selectHintOnEnter,
      shouldSelect: shouldSelect
    })) {
      onAdd(initialItem);
    }

    children.props.onKeyDown && children.props.onKeyDown(e);
  };

  useEffect(function () {
    copyStyles(inputNode, hintRef.current);
  });
  return {
    child: /*#__PURE__*/cloneElement(children, _objectSpread(_objectSpread({}, children.props), {}, {
      onKeyDown: onKeyDown
    })),
    hintRef: hintRef,
    hintText: hintText
  };
};

var Hint = function Hint(_ref2) {
  var className = _ref2.className,
      props = _objectWithoutProperties(_ref2, _excluded);

  var _useHint = useHint(props),
      child = _useHint.child,
      hintRef = _useHint.hintRef,
      hintText = _useHint.hintText;

  return /*#__PURE__*/React.createElement("div", {
    className: className,
    style: {
      display: 'flex',
      flex: 1,
      height: '100%',
      position: 'relative'
    }
  }, child, /*#__PURE__*/React.createElement("input", {
    "aria-hidden": true,
    className: "rbt-input-hint",
    ref: hintRef,
    readOnly: true,
    style: {
      backgroundColor: 'transparent',
      borderColor: 'transparent',
      boxShadow: 'none',
      color: 'rgba(0, 0, 0, 0.54)',
      left: 0,
      pointerEvents: 'none',
      position: 'absolute',
      top: 0,
      width: '100%'
    },
    tabIndex: -1,
    value: hintText
  }));
};

export default Hint;