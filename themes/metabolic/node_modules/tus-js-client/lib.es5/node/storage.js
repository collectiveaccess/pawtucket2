"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

require("core-js/modules/es.object.define-property");

require("core-js/modules/es.string.trim");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getStorage = getStorage;
exports.FileStorage = exports.canStoreURLs = void 0;

var _fs = require("fs");

var lockfile = _interopRequireWildcard(require("proper-lockfile"));

var combineErrors = _interopRequireWildcard(require("combine-errors"));

function _getRequireWildcardCache() { if (typeof WeakMap !== "function") return null; var cache = new WeakMap(); _getRequireWildcardCache = function _getRequireWildcardCache() { return cache; }; return cache; }

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var canStoreURLs = true;
exports.canStoreURLs = canStoreURLs;

function getStorage() {
  // don't support storage by default.
  return null;
}

var FileStorage = /*#__PURE__*/function () {
  function FileStorage(filePath) {
    _classCallCheck(this, FileStorage);

    this.path = filePath;
  }

  _createClass(FileStorage, [{
    key: "setItem",
    value: function setItem(key, value, cb) {
      var _this = this;

      lockfile.lock(this.path, this._lockfileOptions(), function (err, release) {
        if (err) {
          return cb(err);
        }

        cb = _this._releaseAndCb(release, cb);

        _this._getData(function (err, data) {
          if (err) {
            return cb(err);
          }

          data[key] = value;

          _this._writeData(data, function (err) {
            return cb(err);
          });
        });
      });
    }
  }, {
    key: "getItem",
    value: function getItem(key, cb) {
      this._getData(function (err, data) {
        if (err) {
          return cb(err);
        }

        cb(null, data[key]);
      });
    }
  }, {
    key: "removeItem",
    value: function removeItem(key, cb) {
      var _this2 = this;

      lockfile.lock(this.path, this._lockfileOptions(), function (err, release) {
        if (err) {
          return cb(err);
        }

        cb = _this2._releaseAndCb(release, cb);

        _this2._getData(function (err, data) {
          if (err) {
            return cb(err);
          }

          delete data[key];

          _this2._writeData(data, function (err) {
            return cb(err);
          });
        });
      });
    }
  }, {
    key: "_lockfileOptions",
    value: function _lockfileOptions() {
      return {
        realpath: false,
        retries: {
          retries: 5,
          minTimeout: 20
        }
      };
    }
  }, {
    key: "_releaseAndCb",
    value: function _releaseAndCb(release, cb) {
      return function (err) {
        if (err) {
          release(function (releaseErr) {
            err = releaseErr ? combineErrors([err, releaseErr]) : err;
            cb(err);
          });
          return;
        }

        release(cb);
      };
    }
  }, {
    key: "_writeData",
    value: function _writeData(data, cb) {
      var opts = {
        encoding: "utf8",
        mode: 432,
        flag: "w"
      };
      (0, _fs.writeFile)(this.path, JSON.stringify(data), opts, function (err) {
        return cb(err);
      });
    }
  }, {
    key: "_getData",
    value: function _getData(cb) {
      (0, _fs.readFile)(this.path, "utf8", function (err, data) {
        if (err) {
          // return empty data if file does not exist
          err.code === "ENOENT" ? cb(null, {}) : cb(err);
          return;
        } else {
          try {
            data = !data.trim().length ? {} : JSON.parse(data);
          } catch (error) {
            cb(error);
            return;
          }

          cb(null, data);
        }
      });
    }
  }]);

  return FileStorage;
}();

exports.FileStorage = FileStorage;