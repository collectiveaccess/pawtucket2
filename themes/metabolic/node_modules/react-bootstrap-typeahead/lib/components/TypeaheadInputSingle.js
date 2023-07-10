"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _react = _interopRequireDefault(require("react"));

var _Hint = _interopRequireDefault(require("./Hint"));

var _Input = _interopRequireDefault(require("./Input"));

var _classNames = _interopRequireDefault(require("../behaviors/classNames"));

var _excluded = ["inputRef", "referenceElementRef", "shouldSelectHint"];

var _default = (0, _classNames["default"])(function (_ref) {
  var inputRef = _ref.inputRef,
      referenceElementRef = _ref.referenceElementRef,
      shouldSelectHint = _ref.shouldSelectHint,
      props = (0, _objectWithoutProperties2["default"])(_ref, _excluded);
  return /*#__PURE__*/_react["default"].createElement(_Hint["default"], {
    shouldSelect: shouldSelectHint
  }, /*#__PURE__*/_react["default"].createElement(_Input["default"], (0, _extends2["default"])({}, props, {
    ref: function ref(node) {
      inputRef(node);
      referenceElementRef(node);
    }
  })));
});

exports["default"] = _default;