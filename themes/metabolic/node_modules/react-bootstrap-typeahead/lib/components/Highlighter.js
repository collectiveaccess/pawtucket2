"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _react = _interopRequireDefault(require("react"));

var _utils = require("../utils");

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

var propTypes = {
  children: _propTypes["default"].string.isRequired,
  highlightClassName: _propTypes["default"].string,
  search: _propTypes["default"].string.isRequired
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
  (0, _inherits2["default"])(Highlighter, _React$PureComponent);

  var _super = _createSuper(Highlighter);

  function Highlighter() {
    (0, _classCallCheck2["default"])(this, Highlighter);
    return _super.apply(this, arguments);
  }

  (0, _createClass2["default"])(Highlighter, [{
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
        var bounds = (0, _utils.getMatchBounds)(remaining, search); // No match anywhere in the remaining string, stop.

        if (!bounds) {
          highlighterChildren.push(remaining);
          break;
        } // Capture the string that leads up to a match.


        var nonMatch = remaining.slice(0, bounds.start);

        if (nonMatch) {
          highlighterChildren.push(nonMatch);
        } // Capture the matching string.


        var match = remaining.slice(bounds.start, bounds.end);
        highlighterChildren.push( /*#__PURE__*/_react["default"].createElement("mark", {
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
}(_react["default"].PureComponent);

(0, _defineProperty2["default"])(Highlighter, "propTypes", propTypes);
(0, _defineProperty2["default"])(Highlighter, "defaultProps", defaultProps);
var _default = Highlighter;
exports["default"] = _default;