function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/* eslint no-unused-vars: 0 */
import { readFile, writeFile } from 'fs';
import * as lockfile from 'proper-lockfile';
import * as combineErrors from 'combine-errors';
export var canStoreURLs = true;
export var FileUrlStorage = /*#__PURE__*/function () {
  function FileUrlStorage(filePath) {
    _classCallCheck(this, FileUrlStorage);

    this.path = filePath;
  }

  _createClass(FileUrlStorage, [{
    key: "findAllUploads",
    value: function findAllUploads() {
      var _this = this;

      return new Promise(function (resolve, reject) {
        _this._getItems('tus::', function (err, results) {
          if (err) return reject(err);
          resolve(results);
        });
      });
    }
  }, {
    key: "findUploadsByFingerprint",
    value: function findUploadsByFingerprint(fingerprint) {
      var _this2 = this;

      return new Promise(function (resolve, reject) {
        _this2._getItems("tus::".concat(fingerprint), function (err, results) {
          if (err) return reject(err);
          resolve(results);
        });
      });
    }
  }, {
    key: "removeUpload",
    value: function removeUpload(urlStorageKey) {
      var _this3 = this;

      return new Promise(function (resolve, reject) {
        _this3._removeItem(urlStorageKey, function (err) {
          if (err) return reject(err);
          resolve();
        });
      });
    }
  }, {
    key: "addUpload",
    value: function addUpload(fingerprint, upload) {
      var _this4 = this;

      var id = Math.round(Math.random() * 1e12);
      var key = "tus::".concat(fingerprint, "::").concat(id);
      return new Promise(function (resolve, reject) {
        _this4._setItem(key, upload, function (err) {
          if (err) return reject(err);
          resolve(key);
        });
      });
    }
  }, {
    key: "_setItem",
    value: function _setItem(key, value, cb) {
      var _this5 = this;

      lockfile.lock(this.path, this._lockfileOptions(), function (err, release) {
        if (err) {
          return cb(err);
        }

        cb = _this5._releaseAndCb(release, cb);

        _this5._getData(function (err, data) {
          if (err) {
            return cb(err);
          }

          data[key] = value;

          _this5._writeData(data, function (err) {
            return cb(err);
          });
        });
      });
    }
  }, {
    key: "_getItems",
    value: function _getItems(prefix, cb) {
      this._getData(function (err, data) {
        if (err) {
          return cb(err);
        }

        var results = Object.keys(data).filter(function (key) {
          return key.startsWith(prefix);
        }).map(function (key) {
          var obj = data[key];
          obj.urlStorageKey = key;
          return obj;
        });
        cb(null, results);
      });
    }
  }, {
    key: "_removeItem",
    value: function _removeItem(key, cb) {
      var _this6 = this;

      lockfile.lock(this.path, this._lockfileOptions(), function (err, release) {
        if (err) {
          return cb(err);
        }

        cb = _this6._releaseAndCb(release, cb);

        _this6._getData(function (err, data) {
          if (err) {
            return cb(err);
          }

          delete data[key];

          _this6._writeData(data, function (err) {
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
        encoding: 'utf8',
        mode: 432,
        flag: 'w'
      };
      writeFile(this.path, JSON.stringify(data), opts, function (err) {
        return cb(err);
      });
    }
  }, {
    key: "_getData",
    value: function _getData(cb) {
      readFile(this.path, 'utf8', function (err, data) {
        if (err) {
          // return empty data if file does not exist
          err.code === 'ENOENT' ? cb(null, {}) : cb(err);
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

  return FileUrlStorage;
}();