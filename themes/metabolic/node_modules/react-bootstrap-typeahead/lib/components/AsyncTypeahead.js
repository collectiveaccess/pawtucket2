"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _async = require("../behaviors/async");

var _Typeahead = _interopRequireDefault(require("./Typeahead"));

var _default = (0, _async.withAsync)(_Typeahead["default"]);

exports["default"] = _default;