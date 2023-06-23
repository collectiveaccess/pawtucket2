"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.useTypeaheadContext = exports.TypeaheadContext = void 0;

var _react = require("react");

var _utils = require("../utils");

var TypeaheadContext = /*#__PURE__*/(0, _react.createContext)({
  activeIndex: -1,
  hintText: '',
  id: '',
  initialItem: null,
  inputNode: null,
  isOnlyResult: false,
  onActiveItemChange: _utils.noop,
  onAdd: _utils.noop,
  onInitialItemChange: _utils.noop,
  onMenuItemClick: _utils.noop,
  selectHintOnEnter: undefined,
  setItem: _utils.noop
});
exports.TypeaheadContext = TypeaheadContext;

var useTypeaheadContext = function useTypeaheadContext() {
  return (0, _react.useContext)(TypeaheadContext);
};

exports.useTypeaheadContext = useTypeaheadContext;