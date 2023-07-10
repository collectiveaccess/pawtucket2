import React from "react";
import PropTypes from "prop-types";
import { schemaRequiresTrueValue } from "../../utils";

function CheckboxWidget(props) {
  var schema = props.schema,
      id = props.id,
      value = props.value,
      disabled = props.disabled,
      readonly = props.readonly,
      label = props.label,
      autofocus = props.autofocus,
      onBlur = props.onBlur,
      onFocus = props.onFocus,
      _onChange = props.onChange,
      DescriptionField = props.DescriptionField; // Because an unchecked checkbox will cause html5 validation to fail, only add
  // the "required" attribute if the field value must be "true", due to the
  // "const" or "enum" keywords

  var required = schemaRequiresTrueValue(schema);
  return React.createElement("div", {
    className: "checkbox ".concat(disabled || readonly ? "disabled" : "")
  }, schema.description && React.createElement(DescriptionField, {
    description: schema.description
  }), React.createElement("label", null, React.createElement("input", {
    type: "checkbox",
    id: id,
    checked: typeof value === "undefined" ? false : value,
    required: required,
    disabled: disabled || readonly,
    autoFocus: autofocus,
    onChange: function onChange(event) {
      return _onChange(event.target.checked);
    },
    onBlur: onBlur && function (event) {
      return onBlur(id, event.target.checked);
    },
    onFocus: onFocus && function (event) {
      return onFocus(id, event.target.checked);
    }
  }), React.createElement("span", null, label)));
}

CheckboxWidget.defaultProps = {
  autofocus: false
};

if (process.env.NODE_ENV !== "production") {
  CheckboxWidget.propTypes = {
    schema: PropTypes.object.isRequired,
    id: PropTypes.string.isRequired,
    value: PropTypes.bool,
    required: PropTypes.bool,
    disabled: PropTypes.bool,
    readonly: PropTypes.bool,
    autofocus: PropTypes.bool,
    onChange: PropTypes.func
  };
}

export default CheckboxWidget;