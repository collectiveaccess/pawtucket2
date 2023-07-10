import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["labelKey", "newSelectionPrefix", "options", "paginationText", "renderMenuItemChildren", "text"];
import React, { Fragment } from 'react';
import PropTypes from 'prop-types';
import Highlighter from './Highlighter';
import Menu from './Menu';
import MenuItem from './MenuItem';
import { getOptionLabel, getOptionProperty } from '../utils';
var propTypes = {
  /**
   * Provides the ability to specify a prefix before the user-entered text to
   * indicate that the selection will be new. No-op unless `allowNew={true}`.
   */
  newSelectionPrefix: PropTypes.node,

  /**
   * Prompt displayed when large data sets are paginated.
   */
  paginationText: PropTypes.node,

  /**
   * Provides a hook for customized rendering of menu item contents.
   */
  renderMenuItemChildren: PropTypes.func
};
var defaultProps = {
  newSelectionPrefix: 'New selection: ',
  paginationText: 'Display additional results...',
  renderMenuItemChildren: function renderMenuItemChildren(option, props, idx) {
    return /*#__PURE__*/React.createElement(Highlighter, {
      search: props.text
    }, getOptionLabel(option, props.labelKey));
  }
};

var TypeaheadMenu = function TypeaheadMenu(props) {
  var labelKey = props.labelKey,
      newSelectionPrefix = props.newSelectionPrefix,
      options = props.options,
      paginationText = props.paginationText,
      renderMenuItemChildren = props.renderMenuItemChildren,
      text = props.text,
      menuProps = _objectWithoutProperties(props, _excluded);

  var renderMenuItem = function renderMenuItem(option, position) {
    var label = getOptionLabel(option, labelKey);
    var menuItemProps = {
      disabled: getOptionProperty(option, 'disabled'),
      label: label,
      option: option,
      position: position
    };

    if (option.customOption) {
      return /*#__PURE__*/React.createElement(MenuItem, _extends({}, menuItemProps, {
        className: "rbt-menu-custom-option",
        key: position,
        label: label
      }), newSelectionPrefix, /*#__PURE__*/React.createElement(Highlighter, {
        search: text
      }, label));
    }

    if (option.paginationOption) {
      return /*#__PURE__*/React.createElement(Fragment, {
        key: "pagination-item"
      }, /*#__PURE__*/React.createElement(Menu.Divider, null), /*#__PURE__*/React.createElement(MenuItem, _extends({}, menuItemProps, {
        className: "rbt-menu-pagination-option",
        label: paginationText
      }), paginationText));
    }

    return /*#__PURE__*/React.createElement(MenuItem, _extends({}, menuItemProps, {
      key: position
    }), renderMenuItemChildren(option, props, position));
  };

  return (
    /*#__PURE__*/
    // Explictly pass `text` so Flow doesn't complain...
    React.createElement(Menu, _extends({}, menuProps, {
      text: text
    }), options.map(renderMenuItem))
  );
};

TypeaheadMenu.propTypes = propTypes;
TypeaheadMenu.defaultProps = defaultProps;
export default TypeaheadMenu;