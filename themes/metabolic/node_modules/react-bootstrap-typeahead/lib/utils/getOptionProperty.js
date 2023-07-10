"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = getOptionProperty;

var _nodash = require("./nodash");

function getOptionProperty(option, key) {
  if ((0, _nodash.isString)(option)) {
    return undefined;
  }

  return option[key];
}