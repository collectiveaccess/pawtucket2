"use strict";

Object.defineProperty(exports, "__esModule", {
  value: !0
});

var _extends = require("@babel/runtime/helpers/extends"), _toConsumableArray = require("@babel/runtime/helpers/toConsumableArray"), _classCallCheck = require("@babel/runtime/helpers/classCallCheck"), _createClass = require("@babel/runtime/helpers/createClass"), _inherits = require("@babel/runtime/helpers/inherits"), index = require("../../dist/index-ea9e225d.cjs.prod.js"), React = require("react"), base_dist_reactSelect = require("../../dist/Select-fd7cb895.cjs.prod.js"), stateManager = require("../../dist/stateManager-799f6a0f.cjs.prod.js");

function _interopDefault(e) {
  return e && e.__esModule ? e : {
    default: e
  };
}

require("@emotion/react"), require("@babel/runtime/helpers/taggedTemplateLiteral"), 
require("@babel/runtime/helpers/objectWithoutProperties"), require("@babel/runtime/helpers/typeof"), 
require("react-input-autosize"), require("@babel/runtime/helpers/defineProperty"), 
require("react-dom"), require("memoize-one");

var _extends__default = _interopDefault(_extends), _toConsumableArray__default = _interopDefault(_toConsumableArray), _classCallCheck__default = _interopDefault(_classCallCheck), _createClass__default = _interopDefault(_createClass), _inherits__default = _interopDefault(_inherits), React__default = _interopDefault(React), compareOption = function() {
  var inputValue = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", option = arguments.length > 1 ? arguments[1] : void 0, accessors = arguments.length > 2 ? arguments[2] : void 0, candidate = String(inputValue).toLowerCase(), optionValue = String(accessors.getOptionValue(option)).toLowerCase(), optionLabel = String(accessors.getOptionLabel(option)).toLowerCase();
  return optionValue === candidate || optionLabel === candidate;
}, builtins = {
  formatCreateLabel: function(inputValue) {
    return 'Create "'.concat(inputValue, '"');
  },
  isValidNewOption: function(inputValue, selectValue, selectOptions, accessors) {
    return !(!inputValue || selectValue.some((function(option) {
      return compareOption(inputValue, option, accessors);
    })) || selectOptions.some((function(option) {
      return compareOption(inputValue, option, accessors);
    })));
  },
  getNewOptionData: function(inputValue, optionLabel) {
    return {
      label: optionLabel,
      value: inputValue,
      __isNew__: !0
    };
  },
  getOptionValue: base_dist_reactSelect.getOptionValue,
  getOptionLabel: base_dist_reactSelect.getOptionLabel
}, defaultProps = index._objectSpread2({
  allowCreateWhileLoading: !1,
  createOptionPosition: "last"
}, builtins), makeCreatableSelect = function(SelectComponent) {
  var _class, _temp;
  return _temp = _class = function(_Component) {
    _inherits__default.default(Creatable, _Component);
    var _super = index._createSuper(Creatable);
    function Creatable(props) {
      var _this;
      _classCallCheck__default.default(this, Creatable), (_this = _super.call(this, props)).select = void 0, 
      _this.onChange = function(newValue, actionMeta) {
        var _this$props = _this.props, getNewOptionData = _this$props.getNewOptionData, inputValue = _this$props.inputValue, isMulti = _this$props.isMulti, onChange = _this$props.onChange, onCreateOption = _this$props.onCreateOption, value = _this$props.value, name = _this$props.name;
        if ("select-option" !== actionMeta.action) return onChange(newValue, actionMeta);
        var newOption = _this.state.newOption, valueArray = Array.isArray(newValue) ? newValue : [ newValue ];
        if (valueArray[valueArray.length - 1] !== newOption) onChange(newValue, actionMeta); else if (onCreateOption) onCreateOption(inputValue); else {
          var newOptionData = getNewOptionData(inputValue, inputValue), newActionMeta = {
            action: "create-option",
            name: name,
            option: newOptionData
          };
          onChange(isMulti ? [].concat(_toConsumableArray__default.default(index.cleanValue(value)), [ newOptionData ]) : newOptionData, newActionMeta);
        }
      };
      var options = props.options || [];
      return _this.state = {
        newOption: void 0,
        options: options
      }, _this;
    }
    return _createClass__default.default(Creatable, [ {
      key: "focus",
      value: function() {
        this.select.focus();
      }
    }, {
      key: "blur",
      value: function() {
        this.select.blur();
      }
    }, {
      key: "render",
      value: function() {
        var _this2 = this, options = this.state.options;
        return React__default.default.createElement(SelectComponent, _extends__default.default({}, this.props, {
          ref: function(_ref) {
            _this2.select = _ref;
          },
          options: options,
          onChange: this.onChange
        }));
      }
    } ], [ {
      key: "getDerivedStateFromProps",
      value: function(props, state) {
        var allowCreateWhileLoading = props.allowCreateWhileLoading, createOptionPosition = props.createOptionPosition, formatCreateLabel = props.formatCreateLabel, getNewOptionData = props.getNewOptionData, inputValue = props.inputValue, isLoading = props.isLoading, isValidNewOption = props.isValidNewOption, value = props.value, getOptionValue = props.getOptionValue, getOptionLabel = props.getOptionLabel, options = props.options || [], newOption = state.newOption;
        return {
          newOption: newOption = isValidNewOption(inputValue, index.cleanValue(value), options, {
            getOptionValue: getOptionValue,
            getOptionLabel: getOptionLabel
          }) ? getNewOptionData(inputValue, formatCreateLabel(inputValue)) : void 0,
          options: !allowCreateWhileLoading && isLoading || !newOption ? options : "first" === createOptionPosition ? [ newOption ].concat(_toConsumableArray__default.default(options)) : [].concat(_toConsumableArray__default.default(options), [ newOption ])
        };
      }
    } ]), Creatable;
  }(React.Component), _class.defaultProps = defaultProps, _temp;
}, SelectCreatable = makeCreatableSelect(base_dist_reactSelect.Select), Creatable = stateManager.manageState(SelectCreatable);

exports.default = Creatable, exports.defaultProps = defaultProps, exports.makeCreatableSelect = makeCreatableSelect;
