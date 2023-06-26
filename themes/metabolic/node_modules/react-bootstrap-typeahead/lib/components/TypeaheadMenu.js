"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _typeof = require("@babel/runtime/helpers/typeof");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _react = _interopRequireWildcard(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _Highlighter = _interopRequireDefault(require("./Highlighter"));

var _Menu = _interopRequireDefault(require("./Menu"));

var _MenuItem = _interopRequireDefault(require("./MenuItem"));

var _utils = require("../utils");

var _excluded = ["labelKey", "newSelectionPrefix", "options", "paginationText", "renderMenuItemChildren", "text"];

function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }

function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

var propTypes = {
  /**
   * Provides the ability to specify a prefix before the user-entered text to
   * indicate that the selection will be new. No-op unless `allowNew={true}`.
   */
  newSelectionPrefix: _propTypes["default"].node,

  /**
   * Prompt displayed when large data sets are paginated.
   */
  paginationText: _propTypes["default"].node,

  /**
   * Provides a hook for customized rendering of menu item contents.
   */
  renderMenuItemChildren: _propTypes["default"].func
};
var defaultProps = {
  newSelectionPrefix: 'New selection: ',
  paginationText: 'Display additional results...',
  renderMenuItemChildren: function renderMenuItemChildren(option, props, idx) {
    return /*#__PURE__*/_react["default"].createElement(_Highlighter["default"], {
      search: props.text
    }, (0, _utils.getOptionLabel)(option, props.labelKey));
  }
};

var TypeaheadMenu = function TypeaheadMenu(props) {
  var labelKey = props.labelKey,
      newSelectionPrefix = props.newSelectionPrefix,
      options = props.options,
      paginationText = props.paginationText,
      renderMenuItemChildren = props.renderMenuItemChildren,
      text = props.text,
      menuProps = (0, _objectWithoutProperties2["default"])(props, _excluded);

  var renderMenuItem = function renderMenuItem(option, position) {
    var label = (0, _utils.getOptionLabel)(option, labelKey);
    var menuItemProps = {
      disabled: (0, _utils.getOptionProperty)(option, 'disabled'),
      label: label,
      option: option,
      position: position
    };

    if (option.customOption) {
      return /*#__PURE__*/_react["default"].createElement(_MenuItem["default"], (0, _extends2["default"])({}, menuItemProps, {
        className: "rbt-menu-custom-option",
        key: position,
        label: label
      }), newSelectionPrefix, /*#__PURE__*/_react["default"].createElement(_Highlighter["default"], {
        search: text
      }, label));
    }

    if (option.paginationOption) {
      return /*#__PURE__*/_react["default"].createElement(_react.Fragment, {
        key: "pagination-item"
      }, /*#__PURE__*/_react["default"].createElement(_Menu["default"].Divider, null), /*#__PURE__*/_react["default"].createElement(_MenuItem["default"], (0, _extends2["default"])({}, menuItemProps, {
        className: "rbt-menu-pagination-option",
        label: paginationText
      }), paginationText));
    }

    return /*#__PURE__*/_react["default"].createElement(_MenuItem["default"], (0, _extends2["default"])({}, menuItemProps, {
      key: position
    }), renderMenuItemChildren(option, props, position));
  };

  return (
    /*#__PURE__*/
    // Explictly pass `text` so Flow doesn't complain...
    _react["default"].createElement(_Menu["default"], (0, _extends2["default"])({}, menuProps, {
      text: text
    }), options.map(renderMenuItem))
  );
};

TypeaheadMenu.propTypes = propTypes;
TypeaheadMenu.defaultProps = defaultProps;
var _default = TypeaheadMenu;
exports["default"] = _default;