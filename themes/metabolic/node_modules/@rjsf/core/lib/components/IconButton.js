import _extends from "@babel/runtime-corejs2/helpers/esm/extends";
import _objectWithoutProperties from "@babel/runtime-corejs2/helpers/esm/objectWithoutProperties";
import React from "react";
export default function IconButton(props) {
  var _props$type = props.type,
      type = _props$type === void 0 ? "default" : _props$type,
      icon = props.icon,
      className = props.className,
      otherProps = _objectWithoutProperties(props, ["type", "icon", "className"]);

  return React.createElement("button", _extends({
    type: "button",
    className: "btn btn-".concat(type, " ").concat(className)
  }, otherProps), React.createElement("i", {
    className: "glyphicon glyphicon-".concat(icon)
  }));
}