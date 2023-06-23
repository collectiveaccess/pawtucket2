"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getPlacement = getPlacement;
exports["default"] = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var React = _interopRequireWildcard(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _reactPopper = require("react-popper");

var _utils = require("../utils");

var _constants = require("../constants");

var _excluded = ["styles"],
    _excluded2 = ["ref"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

// `Element` is not defined during server-side rendering, so shim it here.

/* istanbul ignore next */
var SafeElement = typeof Element === 'undefined' ? function () {} : Element;
var propTypes = {
  /**
   * Specify menu alignment. The default value is `justify`, which makes the
   * menu as wide as the input and truncates long values. Specifying `left`
   * or `right` will align the menu to that side and the width will be
   * determined by the length of menu item values.
   */
  align: _propTypes["default"].oneOf((0, _utils.values)(_constants.ALIGN)),
  children: _propTypes["default"].func.isRequired,

  /**
   * Specify whether the menu should appear above the input.
   */
  dropup: _propTypes["default"].bool,

  /**
   * Whether or not to automatically adjust the position of the menu when it
   * reaches the viewport boundaries.
   */
  flip: _propTypes["default"].bool,
  isMenuShown: _propTypes["default"].bool,
  positionFixed: _propTypes["default"].bool,
  referenceElement: _propTypes["default"].instanceOf(SafeElement)
};
var defaultProps = {
  align: _constants.ALIGN.JUSTIFY,
  dropup: false,
  flip: false,
  isMenuShown: false,
  positionFixed: false
};

function getModifiers(_ref) {
  var align = _ref.align,
      flip = _ref.flip;
  return {
    computeStyles: {
      enabled: true,
      fn: function fn(_ref2) {
        var styles = _ref2.styles,
            data = (0, _objectWithoutProperties2["default"])(_ref2, _excluded);
        return _objectSpread(_objectSpread({}, data), {}, {
          styles: _objectSpread(_objectSpread({}, styles), {}, {
            // Use the following condition instead of `align === 'justify'`
            // since it allows the component to fall back to justifying the
            // menu width if `align` is undefined.
            width: align !== _constants.ALIGN.RIGHT && align !== _constants.ALIGN.LEFT ? // Set the popper width to match the target width.
            data.offsets.reference.width : styles.width
          })
        });
      }
    },
    flip: {
      enabled: flip
    },
    preventOverflow: {
      escapeWithReference: true
    }
  };
} // Flow expects a string literal value for `placement`.


var PLACEMENT = {
  bottom: {
    end: 'bottom-end',
    start: 'bottom-start'
  },
  top: {
    end: 'top-end',
    start: 'top-start'
  }
};

function getPlacement(_ref3) {
  var align = _ref3.align,
      dropup = _ref3.dropup;
  var x = align === _constants.ALIGN.RIGHT ? 'end' : 'start';
  var y = dropup ? 'top' : 'bottom';
  return PLACEMENT[y][x];
}

var Overlay = function Overlay(props) {
  var children = props.children,
      isMenuShown = props.isMenuShown,
      positionFixed = props.positionFixed,
      referenceElement = props.referenceElement;

  if (!isMenuShown) {
    return null;
  }

  return /*#__PURE__*/React.createElement(_reactPopper.Popper, {
    modifiers: getModifiers(props),
    placement: getPlacement(props),
    positionFixed: positionFixed,
    referenceElement: referenceElement
  }, function (_ref4) {
    var ref = _ref4.ref,
        popperProps = (0, _objectWithoutProperties2["default"])(_ref4, _excluded2);
    return children(_objectSpread(_objectSpread({}, popperProps), {}, {
      innerRef: ref,
      inputHeight: referenceElement ? referenceElement.offsetHeight : 0
    }));
  });
};

Overlay.propTypes = propTypes;
Overlay.defaultProps = defaultProps;
var _default = Overlay;
exports["default"] = _default;