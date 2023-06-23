"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.useAsync = useAsync;
exports.withAsync = withAsync;
exports["default"] = asyncContainer;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _lodash = _interopRequireDefault(require("lodash.debounce"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireWildcard(require("react"));

var _useForceUpdate = _interopRequireDefault(require("@restart/hooks/useForceUpdate"));

var _usePrevious = _interopRequireDefault(require("@restart/hooks/usePrevious"));

var _Typeahead = _interopRequireDefault(require("../core/Typeahead"));

var _propTypes2 = require("../propTypes");

var _utils = require("../utils");

var _excluded = ["allowNew", "delay", "emptyLabel", "isLoading", "minLength", "onInputChange", "onSearch", "options", "promptText", "searchText", "useCache"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

var propTypes = {
  /**
   * Delay, in milliseconds, before performing search.
   */
  delay: _propTypes["default"].number,

  /**
   * Whether or not a request is currently pending. Necessary for the
   * container to know when new results are available.
   */
  isLoading: _propTypes["default"].bool.isRequired,

  /**
   * Number of input characters that must be entered before showing results.
   */
  minLength: _propTypes["default"].number,

  /**
   * Callback to perform when the search is executed.
   */
  onSearch: _propTypes["default"].func.isRequired,

  /**
   * Options to be passed to the typeahead. Will typically be the query
   * results, but can also be initial default options.
   */
  options: _propTypes["default"].arrayOf(_propTypes2.optionType),

  /**
   * Message displayed in the menu when there is no user input.
   */
  promptText: _propTypes["default"].node,

  /**
   * Message displayed in the menu while the request is pending.
   */
  searchText: _propTypes["default"].node,

  /**
   * Whether or not the component should cache query results.
   */
  useCache: _propTypes["default"].bool
};
var defaultProps = {
  delay: 200,
  minLength: 2,
  options: [],
  promptText: 'Type to search...',
  searchText: 'Searching...',
  useCache: true
};

/**
 * Logic that encapsulates common behavior and functionality around
 * asynchronous searches, including:
 *
 *  - Debouncing user input
 *  - Optional query caching
 *  - Search prompt and empty results behaviors
 */
function useAsync(props) {
  var allowNew = props.allowNew,
      delay = props.delay,
      emptyLabel = props.emptyLabel,
      isLoading = props.isLoading,
      minLength = props.minLength,
      onInputChange = props.onInputChange,
      onSearch = props.onSearch,
      options = props.options,
      promptText = props.promptText,
      searchText = props.searchText,
      useCache = props.useCache,
      otherProps = (0, _objectWithoutProperties2["default"])(props, _excluded);
  var cacheRef = (0, _react.useRef)({});
  var handleSearchDebouncedRef = (0, _react.useRef)();
  var queryRef = (0, _react.useRef)(props.defaultInputValue || '');
  var forceUpdate = (0, _useForceUpdate["default"])();
  var prevProps = (0, _usePrevious["default"])(props);
  var handleSearch = (0, _react.useCallback)(function (query) {
    queryRef.current = query;

    if (!query || minLength && query.length < minLength) {
      return;
    } // Use cached results, if applicable.


    if (useCache && cacheRef.current[query]) {
      // Re-render the component with the cached results.
      forceUpdate();
      return;
    } // Perform the search.


    onSearch(query);
  }, [forceUpdate, minLength, onSearch, useCache]); // Set the debounced search function.

  (0, _react.useEffect)(function () {
    handleSearchDebouncedRef.current = (0, _lodash["default"])(handleSearch, delay);
    return function () {
      handleSearchDebouncedRef.current && handleSearchDebouncedRef.current.cancel();
    };
  }, [delay, handleSearch]);
  (0, _react.useEffect)(function () {
    // Ensure that we've gone from a loading to a completed state. Otherwise
    // an empty response could get cached if the component updates during the
    // request (eg: if the parent re-renders for some reason).
    if (!isLoading && prevProps && prevProps.isLoading && useCache) {
      cacheRef.current[queryRef.current] = options;
    }
  });

  var getEmptyLabel = function getEmptyLabel() {
    if (!queryRef.current.length) {
      return promptText;
    }

    if (isLoading) {
      return searchText;
    }

    return emptyLabel;
  };

  var handleInputChange = (0, _react.useCallback)(function (query, e) {
    onInputChange && onInputChange(query, e);
    handleSearchDebouncedRef.current && handleSearchDebouncedRef.current(query);
  }, [onInputChange]);
  var cachedQuery = cacheRef.current[queryRef.current];
  return _objectSpread(_objectSpread({}, otherProps), {}, {
    // Disable custom selections during a search if `allowNew` isn't a function.
    allowNew: (0, _utils.isFunction)(allowNew) ? allowNew : allowNew && !isLoading,
    emptyLabel: getEmptyLabel(),
    isLoading: isLoading,
    minLength: minLength,
    onInputChange: handleInputChange,
    options: useCache && cachedQuery ? cachedQuery : options
  });
}

function withAsync(Component) {
  var AsyncTypeahead = /*#__PURE__*/(0, _react.forwardRef)(function (props, ref) {
    return /*#__PURE__*/_react["default"].createElement(Component, (0, _extends2["default"])({}, useAsync(props), {
      ref: ref
    }));
  });
  AsyncTypeahead.displayName = "withAsync(".concat((0, _utils.getDisplayName)(Component), ")"); // $FlowFixMe

  AsyncTypeahead.propTypes = propTypes; // $FlowFixMe

  AsyncTypeahead.defaultProps = defaultProps;
  return AsyncTypeahead;
}

function asyncContainer(Component) {
  /* istanbul ignore next */
  (0, _utils.warn)(false, 'The `asyncContainer` export is deprecated; use `withAsync` instead.');
  /* istanbul ignore next */

  return withAsync(Component);
}