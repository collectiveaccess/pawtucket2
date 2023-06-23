"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _react = _interopRequireWildcard(require("react"));

var _usePrevious = _interopRequireDefault(require("@restart/hooks/usePrevious"));

var _Context = require("./Context");

var _utils = require("../utils");

var _constants = require("../constants");

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

var inputPropKeys = ['activeIndex', 'disabled', 'id', 'inputRef', 'isFocused', 'isMenuShown', 'multiple', 'onBlur', 'onChange', 'onFocus', 'onKeyDown', 'placeholder'];
var propKeys = ['activeIndex', 'hideMenu', 'isMenuShown', 'labelKey', 'onClear', 'onHide', 'onRemove', 'results', 'selected', 'text', 'toggleMenu'];
var contextKeys = ['activeIndex', 'id', 'initialItem', 'inputNode', 'onActiveItemChange', 'onAdd', 'onInitialItemChange', 'onMenuItemClick', 'selectHintOnEnter', 'setItem'];

var TypeaheadManager = function TypeaheadManager(props) {
  var allowNew = props.allowNew,
      children = props.children,
      initialItem = props.initialItem,
      isMenuShown = props.isMenuShown,
      onAdd = props.onAdd,
      onInitialItemChange = props.onInitialItemChange,
      onKeyDown = props.onKeyDown,
      onMenuToggle = props.onMenuToggle,
      results = props.results;
  var prevProps = (0, _usePrevious["default"])(props);
  (0, _react.useEffect)(function () {
    // Clear the initial item when there are no results.
    if (!(allowNew || results.length)) {
      onInitialItemChange(null);
    }
  });
  (0, _react.useEffect)(function () {
    if (prevProps && prevProps.isMenuShown !== isMenuShown) {
      onMenuToggle(isMenuShown);
    }
  });

  var handleKeyDown = function handleKeyDown(e) {
    switch (e.keyCode) {
      case _constants.RETURN:
        if (initialItem && (0, _utils.getIsOnlyResult)(props)) {
          onAdd(initialItem);
        }

        break;

      default:
        break;
    }

    onKeyDown(e);
  };

  var childProps = _objectSpread(_objectSpread({}, (0, _utils.pick)(props, propKeys)), {}, {
    getInputProps: (0, _utils.getInputProps)(_objectSpread(_objectSpread({}, (0, _utils.pick)(props, inputPropKeys)), {}, {
      onKeyDown: handleKeyDown,
      value: (0, _utils.getInputText)(props)
    }))
  });

  var contextValue = _objectSpread(_objectSpread({}, (0, _utils.pick)(props, contextKeys)), {}, {
    hintText: (0, _utils.getHintText)(props),
    isOnlyResult: (0, _utils.getIsOnlyResult)(props)
  });

  return /*#__PURE__*/_react["default"].createElement(_Context.TypeaheadContext.Provider, {
    value: contextValue
  }, children(childProps));
};

var _default = TypeaheadManager;
exports["default"] = _default;