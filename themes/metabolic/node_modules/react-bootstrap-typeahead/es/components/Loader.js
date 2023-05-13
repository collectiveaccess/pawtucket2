import PropTypes from 'prop-types';
import React from 'react';
var propTypes = {
  label: PropTypes.string
};
var defaultProps = {
  label: 'Loading...'
};

var Loader = function Loader(_ref) {
  var label = _ref.label;
  return /*#__PURE__*/React.createElement("div", {
    className: "rbt-loader spinner-border spinner-border-sm",
    role: "status"
  }, /*#__PURE__*/React.createElement("span", {
    className: "sr-only visually-hidden"
  }, label));
};

Loader.propTypes = propTypes;
Loader.defaultProps = defaultProps;
export default Loader;