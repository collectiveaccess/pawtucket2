import _defineProperty from "@babel/runtime/helpers/defineProperty";
import _objectWithoutProperties from "@babel/runtime/helpers/objectWithoutProperties";
var _excluded = ["activeIndex", "id", "isFocused", "isMenuShown", "multiple", "onFocus", "placeholder"],
    _excluded2 = ["className"];

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

import cx from 'classnames';
import getMenuItemId from './getMenuItemId';

var getInputProps = function getInputProps(_ref) {
  var activeIndex = _ref.activeIndex,
      id = _ref.id,
      isFocused = _ref.isFocused,
      isMenuShown = _ref.isMenuShown,
      multiple = _ref.multiple,
      onFocus = _ref.onFocus,
      placeholder = _ref.placeholder,
      rest = _objectWithoutProperties(_ref, _excluded);

  return function () {
    var _cx;

    var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
        className = _ref2.className,
        inputProps = _objectWithoutProperties(_ref2, _excluded2);

    var props = _objectSpread(_objectSpread(_objectSpread({
      /* eslint-disable sort-keys */
      // These props can be overridden by values in `inputProps`.
      autoComplete: 'off',
      placeholder: placeholder,
      type: 'text'
    }, inputProps), rest), {}, {
      'aria-activedescendant': activeIndex >= 0 ? getMenuItemId(id, activeIndex) : undefined,
      'aria-autocomplete': 'both',
      'aria-expanded': isMenuShown,
      'aria-haspopup': 'listbox',
      'aria-owns': isMenuShown ? id : undefined,
      className: cx((_cx = {}, _defineProperty(_cx, className || '', !multiple), _defineProperty(_cx, "focus", isFocused), _cx)),
      onClick: function onClick(e) {
        // Re-open the menu if it's closed, eg: via ESC.
        onFocus && onFocus(e);
        inputProps.onClick && inputProps.onClick(e);
      },
      onFocus: onFocus,
      // Comboboxes are single-select by definition:
      // https://www.w3.org/TR/wai-aria-practices-1.1/#combobox
      role: 'combobox'
      /* eslint-enable sort-keys */

    });

    if (!multiple) {
      return props;
    }

    return _objectSpread(_objectSpread({}, props), {}, {
      'aria-autocomplete': 'list',
      'aria-expanded': undefined,
      inputClassName: className,
      role: undefined
    });
  };
};

export default getInputProps;