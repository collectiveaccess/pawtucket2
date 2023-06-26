"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
var suggestionDropdownOpen = void 0;

exports.default = {
  open: function open() {
    suggestionDropdownOpen = true;
  },

  close: function close() {
    suggestionDropdownOpen = false;
  },

  isOpen: function isOpen() {
    return suggestionDropdownOpen;
  }
};