import React from "react";
import PropTypes from "prop-types";

function RadioWidget(props) {
  var options = props.options,
      value = props.value,
      required = props.required,
      disabled = props.disabled,
      readonly = props.readonly,
      autofocus = props.autofocus,
      onBlur = props.onBlur,
      onFocus = props.onFocus,
      _onChange = props.onChange,
      id = props.id; // Generating a unique field name to identify this set of radio buttons

  var name = Math.random().toString();
  var enumOptions = options.enumOptions,
      enumDisabled = options.enumDisabled,
      inline = options.inline; // checked={checked} has been moved above name={name}, As mentioned in #349;
  // this is a temporary fix for radio button rendering bug in React, facebook/react#7630.

  return React.createElement("div", {
    className: "field-radio-group",
    id: id
  }, enumOptions.map(function (option, i) {
    var checked = option.value === value;
    var itemDisabled = enumDisabled && enumDisabled.indexOf(option.value) != -1;
    var disabledCls = disabled || itemDisabled || readonly ? "disabled" : "";
    var radio = React.createElement("span", null, React.createElement("input", {
      type: "radio",
      checked: checked,
      name: name,
      required: required,
      value: option.value,
      disabled: disabled || itemDisabled || readonly,
      autoFocus: autofocus && i === 0,
      onChange: function onChange(_) {
        return _onChange(option.value);
      },
      onBlur: onBlur && function (event) {
        return onBlur(id, event.target.value);
      },
      onFocus: onFocus && function (event) {
        return onFocus(id, event.target.value);
      }
    }), React.createElement("span", null, option.label));
    return inline ? React.createElement("label", {
      key: i,
      className: "radio-inline ".concat(disabledCls)
    }, radio) : React.createElement("div", {
      key: i,
      className: "radio ".concat(disabledCls)
    }, React.createElement("label", null, radio));
  }));
}

RadioWidget.defaultProps = {
  autofocus: false
};

if (process.env.NODE_ENV !== "production") {
  RadioWidget.propTypes = {
    schema: PropTypes.object.isRequired,
    id: PropTypes.string.isRequired,
    options: PropTypes.shape({
      enumOptions: PropTypes.array,
      inline: PropTypes.bool
    }).isRequired,
    value: PropTypes.any,
    required: PropTypes.bool,
    disabled: PropTypes.bool,
    readonly: PropTypes.bool,
    autofocus: PropTypes.bool,
    onChange: PropTypes.func
  };
}

export default RadioWidget;