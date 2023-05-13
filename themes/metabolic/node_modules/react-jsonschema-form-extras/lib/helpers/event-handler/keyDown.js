"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
var callBacks = [];

exports.default = {
  onKeyDown: function onKeyDown(event) {
    callBacks.forEach(function (callBack) {
      callBack(event);
    });
  },

  registerCallBack: function registerCallBack(callBack) {
    callBacks.push(callBack);
  },

  deregisterCallBack: function deregisterCallBack(callBack) {
    callBacks = callBacks.filter(function (cb) {
      return cb !== callBack;
    });
  }
};