"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _interopRequireWildcard = require("@babel/runtime/helpers/interopRequireWildcard");

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "Document", {
  enumerable: true,
  get: function get() {
    return _Document["default"];
  }
});
Object.defineProperty(exports, "Outline", {
  enumerable: true,
  get: function get() {
    return _Outline["default"];
  }
});
Object.defineProperty(exports, "Page", {
  enumerable: true,
  get: function get() {
    return _Page["default"];
  }
});
exports.pdfjs = void 0;

var pdfjs = _interopRequireWildcard(require("pdfjs-dist/es5/build/pdf"));

exports.pdfjs = pdfjs;

var _Document = _interopRequireDefault(require("./Document"));

var _Outline = _interopRequireDefault(require("./Outline"));

var _Page = _interopRequireDefault(require("./Page"));

require("./pdf.worker.entry");