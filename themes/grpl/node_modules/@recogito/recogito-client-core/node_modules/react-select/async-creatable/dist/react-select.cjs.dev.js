'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var async_dist_reactSelect = require('../../async/dist/react-select.cjs.dev.js');
var creatable_dist_reactSelect = require('../../creatable/dist/react-select.cjs.dev.js');
var stateManager = require('../../dist/stateManager-80f4e9df.cjs.dev.js');
var base_dist_reactSelect = require('../../dist/Select-92d95971.cjs.dev.js');
require('@babel/runtime/helpers/extends');
require('@babel/runtime/helpers/objectWithoutProperties');
require('@babel/runtime/helpers/defineProperty');
require('../../dist/index-fe3694ff.cjs.dev.js');
require('@emotion/react');
require('@babel/runtime/helpers/taggedTemplateLiteral');
require('@babel/runtime/helpers/typeof');
require('react-input-autosize');
require('@babel/runtime/helpers/classCallCheck');
require('@babel/runtime/helpers/createClass');
require('@babel/runtime/helpers/inherits');
require('react');
require('react-dom');
require('@babel/runtime/helpers/toConsumableArray');
require('memoize-one');

var SelectCreatable = creatable_dist_reactSelect.makeCreatableSelect(base_dist_reactSelect.Select);
var SelectCreatableState = stateManager.manageState(SelectCreatable);
var AsyncCreatable = async_dist_reactSelect.makeAsyncSelect(SelectCreatableState);

exports.default = AsyncCreatable;
