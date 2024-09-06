'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var _extends = require('@babel/runtime/helpers/extends');
var _toConsumableArray = require('@babel/runtime/helpers/toConsumableArray');
var _classCallCheck = require('@babel/runtime/helpers/classCallCheck');
var _createClass = require('@babel/runtime/helpers/createClass');
var _inherits = require('@babel/runtime/helpers/inherits');
var index = require('../../dist/index-fe3694ff.cjs.dev.js');
var React = require('react');
var base_dist_reactSelect = require('../../dist/Select-92d95971.cjs.dev.js');
var stateManager = require('../../dist/stateManager-80f4e9df.cjs.dev.js');
require('@emotion/react');
require('@babel/runtime/helpers/taggedTemplateLiteral');
require('@babel/runtime/helpers/objectWithoutProperties');
require('@babel/runtime/helpers/typeof');
require('react-input-autosize');
require('@babel/runtime/helpers/defineProperty');
require('react-dom');
require('memoize-one');

function _interopDefault (e) { return e && e.__esModule ? e : { 'default': e }; }

var _extends__default = /*#__PURE__*/_interopDefault(_extends);
var _toConsumableArray__default = /*#__PURE__*/_interopDefault(_toConsumableArray);
var _classCallCheck__default = /*#__PURE__*/_interopDefault(_classCallCheck);
var _createClass__default = /*#__PURE__*/_interopDefault(_createClass);
var _inherits__default = /*#__PURE__*/_interopDefault(_inherits);
var React__default = /*#__PURE__*/_interopDefault(React);

var compareOption = function compareOption() {
  var inputValue = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  var option = arguments.length > 1 ? arguments[1] : undefined;
  var accessors = arguments.length > 2 ? arguments[2] : undefined;
  var candidate = String(inputValue).toLowerCase();
  var optionValue = String(accessors.getOptionValue(option)).toLowerCase();
  var optionLabel = String(accessors.getOptionLabel(option)).toLowerCase();
  return optionValue === candidate || optionLabel === candidate;
};

var builtins = {
  formatCreateLabel: function formatCreateLabel(inputValue) {
    return "Create \"".concat(inputValue, "\"");
  },
  isValidNewOption: function isValidNewOption(inputValue, selectValue, selectOptions, accessors) {
    return !(!inputValue || selectValue.some(function (option) {
      return compareOption(inputValue, option, accessors);
    }) || selectOptions.some(function (option) {
      return compareOption(inputValue, option, accessors);
    }));
  },
  getNewOptionData: function getNewOptionData(inputValue, optionLabel) {
    return {
      label: optionLabel,
      value: inputValue,
      __isNew__: true
    };
  },
  getOptionValue: base_dist_reactSelect.getOptionValue,
  getOptionLabel: base_dist_reactSelect.getOptionLabel
};
var defaultProps = index._objectSpread2({
  allowCreateWhileLoading: false,
  createOptionPosition: 'last'
}, builtins);
var makeCreatableSelect = function makeCreatableSelect(SelectComponent) {
  var _class, _temp;

  return _temp = _class = /*#__PURE__*/function (_Component) {
    _inherits__default['default'](Creatable, _Component);

    var _super = index._createSuper(Creatable);

    function Creatable(props) {
      var _this;

      _classCallCheck__default['default'](this, Creatable);

      _this = _super.call(this, props);
      _this.select = void 0;

      _this.onChange = function (newValue, actionMeta) {
        var _this$props = _this.props,
            getNewOptionData = _this$props.getNewOptionData,
            inputValue = _this$props.inputValue,
            isMulti = _this$props.isMulti,
            onChange = _this$props.onChange,
            onCreateOption = _this$props.onCreateOption,
            value = _this$props.value,
            name = _this$props.name;

        if (actionMeta.action !== 'select-option') {
          return onChange(newValue, actionMeta);
        }

        var newOption = _this.state.newOption;
        var valueArray = Array.isArray(newValue) ? newValue : [newValue];

        if (valueArray[valueArray.length - 1] === newOption) {
          if (onCreateOption) onCreateOption(inputValue);else {
            var newOptionData = getNewOptionData(inputValue, inputValue);
            var newActionMeta = {
              action: 'create-option',
              name: name,
              option: newOptionData
            };

            if (isMulti) {
              onChange([].concat(_toConsumableArray__default['default'](index.cleanValue(value)), [newOptionData]), newActionMeta);
            } else {
              onChange(newOptionData, newActionMeta);
            }
          }
          return;
        }

        onChange(newValue, actionMeta);
      };

      var options = props.options || [];
      _this.state = {
        newOption: undefined,
        options: options
      };
      return _this;
    }

    _createClass__default['default'](Creatable, [{
      key: "focus",
      value: function focus() {
        this.select.focus();
      }
    }, {
      key: "blur",
      value: function blur() {
        this.select.blur();
      }
    }, {
      key: "render",
      value: function render() {
        var _this2 = this;

        var options = this.state.options;
        return /*#__PURE__*/React__default['default'].createElement(SelectComponent, _extends__default['default']({}, this.props, {
          ref: function ref(_ref) {
            _this2.select = _ref;
          },
          options: options,
          onChange: this.onChange
        }));
      }
    }], [{
      key: "getDerivedStateFromProps",
      value: function getDerivedStateFromProps(props, state) {
        var allowCreateWhileLoading = props.allowCreateWhileLoading,
            createOptionPosition = props.createOptionPosition,
            formatCreateLabel = props.formatCreateLabel,
            getNewOptionData = props.getNewOptionData,
            inputValue = props.inputValue,
            isLoading = props.isLoading,
            isValidNewOption = props.isValidNewOption,
            value = props.value,
            getOptionValue = props.getOptionValue,
            getOptionLabel = props.getOptionLabel;
        var options = props.options || [];
        var newOption = state.newOption;

        if (isValidNewOption(inputValue, index.cleanValue(value), options, {
          getOptionValue: getOptionValue,
          getOptionLabel: getOptionLabel
        })) {
          newOption = getNewOptionData(inputValue, formatCreateLabel(inputValue));
        } else {
          newOption = undefined;
        }

        return {
          newOption: newOption,
          options: (allowCreateWhileLoading || !isLoading) && newOption ? createOptionPosition === 'first' ? [newOption].concat(_toConsumableArray__default['default'](options)) : [].concat(_toConsumableArray__default['default'](options), [newOption]) : options
        };
      }
    }]);

    return Creatable;
  }(React.Component), _class.defaultProps = defaultProps, _temp;
}; // TODO: do this in package entrypoint

var SelectCreatable = makeCreatableSelect(base_dist_reactSelect.Select);
var Creatable = stateManager.manageState(SelectCreatable);

exports.default = Creatable;
exports.defaultProps = defaultProps;
exports.makeCreatableSelect = makeCreatableSelect;
