import _classCallCheck from "@babel/runtime/helpers/classCallCheck";
import _createClass from "@babel/runtime/helpers/createClass";
import _inherits from "@babel/runtime/helpers/inherits";
import _possibleConstructorReturn from "@babel/runtime/helpers/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime/helpers/getPrototypeOf";
import _defineProperty from "@babel/runtime/helpers/defineProperty";

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

import PropTypes from 'prop-types';
import React from 'react';
import { getMatchBounds } from '../utils';
var propTypes = {
  children: PropTypes.string.isRequired,
  highlightClassName: PropTypes.string,
  search: PropTypes.string.isRequired
};
var defaultProps = {
  highlightClassName: 'rbt-highlight-text'
};

/**
 * Stripped-down version of https://github.com/helior/react-highlighter
 *
 * Results are already filtered by the time the component is used internally so
 * we can safely ignore case and diacritical marks for the purposes of matching.
 */
var Highlighter = /*#__PURE__*/function (_React$PureComponent) {
  _inherits(Highlighter, _React$PureComponent);

  var _super = _createSuper(Highlighter);

  function Highlighter() {
    _classCallCheck(this, Highlighter);

    return _super.apply(this, arguments);
  }

  _createClass(Highlighter, [{
    key: "render",
    value: function render() {
      var _this$props = this.props,
          children = _this$props.children,
          highlightClassName = _this$props.highlightClassName,
          search = _this$props.search;

      if (!search || !children) {
        return children;
      }

      var matchCount = 0;
      var remaining = children;
      var highlighterChildren = [];

      while (remaining) {
        var bounds = getMatchBounds(remaining, search); // No match anywhere in the remaining string, stop.

        if (!bounds) {
          highlighterChildren.push(remaining);
          break;
        } // Capture the string that leads up to a match.


        var nonMatch = remaining.slice(0, bounds.start);

        if (nonMatch) {
          highlighterChildren.push(nonMatch);
        } // Capture the matching string.


        var match = remaining.slice(bounds.start, bounds.end);
        highlighterChildren.push( /*#__PURE__*/React.createElement("mark", {
          className: highlightClassName,
          key: matchCount
        }, match));
        matchCount += 1; // And if there's anything left over, continue the loop.

        remaining = remaining.slice(bounds.end);
      }

      return highlighterChildren;
    }
  }]);

  return Highlighter;
}(React.PureComponent);

_defineProperty(Highlighter, "propTypes", propTypes);

_defineProperty(Highlighter, "defaultProps", defaultProps);

export default Highlighter;