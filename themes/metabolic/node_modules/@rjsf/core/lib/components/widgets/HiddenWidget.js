import React from "react";
import PropTypes from "prop-types";

function HiddenWidget(_ref) {
  var id = _ref.id,
      value = _ref.value;
  return React.createElement("input", {
    type: "hidden",
    id: id,
    value: typeof value === "undefined" ? "" : value
  });
}

if (process.env.NODE_ENV !== "production") {
  HiddenWidget.propTypes = {
    id: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.number, PropTypes.bool])
  };
}

export default HiddenWidget;