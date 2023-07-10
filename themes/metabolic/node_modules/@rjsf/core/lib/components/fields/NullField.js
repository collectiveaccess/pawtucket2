import _classCallCheck from "@babel/runtime-corejs2/helpers/esm/classCallCheck";
import _createClass from "@babel/runtime-corejs2/helpers/esm/createClass";
import _possibleConstructorReturn from "@babel/runtime-corejs2/helpers/esm/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime-corejs2/helpers/esm/getPrototypeOf";
import _inherits from "@babel/runtime-corejs2/helpers/esm/inherits";
import { Component } from "react";
import * as types from "../../types";

var NullField =
/*#__PURE__*/
function (_Component) {
  _inherits(NullField, _Component);

  function NullField() {
    _classCallCheck(this, NullField);

    return _possibleConstructorReturn(this, _getPrototypeOf(NullField).apply(this, arguments));
  }

  _createClass(NullField, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      if (this.props.formData === undefined) {
        this.props.onChange(null);
      }
    }
  }, {
    key: "render",
    value: function render() {
      return null;
    }
  }]);

  return NullField;
}(Component);

if (process.env.NODE_ENV !== "production") {
  NullField.propTypes = types.fieldProps;
}

export default NullField;