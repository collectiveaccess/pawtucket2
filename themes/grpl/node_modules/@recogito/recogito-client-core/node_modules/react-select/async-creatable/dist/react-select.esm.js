import { makeAsyncSelect } from '../../async/dist/react-select.esm.js';
import { makeCreatableSelect } from '../../creatable/dist/react-select.esm.js';
import { m as manageState } from '../../dist/stateManager-845a3300.esm.js';
import { S as Select } from '../../dist/Select-dbb12e54.esm.js';
import '@babel/runtime/helpers/extends';
import '@babel/runtime/helpers/objectWithoutProperties';
import '@babel/runtime/helpers/defineProperty';
import '../../dist/index-4bd03571.esm.js';
import '@emotion/react';
import '@babel/runtime/helpers/taggedTemplateLiteral';
import '@babel/runtime/helpers/typeof';
import 'react-input-autosize';
import '@babel/runtime/helpers/classCallCheck';
import '@babel/runtime/helpers/createClass';
import '@babel/runtime/helpers/inherits';
import 'react';
import 'react-dom';
import '@babel/runtime/helpers/toConsumableArray';
import 'memoize-one';

var SelectCreatable = makeCreatableSelect(Select);
var SelectCreatableState = manageState(SelectCreatable);
var AsyncCreatable = makeAsyncSelect(SelectCreatableState);

export default AsyncCreatable;
