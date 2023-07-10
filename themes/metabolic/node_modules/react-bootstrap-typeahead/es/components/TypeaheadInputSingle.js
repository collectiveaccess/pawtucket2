import _extends from "@babel/runtime/helpers/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["inputRef", "referenceElementRef", "shouldSelectHint"];
import React from 'react';
import Hint from './Hint';
import Input from './Input';
import withClassNames from '../behaviors/classNames';
export default withClassNames(function (_ref) {
  var inputRef = _ref.inputRef,
      referenceElementRef = _ref.referenceElementRef,
      shouldSelectHint = _ref.shouldSelectHint,
      props = _objectWithoutProperties(_ref, _excluded);

  return /*#__PURE__*/React.createElement(Hint, {
    shouldSelect: shouldSelectHint
  }, /*#__PURE__*/React.createElement(Input, _extends({}, props, {
    ref: function ref(node) {
      inputRef(node);
      referenceElementRef(node);
    }
  })));
});