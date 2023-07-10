"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _getOptionLabel = _interopRequireDefault(require("./getOptionLabel"));

var _nodash = require("./nodash");

function getInputText(props) {
  var activeItem = props.activeItem,
      labelKey = props.labelKey,
      multiple = props.multiple,
      selected = props.selected,
      text = props.text;

  if (activeItem) {
    // Display the input value if the pagination item is active.
    return (0, _getOptionLabel["default"])(activeItem, labelKey);
  }

  var selectedItem = !multiple && !!selected.length && (0, _nodash.head)(selected);

  if (selectedItem) {
    return (0, _getOptionLabel["default"])(selectedItem, labelKey);
  }

  return text;
}

var _default = getInputText;
exports["default"] = _default;