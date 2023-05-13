"use strict";

var _interopRequireWildcard = require("@babel/runtime-corejs2/helpers/interopRequireWildcard");

var _interopRequireDefault = require("@babel/runtime-corejs2/helpers/interopRequireDefault");

var _Object$defineProperty = require("@babel/runtime-corejs2/core-js/object/define-property");

_Object$defineProperty(exports, "__esModule", {
  value: true
});

exports["default"] = void 0;

var _objectSpread2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/objectSpread"));

var _isArray = _interopRequireDefault(require("@babel/runtime-corejs2/core-js/array/is-array"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime-corejs2/helpers/objectWithoutProperties"));

var _react = _interopRequireDefault(require("react"));

var types = _interopRequireWildcard(require("../../types"));

var _utils = require("../../utils");

function BooleanField(props) {
  var schema = props.schema,
      name = props.name,
      uiSchema = props.uiSchema,
      idSchema = props.idSchema,
      formData = props.formData,
      _props$registry = props.registry,
      registry = _props$registry === void 0 ? (0, _utils.getDefaultRegistry)() : _props$registry,
      required = props.required,
      disabled = props.disabled,
      readonly = props.readonly,
      autofocus = props.autofocus,
      onChange = props.onChange,
      onFocus = props.onFocus,
      onBlur = props.onBlur,
      rawErrors = props.rawErrors;
  var title = schema.title;
  var widgets = registry.widgets,
      formContext = registry.formContext;

  var _getUiOptions = (0, _utils.getUiOptions)(uiSchema),
      _getUiOptions$widget = _getUiOptions.widget,
      widget = _getUiOptions$widget === void 0 ? "checkbox" : _getUiOptions$widget,
      options = (0, _objectWithoutProperties2["default"])(_getUiOptions, ["widget"]);

  var Widget = (0, _utils.getWidget)(schema, widget, widgets);
  var enumOptions;

  if ((0, _isArray["default"])(schema.oneOf)) {
    enumOptions = (0, _utils.optionsList)({
      oneOf: schema.oneOf.map(function (option) {
        return (0, _objectSpread2["default"])({}, option, {
          title: option.title || (option["const"] === true ? "yes" : "no")
        });
      })
    });
  } else {
    enumOptions = (0, _utils.optionsList)({
      "enum": schema["enum"] || [true, false],
      enumNames: schema.enumNames || (schema["enum"] && schema["enum"][0] === false ? ["no", "yes"] : ["yes", "no"])
    });
  }

  return _react["default"].createElement(Widget, {
    options: (0, _objectSpread2["default"])({}, options, {
      enumOptions: enumOptions
    }),
    schema: schema,
    id: idSchema && idSchema.$id,
    onChange: onChange,
    onFocus: onFocus,
    onBlur: onBlur,
    label: title === undefined ? name : title,
    value: formData,
    required: required,
    disabled: disabled,
    readonly: readonly,
    registry: registry,
    formContext: formContext,
    autofocus: autofocus,
    rawErrors: rawErrors
  });
}

if (process.env.NODE_ENV !== "production") {
  BooleanField.propTypes = types.fieldProps;
}

BooleanField.defaultProps = {
  uiSchema: {},
  disabled: false,
  readonly: false,
  autofocus: false
};
var _default = BooleanField;
exports["default"] = _default;