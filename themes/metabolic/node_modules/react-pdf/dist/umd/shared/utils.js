"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.isDefined = isDefined;
exports.isProvided = isProvided;
exports.isString = isString;
exports.isArrayBuffer = isArrayBuffer;
exports.isBlob = isBlob;
exports.isFile = isFile;
exports.isDataURI = isDataURI;
exports.dataURItoByteString = dataURItoByteString;
exports.getPixelRatio = getPixelRatio;
exports.warnOnDev = warnOnDev;
exports.errorOnDev = errorOnDev;
exports.displayCORSWarning = displayCORSWarning;
exports.cancelRunningTask = cancelRunningTask;
exports.makePageCallback = makePageCallback;
exports.isCancelException = isCancelException;
exports.loadFromFile = loadFromFile;
exports.isProduction = exports.isLocalFileSystem = exports.isBrowser = void 0;

var _slicedToArray2 = _interopRequireDefault(require("@babel/runtime/helpers/slicedToArray"));

/**
 * Checks if we're running in a browser environment.
 */
var isBrowser = typeof window !== 'undefined';
/**
 * Checks whether we're running from a local file system.
 */

exports.isBrowser = isBrowser;
var isLocalFileSystem = isBrowser && window.location.protocol === 'file:';
/**
 * Checks whether we're running on a production build or not.
 */

exports.isLocalFileSystem = isLocalFileSystem;
var isProduction = process.env.NODE_ENV === 'production';
/**
 * Checks whether a variable is defined.
 *
 * @param {*} variable Variable to check
 */

exports.isProduction = isProduction;

function isDefined(variable) {
  return typeof variable !== 'undefined';
}
/**
 * Checks whether a variable is defined and not null.
 *
 * @param {*} variable Variable to check
 */


function isProvided(variable) {
  return isDefined(variable) && variable !== null;
}
/**
 * Checkes whether a variable provided is a string.
 *
 * @param {*} variable Variable to check
 */


function isString(variable) {
  return typeof variable === 'string';
}
/**
 * Checks whether a variable provided is an ArrayBuffer.
 *
 * @param {*} variable Variable to check
 */


function isArrayBuffer(variable) {
  return variable instanceof ArrayBuffer;
}
/**
 * Checkes whether a variable provided is a Blob.
 *
 * @param {*} variable Variable to check
 */


function isBlob(variable) {
  if (!isBrowser) {
    throw new Error('Attempted to check if a variable is a Blob on a non-browser environment.');
  }

  return variable instanceof Blob;
}
/**
 * Checkes whether a variable provided is a File.
 *
 * @param {*} variable Variable to check
 */


function isFile(variable) {
  if (!isBrowser) {
    throw new Error('Attempted to check if a variable is a File on a non-browser environment.');
  }

  return variable instanceof File;
}
/**
 * Checks whether a string provided is a data URI.
 *
 * @param {string} str String to check
 */


function isDataURI(str) {
  return isString(str) && /^data:/.test(str);
}

function dataURItoByteString(dataURI) {
  if (!isDataURI(dataURI)) {
    throw new Error('Invalid data URI.');
  }

  var _dataURI$split = dataURI.split(','),
      _dataURI$split2 = (0, _slicedToArray2["default"])(_dataURI$split, 2),
      headersString = _dataURI$split2[0],
      dataString = _dataURI$split2[1];

  var headers = headersString.split(';');

  if (headers.indexOf('base64') !== -1) {
    return atob(dataString);
  }

  return unescape(dataString);
}

function getPixelRatio() {
  return isBrowser && window.devicePixelRatio || 1;
}

function consoleOnDev(method) {
  if (!isProduction) {
    var _console;

    for (var _len = arguments.length, message = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
      message[_key - 1] = arguments[_key];
    }

    // eslint-disable-next-line no-console
    (_console = console)[method].apply(_console, message);
  }
}

function warnOnDev() {
  for (var _len2 = arguments.length, message = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
    message[_key2] = arguments[_key2];
  }

  consoleOnDev.apply(void 0, ['warn'].concat(message));
}

function errorOnDev() {
  for (var _len3 = arguments.length, message = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
    message[_key3] = arguments[_key3];
  }

  consoleOnDev.apply(void 0, ['error'].concat(message));
}

function displayCORSWarning() {
  if (isLocalFileSystem) {
    warnOnDev('Loading PDF as base64 strings/URLs might not work on protocols other than HTTP/HTTPS. On Google Chrome, you can use --allow-file-access-from-files flag for debugging purposes.');
  }
}

function cancelRunningTask(runningTask) {
  if (runningTask && runningTask.cancel) runningTask.cancel();
}

function makePageCallback(page, scale) {
  Object.defineProperty(page, 'width', {
    get: function get() {
      return this.view[2] * scale;
    },
    configurable: true
  });
  Object.defineProperty(page, 'height', {
    get: function get() {
      return this.view[3] * scale;
    },
    configurable: true
  });
  Object.defineProperty(page, 'originalWidth', {
    get: function get() {
      return this.view[2];
    },
    configurable: true
  });
  Object.defineProperty(page, 'originalHeight', {
    get: function get() {
      return this.view[3];
    },
    configurable: true
  });
  return page;
}

function isCancelException(error) {
  return error.name === 'RenderingCancelledException';
}

function loadFromFile(file) {
  return new Promise(function (resolve, reject) {
    var reader = new FileReader();

    reader.onload = function () {
      return resolve(new Uint8Array(reader.result));
    };

    reader.onerror = function (event) {
      switch (event.target.error.code) {
        case event.target.error.NOT_FOUND_ERR:
          return reject(new Error('Error while reading a file: File not found.'));

        case event.target.error.NOT_READABLE_ERR:
          return reject(new Error('Error while reading a file: File not readable.'));

        case event.target.error.SECURITY_ERR:
          return reject(new Error('Error while reading a file: Security error.'));

        case event.target.error.ABORT_ERR:
          return reject(new Error('Error while reading a file: Aborted.'));

        default:
          return reject(new Error('Error while reading a file.'));
      }
    };

    reader.readAsArrayBuffer(file);
    return null;
  });
}