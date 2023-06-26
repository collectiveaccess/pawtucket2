"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = isShown;

function isShown(props) {
  var open = props.open,
      minLength = props.minLength,
      showMenu = props.showMenu,
      text = props.text; // If menu visibility is controlled via props, that value takes precedence.

  if (open || open === false) {
    return open;
  }

  if (text.length < minLength) {
    return false;
  }

  return showMenu;
}