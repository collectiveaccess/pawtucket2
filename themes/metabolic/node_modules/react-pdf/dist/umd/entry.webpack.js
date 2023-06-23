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

var pdfjs = _interopRequireWildcard(require("pdfjs-dist"));

exports.pdfjs = pdfjs;

var _pdf = _interopRequireDefault(require("file-loader!pdfjs-dist/build/pdf.worker"));

var _Document = _interopRequireDefault(require("./Document"));

var _Outline = _interopRequireDefault(require("./Outline"));

var _Page = _interopRequireDefault(require("./Page"));

var _utils = require("./shared/utils");

// eslint-disable-next-line
if (_utils.isLocalFileSystem) {
  (0, _utils.warnOnDev)('You are running React-PDF from your local file system. PDF.js Worker may fail to load due to browser\'s security policies. If you\'re on Google Chrome, you can use --allow-file-access-from-files flag for debugging purposes.');
}

pdfjs.GlobalWorkerOptions.workerSrc = _pdf["default"];