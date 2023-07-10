import _JSON$stringify from "@babel/runtime-corejs2/core-js/json/stringify";
import React from "react";
import PropTypes from "prop-types";

function UnsupportedField(_ref) {
  var schema = _ref.schema,
      idSchema = _ref.idSchema,
      reason = _ref.reason;
  return React.createElement("div", {
    className: "unsupported-field"
  }, React.createElement("p", null, "Unsupported field schema", idSchema && idSchema.$id && React.createElement("span", null, " for", " field ", React.createElement("code", null, idSchema.$id)), reason && React.createElement("em", null, ": ", reason), "."), schema && React.createElement("pre", null, _JSON$stringify(schema, null, 2)));
}

if (process.env.NODE_ENV !== "production") {
  UnsupportedField.propTypes = {
    schema: PropTypes.object.isRequired,
    idSchema: PropTypes.object,
    reason: PropTypes.string
  };
}

export default UnsupportedField;