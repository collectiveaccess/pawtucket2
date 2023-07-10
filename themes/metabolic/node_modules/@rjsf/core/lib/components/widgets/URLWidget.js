import _extends from "@babel/runtime-corejs2/helpers/esm/extends";
import React from "react";
import PropTypes from "prop-types";

function URLWidget(props) {
  var BaseInput = props.registry.widgets.BaseInput;
  return React.createElement(BaseInput, _extends({
    type: "url"
  }, props));
}

if (process.env.NODE_ENV !== "production") {
  URLWidget.propTypes = {
    value: PropTypes.string
  };
}

export default URLWidget;