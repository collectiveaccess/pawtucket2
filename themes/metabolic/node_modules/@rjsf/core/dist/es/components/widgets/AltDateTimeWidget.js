import _objectSpread from "@babel/runtime-corejs2/helpers/esm/objectSpread";
import _extends from "@babel/runtime-corejs2/helpers/esm/extends";
import React from "react";
import PropTypes from "prop-types";
import AltDateWidget from "./AltDateWidget";

function AltDateTimeWidget(props) {
  var AltDateWidget = props.registry.widgets.AltDateWidget;
  return React.createElement(AltDateWidget, _extends({
    time: true
  }, props));
}

if (process.env.NODE_ENV !== "production") {
  AltDateTimeWidget.propTypes = {
    schema: PropTypes.object.isRequired,
    id: PropTypes.string.isRequired,
    value: PropTypes.string,
    required: PropTypes.bool,
    onChange: PropTypes.func,
    options: PropTypes.object
  };
}

AltDateTimeWidget.defaultProps = _objectSpread({}, AltDateWidget.defaultProps, {
  time: true
});
export default AltDateTimeWidget;