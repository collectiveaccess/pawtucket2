"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = getDisplayName;

function getDisplayName(Component) {
  return Component.displayName || Component.name || 'Component';
}