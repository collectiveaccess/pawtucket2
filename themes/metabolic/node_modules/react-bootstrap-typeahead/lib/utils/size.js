"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.isSizeLarge = isSizeLarge;
exports.isSizeSmall = isSizeSmall;

function isSizeLarge(size) {
  return size === 'large' || size === 'lg';
}

function isSizeSmall(size) {
  return size === 'small' || size === 'sm';
}