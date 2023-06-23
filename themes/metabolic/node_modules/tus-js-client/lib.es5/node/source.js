"use strict";

require("core-js/modules/es.symbol");

require("core-js/modules/es.symbol.description");

require("core-js/modules/es.symbol.iterator");

require("core-js/modules/es.array.iterator");

require("core-js/modules/es.array.slice");

require("core-js/modules/es.date.to-string");

require("core-js/modules/es.object.create");

require("core-js/modules/es.object.define-property");

require("core-js/modules/es.object.set-prototype-of");

require("core-js/modules/es.object.to-string");

require("core-js/modules/es.reflect.construct");

require("core-js/modules/es.regexp.to-string");

require("core-js/modules/es.string.iterator");

require("core-js/modules/web.dom-collections.iterator");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getSource = getSource;

var _stream = require("stream");

var _fs = require("fs");

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { return function () { var Super = _getPrototypeOf(Derived), result; if (_isNativeReflectConstruct()) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var BufferSource = /*#__PURE__*/function () {
  function BufferSource(buffer) {
    _classCallCheck(this, BufferSource);

    this._buffer = buffer;
    this.size = buffer.length;
  }

  _createClass(BufferSource, [{
    key: "slice",
    value: function slice(start, end, callback) {
      var buf = this._buffer.slice(start, end);

      buf.size = buf.length;
      callback(null, buf);
    }
  }, {
    key: "close",
    value: function close() {}
  }]);

  return BufferSource;
}();

var FileSource = /*#__PURE__*/function () {
  function FileSource(stream) {
    _classCallCheck(this, FileSource);

    this._stream = stream;
    this._path = stream.path.toString();
  }

  _createClass(FileSource, [{
    key: "slice",
    value: function slice(start, end, callback) {
      var stream = (0, _fs.createReadStream)(this._path, {
        start: start,
        // The `end` option for createReadStream is treated inclusively
        // (see https://nodejs.org/api/fs.html#fs_fs_createreadstream_path_options).
        // However, the Buffer#slice(start, end) and also our Source#slice(start, end)
        // method treat the end range exclusively, so we have to subtract 1.
        // This prevents an off-by-one error when reporting upload progress.
        end: end - 1,
        autoClose: true
      });
      stream.size = end - start;
      callback(null, stream);
    }
  }, {
    key: "close",
    value: function close() {
      this._stream.destroy();
    }
  }]);

  return FileSource;
}();

var StreamSource = /*#__PURE__*/function () {
  function StreamSource(stream, chunkSize) {
    var _this = this;

    _classCallCheck(this, StreamSource);

    // Ensure that chunkSize is an integer and not something else or Infinity.
    chunkSize = +chunkSize;

    if (!isFinite(chunkSize)) {
      throw new Error("cannot create source for stream without a finite value for the `chunkSize` option");
    }

    this._stream = stream; // Setting the size to null indicates that we have no calculation available
    // for how much data this stream will emit requiring the user to specify
    // it manually (see the `uploadSize` option).

    this.size = null;
    stream.pause();
    this._done = false;
    stream.on("end", function () {
      return _this._done = true;
    });
    this._buf = Buffer.alloc(chunkSize);
    this._bufPos = null;
    this._bufLen = 0;
  }

  _createClass(StreamSource, [{
    key: "slice",
    value: function slice(start, end, callback) {
      // Always attempt to drain the buffer first, even if this means that we
      // return less data, then the caller requested.
      if (start >= this._bufPos && start < this._bufPos + this._bufLen) {
        var bufStart = start - this._bufPos;
        var bufEnd = Math.min(this._bufLen, end - this._bufPos);

        var buf = this._buf.slice(bufStart, bufEnd);

        buf.size = buf.length;
        callback(null, buf);
        return;
      } // Fail fast if the caller requests a proportion of the data which is not
      // available any more.


      if (start < this._bufPos) {
        callback(new Error("cannot slice from position which we already seeked away"));
        return;
      }

      if (this._done) {
        callback(null, null, this._done);
        return;
      }

      var bytesToSkip = start - (this._bufPos + this._bufLen);
      this._bufLen = 0;
      this._bufPos = start;
      var bytesToRead = end - start;
      var slicingStream = new SlicingStream(bytesToSkip, bytesToRead, this);

      this._stream.pipe(slicingStream);

      callback(null, slicingStream);
    }
  }, {
    key: "close",
    value: function close() {// not implemented
    }
  }]);

  return StreamSource;
}();

var SlicingStream = /*#__PURE__*/function (_Transform) {
  _inherits(SlicingStream, _Transform);

  var _super = _createSuper(SlicingStream);

  function SlicingStream(bytesToSkip, bytesToRead, source) {
    var _this2;

    _classCallCheck(this, SlicingStream);

    _this2 = _super.call(this); // The number of bytes we have to discard before we start emitting data.

    _this2._bytesToSkip = bytesToSkip; // The number of bytes we will emit in the data events before ending this stream.

    _this2._bytesToRead = bytesToRead; // Points to the StreamSource object which created this SlicingStream.
    // This reference is used for manipulating the _bufLen and _buf properties
    // directly.

    _this2._source = source;
    return _this2;
  }

  _createClass(SlicingStream, [{
    key: "_transform",
    value: function _transform(chunk, encoding, callback) {
      // Calculate the number of bytes we still have to skip before we can emit data.
      var bytesSkipped = Math.min(this._bytesToSkip, chunk.length);
      this._bytesToSkip -= bytesSkipped; // Calculate the number of bytes we can emit after we skipped enough data.

      var bytesAvailable = chunk.length - bytesSkipped; // If no bytes are available, because the entire chunk was skipped, we can
      // return earily.

      if (bytesAvailable === 0) {
        callback(null);
        return;
      }

      var bytesToRead = Math.min(this._bytesToRead, bytesAvailable);
      this._bytesToRead -= bytesToRead;

      if (bytesToRead !== 0) {
        var data = chunk.slice(bytesSkipped, bytesSkipped + bytesToRead);
        this._source._bufLen += data.copy(this._source._buf, this._source._bufLen);
        this.push(data);
      } // If we do not have to read any more bytes for this transform stream, we
      // end it and also unpipe our source, to avoid calls to _transform in the
      // future


      if (this._bytesToRead === 0) {
        this._source._stream.unpipe(this);

        this.end();
      } // If we did not use all the available data, we return it to the source
      // so the next SlicingStream can handle it.


      if (bytesToRead !== bytesAvailable) {
        var unusedChunk = chunk.slice(bytesSkipped + bytesToRead);

        this._source._stream.unshift(unusedChunk);
      }

      callback(null);
    }
  }]);

  return SlicingStream;
}(_stream.Transform);

function getSource(input, chunkSize, callback) {
  if (Buffer.isBuffer(input)) {
    return callback(null, new BufferSource(input));
  }

  if (input instanceof _fs.ReadStream && input.path != null) {
    return callback(null, new FileSource(input));
  }

  if (input instanceof _stream.Readable) {
    return callback(null, new StreamSource(input, chunkSize));
  }

  callback(new Error("source object may only be an instance of Buffer or Readable in this environment"));
}