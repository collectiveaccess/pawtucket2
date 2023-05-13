import React from "react";
import IconButton from "./IconButton";
export default function AddButton(_ref) {
  var className = _ref.className,
      onClick = _ref.onClick,
      disabled = _ref.disabled;
  return React.createElement("div", {
    className: "row"
  }, React.createElement("p", {
    className: "col-xs-3 col-xs-offset-9 text-right ".concat(className)
  }, React.createElement(IconButton, {
    type: "info",
    icon: "plus",
    className: "btn-add col-xs-12",
    "aria-label": "Add",
    tabIndex: "0",
    onClick: onClick,
    disabled: disabled
  })));
}