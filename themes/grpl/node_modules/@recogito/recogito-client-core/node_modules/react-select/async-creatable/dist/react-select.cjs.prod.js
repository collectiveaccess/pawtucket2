"use strict";

Object.defineProperty(exports, "__esModule", {
  value: !0
});

var async_dist_reactSelect = require("../../async/dist/react-select.cjs.prod.js"), creatable_dist_reactSelect = require("../../creatable/dist/react-select.cjs.prod.js"), stateManager = require("../../dist/stateManager-799f6a0f.cjs.prod.js"), base_dist_reactSelect = require("../../dist/Select-fd7cb895.cjs.prod.js");

require("@babel/runtime/helpers/extends"), require("@babel/runtime/helpers/objectWithoutProperties"), 
require("@babel/runtime/helpers/defineProperty"), require("../../dist/index-ea9e225d.cjs.prod.js"), 
require("@emotion/react"), require("@babel/runtime/helpers/taggedTemplateLiteral"), 
require("@babel/runtime/helpers/typeof"), require("react-input-autosize"), require("@babel/runtime/helpers/classCallCheck"), 
require("@babel/runtime/helpers/createClass"), require("@babel/runtime/helpers/inherits"), 
require("react"), require("react-dom"), require("@babel/runtime/helpers/toConsumableArray"), 
require("memoize-one");

var SelectCreatable = creatable_dist_reactSelect.makeCreatableSelect(base_dist_reactSelect.Select), SelectCreatableState = stateManager.manageState(SelectCreatable), AsyncCreatable = async_dist_reactSelect.makeAsyncSelect(SelectCreatableState);

exports.default = AsyncCreatable;
