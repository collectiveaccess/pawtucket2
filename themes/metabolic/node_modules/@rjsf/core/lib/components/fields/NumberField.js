import _extends from "@babel/runtime-corejs2/helpers/esm/extends";
import _objectWithoutProperties from "@babel/runtime-corejs2/helpers/esm/objectWithoutProperties";
import _classCallCheck from "@babel/runtime-corejs2/helpers/esm/classCallCheck";
import _createClass from "@babel/runtime-corejs2/helpers/esm/createClass";
import _possibleConstructorReturn from "@babel/runtime-corejs2/helpers/esm/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime-corejs2/helpers/esm/getPrototypeOf";
import _assertThisInitialized from "@babel/runtime-corejs2/helpers/esm/assertThisInitialized";
import _inherits from "@babel/runtime-corejs2/helpers/esm/inherits";
import _defineProperty from "@babel/runtime-corejs2/helpers/esm/defineProperty";
import React from "react";
import * as types from "../../types";
import { asNumber } from "../../utils"; // Matches a string that ends in a . character, optionally followed by a sequence of
// digits followed by any number of 0 characters up until the end of the line.
// Ensuring that there is at least one prefixed character is important so that
// you don't incorrectly match against "0".

var trailingCharMatcherWithPrefix = /\.([0-9]*0)*$/; // This is used for trimming the trailing 0 and . characters without affecting
// the rest of the string. Its possible to use one RegEx with groups for this
// functionality, but it is fairly complex compared to simply defining two
// different matchers.

var trailingCharMatcher = /[0.]0*$/;
/**
 * The NumberField class has some special handling for dealing with trailing
 * decimal points and/or zeroes. This logic is designed to allow trailing values
 * to be visible in the input element, but not be represented in the
 * corresponding form data.
 *
 * The algorithm is as follows:
 *
 * 1. When the input value changes the value is cached in the component state
 *
 * 2. The value is then normalized, removing trailing decimal points and zeros,
 *    then passed to the "onChange" callback
 *
 * 3. When the component is rendered, the formData value is checked against the
 *    value cached in the state. If it matches the cached value, the cached
 *    value is passed to the input instead of the formData value
 */

var NumberField =
/*#__PURE__*/
function (_React$Component) {
  _inherits(NumberField, _React$Component);

  function NumberField(props) {
    var _this;

    _classCallCheck(this, NumberField);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(NumberField).call(this, props));

    _defineProperty(_assertThisInitialized(_this), "handleChange", function (value) {
      // Cache the original value in component state
      _this.setState({
        lastValue: value
      }); // Normalize decimals that don't start with a zero character in advance so
      // that the rest of the normalization logic is simpler


      if ("".concat(value).charAt(0) === ".") {
        value = "0".concat(value);
      } // Check that the value is a string (this can happen if the widget used is a
      // <select>, due to an enum declaration etc) then, if the value ends in a
      // trailing decimal point or multiple zeroes, strip the trailing values


      var processed = typeof value === "string" && value.match(trailingCharMatcherWithPrefix) ? asNumber(value.replace(trailingCharMatcher, "")) : asNumber(value);

      _this.props.onChange(processed);
    });

    _this.state = {
      lastValue: props.value
    };
    return _this;
  }

  _createClass(NumberField, [{
    key: "render",
    value: function render() {
      var StringField = this.props.registry.fields.StringField;

      var _this$props = this.props,
          formData = _this$props.formData,
          props = _objectWithoutProperties(_this$props, ["formData"]);

      var lastValue = this.state.lastValue;
      var value = formData;

      if (typeof lastValue === "string" && typeof value === "number") {
        // Construct a regular expression that checks for a string that consists
        // of the formData value suffixed with zero or one '.' characters and zero
        // or more '0' characters
        var re = new RegExp("".concat(value).replace(".", "\\.") + "\\.?0*$"); // If the cached "lastValue" is a match, use that instead of the formData
        // value to prevent the input value from changing in the UI

        if (lastValue.match(re)) {
          value = lastValue;
        }
      }

      return React.createElement(StringField, _extends({}, props, {
        formData: value,
        onChange: this.handleChange
      }));
    }
  }]);

  return NumberField;
}(React.Component);

if (process.env.NODE_ENV !== "production") {
  NumberField.propTypes = types.fieldProps;
}

NumberField.defaultProps = {
  uiSchema: {}
};
export default NumberField;