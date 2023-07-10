"use strict";

require("core-js/modules/es.symbol");

require("core-js/modules/es.symbol.description");

require("core-js/modules/es.symbol.iterator");

require("core-js/modules/es.array.concat");

require("core-js/modules/es.array.iterator");

require("core-js/modules/es.date.to-string");

require("core-js/modules/es.object.create");

require("core-js/modules/es.object.define-property");

require("core-js/modules/es.object.set-prototype-of");

require("core-js/modules/es.object.to-string");

require("core-js/modules/es.promise");

require("core-js/modules/es.reflect.construct");

require("core-js/modules/es.regexp.to-string");

require("core-js/modules/es.string.iterator");

require("core-js/modules/web.dom-collections.iterator");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var http = _interopRequireWildcard(require("http"));

var https = _interopRequireWildcard(require("https"));

var _url = require("url");

var _stream = require("stream");

var _lodash = _interopRequireDefault(require("lodash.throttle"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _getRequireWildcardCache() { if (typeof WeakMap !== "function") return null; var cache = new WeakMap(); _getRequireWildcardCache = function _getRequireWildcardCache() { return cache; }; return cache; }

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

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

var NodeHttpStack = /*#__PURE__*/function () {
  function NodeHttpStack() {
    _classCallCheck(this, NodeHttpStack);
  }

  _createClass(NodeHttpStack, [{
    key: "createRequest",
    value: function createRequest(method, url) {
      return new Request(method, url);
    }
  }, {
    key: "getName",
    value: function getName() {
      return "NodeHttpStack";
    }
  }]);

  return NodeHttpStack;
}();

exports["default"] = NodeHttpStack;

var Request = /*#__PURE__*/function () {
  function Request(method, url) {
    _classCallCheck(this, Request);

    this._method = method;
    this._url = url;
    this._headers = {};
    this._request = null;

    this._progressHandler = function () {};
  }

  _createClass(Request, [{
    key: "getMethod",
    value: function getMethod() {
      return this._method;
    }
  }, {
    key: "getURL",
    value: function getURL() {
      return this._url;
    }
  }, {
    key: "setHeader",
    value: function setHeader(header, value) {
      this._headers[header] = value;
    }
  }, {
    key: "getHeader",
    value: function getHeader(header) {
      return this._headers[header];
    }
  }, {
    key: "setProgressHandler",
    value: function setProgressHandler(progressHandler) {
      this._progressHandler = progressHandler;
    }
  }, {
    key: "send",
    value: function send() {
      var _this = this;

      var body = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      return new Promise(function (resolve, reject) {
        var options = (0, _url.parse)(_this._url);
        options.method = _this._method;
        options.headers = _this._headers;
        if (body && body.size) options.headers["Content-Length"] = body.size;
        var req = _this._request = options.protocol !== "https:" ? http.request(options) : https.request(options);
        req.on("response", function (res) {
          var resChunks = [];
          res.on("data", function (data) {
            resChunks.push(data);
          });
          res.on("end", function () {
            var responseText = Buffer.concat(resChunks).toString("utf8");
            resolve(new Response(res, responseText));
          });
        });
        req.on("error", function (err) {
          reject(err);
        });

        if (body instanceof _stream.Readable) {
          body.pipe(new ProgressEmitter(_this._progressHandler)).pipe(req);
        } else {
          req.end(body);
        }
      });
    }
  }, {
    key: "abort",
    value: function abort() {
      if (this._request !== null) this._request.abort();
      return Promise.resolve();
    }
  }, {
    key: "getUnderlyingObject",
    value: function getUnderlyingObject() {
      return this._request;
    }
  }]);

  return Request;
}();

var Response = /*#__PURE__*/function () {
  function Response(res, body) {
    _classCallCheck(this, Response);

    this._response = res;
    this._body = body;
  }

  _createClass(Response, [{
    key: "getStatus",
    value: function getStatus() {
      return this._response.statusCode;
    }
  }, {
    key: "getHeader",
    value: function getHeader(header) {
      return this._response.headers[header.toLowerCase()];
    }
  }, {
    key: "getBody",
    value: function getBody() {
      return this._body;
    }
  }, {
    key: "getUnderlyingObject",
    value: function getUnderlyingObject() {
      return this._response;
    }
  }]);

  return Response;
}(); // ProgressEmitter is a simple PassThrough-style transform stream which keeps
// track of the number of bytes which have been piped through it and will
// invoke the `onprogress` function whenever new number are available.


var ProgressEmitter = /*#__PURE__*/function (_Transform) {
  _inherits(ProgressEmitter, _Transform);

  var _super = _createSuper(ProgressEmitter);

  function ProgressEmitter(onprogress) {
    var _this2;

    _classCallCheck(this, ProgressEmitter);

    _this2 = _super.call(this); // The _onprogress property will be invoked, whenever a chunk is piped
    // through this transformer. Since chunks are usually quite small (64kb),
    // these calls can occur frequently, especially when you have a good
    // connection to the remote server. Therefore, we are throtteling them to
    // prevent accessive function calls.

    _this2._onprogress = (0, _lodash["default"])(onprogress, 100, {
      leading: true,
      trailing: false
    });
    _this2._position = 0;
    return _this2;
  }

  _createClass(ProgressEmitter, [{
    key: "_transform",
    value: function _transform(chunk, encoding, callback) {
      this._position += chunk.length;

      this._onprogress(this._position);

      callback(null, chunk);
    }
  }]);

  return ProgressEmitter;
}(_stream.Transform);