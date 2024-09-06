import _extends from '@babel/runtime/helpers/esm/extends';
import _objectWithoutProperties from '@babel/runtime/helpers/esm/objectWithoutProperties';
import _defineProperty from '@babel/runtime/helpers/esm/defineProperty';
import { _ as _createSuper, H as handleInputChange, a as _objectSpread2 } from '../../dist/index-4bd03571.esm.js';
import _classCallCheck from '@babel/runtime/helpers/esm/classCallCheck';
import _createClass from '@babel/runtime/helpers/esm/createClass';
import _inherits from '@babel/runtime/helpers/esm/inherits';
import React, { Component } from 'react';
import { S as Select } from '../../dist/Select-dbb12e54.esm.js';
import { m as manageState } from '../../dist/stateManager-845a3300.esm.js';
import '@emotion/react';
import '@babel/runtime/helpers/taggedTemplateLiteral';
import '@babel/runtime/helpers/typeof';
import 'react-input-autosize';
import 'react-dom';
import '@babel/runtime/helpers/toConsumableArray';
import 'memoize-one';

var defaultProps = {
  cacheOptions: false,
  defaultOptions: false,
  filterOption: null,
  isLoading: false
};
var makeAsyncSelect = function makeAsyncSelect(SelectComponent) {
  var _class, _temp;

  return _temp = _class = /*#__PURE__*/function (_Component) {
    _inherits(Async, _Component);

    var _super = _createSuper(Async);

    function Async(props) {
      var _this;

      _classCallCheck(this, Async);

      _this = _super.call(this);
      _this.select = void 0;
      _this.lastRequest = void 0;
      _this.mounted = false;

      _this.handleInputChange = function (newValue, actionMeta) {
        var _this$props = _this.props,
            cacheOptions = _this$props.cacheOptions,
            onInputChange = _this$props.onInputChange; // TODO

        var inputValue = handleInputChange(newValue, actionMeta, onInputChange);

        if (!inputValue) {
          delete _this.lastRequest;

          _this.setState({
            inputValue: '',
            loadedInputValue: '',
            loadedOptions: [],
            isLoading: false,
            passEmptyOptions: false
          });

          return;
        }

        if (cacheOptions && _this.state.optionsCache[inputValue]) {
          _this.setState({
            inputValue: inputValue,
            loadedInputValue: inputValue,
            loadedOptions: _this.state.optionsCache[inputValue],
            isLoading: false,
            passEmptyOptions: false
          });
        } else {
          var request = _this.lastRequest = {};

          _this.setState({
            inputValue: inputValue,
            isLoading: true,
            passEmptyOptions: !_this.state.loadedInputValue
          }, function () {
            _this.loadOptions(inputValue, function (options) {
              if (!_this.mounted) return;
              if (request !== _this.lastRequest) return;
              delete _this.lastRequest;

              _this.setState(function (state) {
                return {
                  isLoading: false,
                  loadedInputValue: inputValue,
                  loadedOptions: options || [],
                  passEmptyOptions: false,
                  optionsCache: options ? _objectSpread2(_objectSpread2({}, state.optionsCache), {}, _defineProperty({}, inputValue, options)) : state.optionsCache
                };
              });
            });
          });
        }

        return inputValue;
      };

      _this.state = {
        defaultOptions: Array.isArray(props.defaultOptions) ? props.defaultOptions : undefined,
        inputValue: typeof props.inputValue !== 'undefined' ? props.inputValue : '',
        isLoading: props.defaultOptions === true,
        loadedOptions: [],
        passEmptyOptions: false,
        optionsCache: {},
        prevDefaultOptions: undefined,
        prevCacheOptions: undefined
      };
      return _this;
    }

    _createClass(Async, [{
      key: "componentDidMount",
      value: function componentDidMount() {
        var _this2 = this;

        this.mounted = true;
        var defaultOptions = this.props.defaultOptions;
        var inputValue = this.state.inputValue;

        if (defaultOptions === true) {
          this.loadOptions(inputValue, function (options) {
            if (!_this2.mounted) return;
            var isLoading = !!_this2.lastRequest;

            _this2.setState({
              defaultOptions: options || [],
              isLoading: isLoading
            });
          });
        }
      }
    }, {
      key: "componentWillUnmount",
      value: function componentWillUnmount() {
        this.mounted = false;
      }
    }, {
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
      key: "loadOptions",
      value: function loadOptions(inputValue, callback) {
        var loadOptions = this.props.loadOptions;
        if (!loadOptions) return callback();
        var loader = loadOptions(inputValue, callback);

        if (loader && typeof loader.then === 'function') {
          loader.then(callback, function () {
            return callback();
          });
        }
      }
    }, {
      key: "render",
      value: function render() {
        var _this3 = this;

        var _this$props2 = this.props;
            _this$props2.loadOptions;
            var isLoadingProp = _this$props2.isLoading,
            props = _objectWithoutProperties(_this$props2, ["loadOptions", "isLoading"]);

        var _this$state = this.state,
            defaultOptions = _this$state.defaultOptions,
            inputValue = _this$state.inputValue,
            isLoading = _this$state.isLoading,
            loadedInputValue = _this$state.loadedInputValue,
            loadedOptions = _this$state.loadedOptions,
            passEmptyOptions = _this$state.passEmptyOptions;
        var options = passEmptyOptions ? [] : inputValue && loadedInputValue ? loadedOptions : defaultOptions || [];
        return /*#__PURE__*/React.createElement(SelectComponent, _extends({}, props, {
          ref: function ref(_ref) {
            _this3.select = _ref;
          },
          options: options,
          isLoading: isLoading || isLoadingProp,
          onInputChange: this.handleInputChange
        }));
      }
    }], [{
      key: "getDerivedStateFromProps",
      value: function getDerivedStateFromProps(props, state) {
        var newCacheOptionsState = props.cacheOptions !== state.prevCacheOptions ? {
          prevCacheOptions: props.cacheOptions,
          optionsCache: {}
        } : {};
        var newDefaultOptionsState = props.defaultOptions !== state.prevDefaultOptions ? {
          prevDefaultOptions: props.defaultOptions,
          defaultOptions: Array.isArray(props.defaultOptions) ? props.defaultOptions : undefined
        } : {};
        return _objectSpread2(_objectSpread2({}, newCacheOptionsState), newDefaultOptionsState);
      }
    }]);

    return Async;
  }(Component), _class.defaultProps = defaultProps, _temp;
};
var SelectState = manageState(Select);
var Async = makeAsyncSelect(SelectState);

export default Async;
export { defaultProps, makeAsyncSelect };
