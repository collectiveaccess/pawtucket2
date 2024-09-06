"use strict";

Object.defineProperty(exports, "__esModule", {
  value: !0
});

var _extends = require("@babel/runtime/helpers/extends"), _objectWithoutProperties = require("@babel/runtime/helpers/objectWithoutProperties"), _defineProperty = require("@babel/runtime/helpers/defineProperty"), index = require("../../dist/index-ea9e225d.cjs.prod.js"), _classCallCheck = require("@babel/runtime/helpers/classCallCheck"), _createClass = require("@babel/runtime/helpers/createClass"), _inherits = require("@babel/runtime/helpers/inherits"), React = require("react"), base_dist_reactSelect = require("../../dist/Select-fd7cb895.cjs.prod.js"), stateManager = require("../../dist/stateManager-799f6a0f.cjs.prod.js");

function _interopDefault(e) {
  return e && e.__esModule ? e : {
    default: e
  };
}

require("@emotion/react"), require("@babel/runtime/helpers/taggedTemplateLiteral"), 
require("@babel/runtime/helpers/typeof"), require("react-input-autosize"), require("react-dom"), 
require("@babel/runtime/helpers/toConsumableArray"), require("memoize-one");

var _extends__default = _interopDefault(_extends), _objectWithoutProperties__default = _interopDefault(_objectWithoutProperties), _defineProperty__default = _interopDefault(_defineProperty), _classCallCheck__default = _interopDefault(_classCallCheck), _createClass__default = _interopDefault(_createClass), _inherits__default = _interopDefault(_inherits), React__default = _interopDefault(React), defaultProps = {
  cacheOptions: !1,
  defaultOptions: !1,
  filterOption: null,
  isLoading: !1
}, makeAsyncSelect = function(SelectComponent) {
  var _class, _temp;
  return _temp = _class = function(_Component) {
    _inherits__default.default(Async, _Component);
    var _super = index._createSuper(Async);
    function Async(props) {
      var _this;
      return _classCallCheck__default.default(this, Async), (_this = _super.call(this)).select = void 0, 
      _this.lastRequest = void 0, _this.mounted = !1, _this.handleInputChange = function(newValue, actionMeta) {
        var _this$props = _this.props, cacheOptions = _this$props.cacheOptions, onInputChange = _this$props.onInputChange, inputValue = index.handleInputChange(newValue, actionMeta, onInputChange);
        if (!inputValue) return delete _this.lastRequest, void _this.setState({
          inputValue: "",
          loadedInputValue: "",
          loadedOptions: [],
          isLoading: !1,
          passEmptyOptions: !1
        });
        if (cacheOptions && _this.state.optionsCache[inputValue]) _this.setState({
          inputValue: inputValue,
          loadedInputValue: inputValue,
          loadedOptions: _this.state.optionsCache[inputValue],
          isLoading: !1,
          passEmptyOptions: !1
        }); else {
          var request = _this.lastRequest = {};
          _this.setState({
            inputValue: inputValue,
            isLoading: !0,
            passEmptyOptions: !_this.state.loadedInputValue
          }, (function() {
            _this.loadOptions(inputValue, (function(options) {
              _this.mounted && request === _this.lastRequest && (delete _this.lastRequest, _this.setState((function(state) {
                return {
                  isLoading: !1,
                  loadedInputValue: inputValue,
                  loadedOptions: options || [],
                  passEmptyOptions: !1,
                  optionsCache: options ? index._objectSpread2(index._objectSpread2({}, state.optionsCache), {}, _defineProperty__default.default({}, inputValue, options)) : state.optionsCache
                };
              })));
            }));
          }));
        }
        return inputValue;
      }, _this.state = {
        defaultOptions: Array.isArray(props.defaultOptions) ? props.defaultOptions : void 0,
        inputValue: void 0 !== props.inputValue ? props.inputValue : "",
        isLoading: !0 === props.defaultOptions,
        loadedOptions: [],
        passEmptyOptions: !1,
        optionsCache: {},
        prevDefaultOptions: void 0,
        prevCacheOptions: void 0
      }, _this;
    }
    return _createClass__default.default(Async, [ {
      key: "componentDidMount",
      value: function() {
        var _this2 = this;
        this.mounted = !0;
        var defaultOptions = this.props.defaultOptions, inputValue = this.state.inputValue;
        !0 === defaultOptions && this.loadOptions(inputValue, (function(options) {
          if (_this2.mounted) {
            var isLoading = !!_this2.lastRequest;
            _this2.setState({
              defaultOptions: options || [],
              isLoading: isLoading
            });
          }
        }));
      }
    }, {
      key: "componentWillUnmount",
      value: function() {
        this.mounted = !1;
      }
    }, {
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
      key: "loadOptions",
      value: function(inputValue, callback) {
        var loadOptions = this.props.loadOptions;
        if (!loadOptions) return callback();
        var loader = loadOptions(inputValue, callback);
        loader && "function" == typeof loader.then && loader.then(callback, (function() {
          return callback();
        }));
      }
    }, {
      key: "render",
      value: function() {
        var _this3 = this, _this$props2 = this.props;
        _this$props2.loadOptions;
        var isLoadingProp = _this$props2.isLoading, props = _objectWithoutProperties__default.default(_this$props2, [ "loadOptions", "isLoading" ]), _this$state = this.state, defaultOptions = _this$state.defaultOptions, inputValue = _this$state.inputValue, isLoading = _this$state.isLoading, loadedInputValue = _this$state.loadedInputValue, loadedOptions = _this$state.loadedOptions, options = _this$state.passEmptyOptions ? [] : inputValue && loadedInputValue ? loadedOptions : defaultOptions || [];
        return React__default.default.createElement(SelectComponent, _extends__default.default({}, props, {
          ref: function(_ref) {
            _this3.select = _ref;
          },
          options: options,
          isLoading: isLoading || isLoadingProp,
          onInputChange: this.handleInputChange
        }));
      }
    } ], [ {
      key: "getDerivedStateFromProps",
      value: function(props, state) {
        var newCacheOptionsState = props.cacheOptions !== state.prevCacheOptions ? {
          prevCacheOptions: props.cacheOptions,
          optionsCache: {}
        } : {}, newDefaultOptionsState = props.defaultOptions !== state.prevDefaultOptions ? {
          prevDefaultOptions: props.defaultOptions,
          defaultOptions: Array.isArray(props.defaultOptions) ? props.defaultOptions : void 0
        } : {};
        return index._objectSpread2(index._objectSpread2({}, newCacheOptionsState), newDefaultOptionsState);
      }
    } ]), Async;
  }(React.Component), _class.defaultProps = defaultProps, _temp;
}, SelectState = stateManager.manageState(base_dist_reactSelect.Select), Async = makeAsyncSelect(SelectState);

exports.default = Async, exports.defaultProps = defaultProps, exports.makeAsyncSelect = makeAsyncSelect;
