import { createContext, useContext } from 'react';
import { noop } from '../utils';
export var TypeaheadContext = /*#__PURE__*/createContext({
  activeIndex: -1,
  hintText: '',
  id: '',
  initialItem: null,
  inputNode: null,
  isOnlyResult: false,
  onActiveItemChange: noop,
  onAdd: noop,
  onInitialItemChange: noop,
  onMenuItemClick: noop,
  selectHintOnEnter: undefined,
  setItem: noop
});
export var useTypeaheadContext = function useTypeaheadContext() {
  return useContext(TypeaheadContext);
};