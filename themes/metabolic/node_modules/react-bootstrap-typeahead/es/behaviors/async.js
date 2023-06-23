import _extends from "@babel/runtime/helpers/extends";
import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["allowNew", "delay", "emptyLabel", "isLoading", "minLength", "onInputChange", "onSearch", "options", "promptText", "searchText", "useCache"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

import debounce from 'lodash.debounce';
import PropTypes from 'prop-types';
import React, { forwardRef, useCallback, useEffect, useRef } from 'react';
import useForceUpdate from '@restart/hooks/useForceUpdate';
import usePrevious from '@restart/hooks/usePrevious';
import Typeahead from '../core/Typeahead';
import { optionType } from '../propTypes';
import { getDisplayName, isFunction, warn } from '../utils';
var propTypes = {
  /**
   * Delay, in milliseconds, before performing search.
   */
  delay: PropTypes.number,

  /**
   * Whether or not a request is currently pending. Necessary for the
   * container to know when new results are available.
   */
  isLoading: PropTypes.bool.isRequired,

  /**
   * Number of input characters that must be entered before showing results.
   */
  minLength: PropTypes.number,

  /**
   * Callback to perform when the search is executed.
   */
  onSearch: PropTypes.func.isRequired,

  /**
   * Options to be passed to the typeahead. Will typically be the query
   * results, but can also be initial default options.
   */
  options: PropTypes.arrayOf(optionType),

  /**
   * Message displayed in the menu when there is no user input.
   */
  promptText: PropTypes.node,

  /**
   * Message displayed in the menu while the request is pending.
   */
  searchText: PropTypes.node,

  /**
   * Whether or not the component should cache query results.
   */
  useCache: PropTypes.bool
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
export function useAsync(props) {
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
      otherProps = _objectWithoutProperties(props, _excluded);

  var cacheRef = useRef({});
  var handleSearchDebouncedRef = useRef();
  var queryRef = useRef(props.defaultInputValue || '');
  var forceUpdate = useForceUpdate();
  var prevProps = usePrevious(props);
  var handleSearch = useCallback(function (query) {
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

  useEffect(function () {
    handleSearchDebouncedRef.current = debounce(handleSearch, delay);
    return function () {
      handleSearchDebouncedRef.current && handleSearchDebouncedRef.current.cancel();
    };
  }, [delay, handleSearch]);
  useEffect(function () {
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

  var handleInputChange = useCallback(function (query, e) {
    onInputChange && onInputChange(query, e);
    handleSearchDebouncedRef.current && handleSearchDebouncedRef.current(query);
  }, [onInputChange]);
  var cachedQuery = cacheRef.current[queryRef.current];
  return _objectSpread(_objectSpread({}, otherProps), {}, {
    // Disable custom selections during a search if `allowNew` isn't a function.
    allowNew: isFunction(allowNew) ? allowNew : allowNew && !isLoading,
    emptyLabel: getEmptyLabel(),
    isLoading: isLoading,
    minLength: minLength,
    onInputChange: handleInputChange,
    options: useCache && cachedQuery ? cachedQuery : options
  });
}
export function withAsync(Component) {
  var AsyncTypeahead = /*#__PURE__*/forwardRef(function (props, ref) {
    return /*#__PURE__*/React.createElement(Component, _extends({}, useAsync(props), {
      ref: ref
    }));
  });
  AsyncTypeahead.displayName = "withAsync(".concat(getDisplayName(Component), ")"); // $FlowFixMe

  AsyncTypeahead.propTypes = propTypes; // $FlowFixMe

  AsyncTypeahead.defaultProps = defaultProps;
  return AsyncTypeahead;
}
export default function asyncContainer(Component) {
  /* istanbul ignore next */
  warn(false, 'The `asyncContainer` export is deprecated; use `withAsync` instead.');
  /* istanbul ignore next */

  return withAsync(Component);
}