import React from "react";
import PropTypes from "prop-types";
var REQUIRED_FIELD_SYMBOL = "*";

function TitleField(props) {
  var id = props.id,
      title = props.title,
      required = props.required;
  return React.createElement("legend", {
    id: id
  }, title, required && React.createElement("span", {
    className: "required"
  }, REQUIRED_FIELD_SYMBOL));
}

if (process.env.NODE_ENV !== "production") {
  TitleField.propTypes = {
    id: PropTypes.string,
    title: PropTypes.string,
    required: PropTypes.bool
  };
}

export default TitleField;