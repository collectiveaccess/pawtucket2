import _extends from "@babel/runtime-corejs2/helpers/esm/extends";
import _objectSpread from "@babel/runtime-corejs2/helpers/esm/objectSpread";
import _objectWithoutProperties from "@babel/runtime-corejs2/helpers/esm/objectWithoutProperties";
import React, { forwardRef } from "react";
import PropTypes from "prop-types";
import Form from "./";

function withTheme(themeProps) {
  return forwardRef(function (_ref, ref) {
    var fields = _ref.fields,
        widgets = _ref.widgets,
        directProps = _objectWithoutProperties(_ref, ["fields", "widgets"]);

    fields = _objectSpread({}, themeProps.fields, fields);
    widgets = _objectSpread({}, themeProps.widgets, widgets);
    return React.createElement(Form, _extends({}, themeProps, directProps, {
      fields: fields,
      widgets: widgets,
      ref: ref
    }));
  });
}

withTheme.propTypes = {
  widgets: PropTypes.object,
  fields: PropTypes.object
};
export default withTheme;