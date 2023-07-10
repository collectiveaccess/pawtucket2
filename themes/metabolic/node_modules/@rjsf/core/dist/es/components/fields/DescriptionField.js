import React from "react";
import PropTypes from "prop-types";

function DescriptionField(props) {
  var id = props.id,
      description = props.description;

  if (!description) {
    return null;
  }

  if (typeof description === "string") {
    return React.createElement("p", {
      id: id,
      className: "field-description"
    }, description);
  } else {
    return React.createElement("div", {
      id: id,
      className: "field-description"
    }, description);
  }
}

if (process.env.NODE_ENV !== "production") {
  DescriptionField.propTypes = {
    id: PropTypes.string,
    description: PropTypes.oneOfType([PropTypes.string, PropTypes.element])
  };
}

export default DescriptionField;