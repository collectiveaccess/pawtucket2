"use strict";

var _interopRequireWildcard = require("@babel/runtime/helpers/interopRequireWildcard");

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _typeof2 = _interopRequireDefault(require("@babel/runtime/helpers/typeof"));

var _regenerator = _interopRequireDefault(require("@babel/runtime/regenerator"));

var _asyncToGenerator2 = _interopRequireDefault(require("@babel/runtime/helpers/asyncToGenerator"));

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _assertThisInitialized2 = _interopRequireDefault(require("@babel/runtime/helpers/assertThisInitialized"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _possibleConstructorReturn2 = _interopRequireDefault(require("@babel/runtime/helpers/possibleConstructorReturn"));

var _getPrototypeOf2 = _interopRequireDefault(require("@babel/runtime/helpers/getPrototypeOf"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _react = _interopRequireWildcard(require("react"));

var _propTypes = _interopRequireDefault(require("prop-types"));

var _makeEventProps = _interopRequireDefault(require("make-event-props"));

var _makeCancellablePromise = _interopRequireDefault(require("make-cancellable-promise"));

var _mergeClassNames = _interopRequireDefault(require("merge-class-names"));

var pdfjs = _interopRequireWildcard(require("pdfjs-dist"));

var _DocumentContext = _interopRequireDefault(require("./DocumentContext"));

var _Message = _interopRequireDefault(require("./Message"));

var _LinkService = _interopRequireDefault(require("./LinkService"));

var _PasswordResponses = _interopRequireDefault(require("./PasswordResponses"));

var _utils = require("./shared/utils");

var _propTypes2 = require("./shared/propTypes");

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { (0, _defineProperty2["default"])(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

var PDFDataRangeTransport = pdfjs.PDFDataRangeTransport;

var Document = /*#__PURE__*/function (_PureComponent) {
  (0, _inherits2["default"])(Document, _PureComponent);

  var _super = _createSuper(Document);

  function Document() {
    var _this;

    (0, _classCallCheck2["default"])(this, Document);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "state", {
      pdf: null
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "viewer", {
      scrollPageIntoView: function scrollPageIntoView(_ref) {
        var pageNumber = _ref.pageNumber;
        // Handling jumping to internal links target
        var onItemClick = _this.props.onItemClick; // First, check if custom handling of onItemClick was provided

        if (onItemClick) {
          onItemClick({
            pageNumber: pageNumber
          });
          return;
        } // If not, try to look for target page within the <Document>.


        var page = _this.pages[pageNumber - 1];

        if (page) {
          // Scroll to the page automatically
          page.scrollIntoView();
          return;
        }

        (0, _utils.warnOnDev)("Warning: An internal link leading to page ".concat(pageNumber, " was clicked, but neither <Document> was provided with onItemClick nor it was able to find the page within itself. Either provide onItemClick to <Document> and handle navigating by yourself or ensure that all pages are rendered within <Document>."));
      }
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "linkService", new _LinkService["default"]());
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "loadDocument", /*#__PURE__*/(0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee() {
      var source, _this$props, options, onLoadProgress, onPassword, cancellable, pdf;

      return _regenerator["default"].wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              source = null;
              _context.prev = 1;
              _context.next = 4;
              return _this.findDocumentSource();

            case 4:
              source = _context.sent;

              _this.onSourceSuccess();

              _context.next = 11;
              break;

            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](1);

              _this.onSourceError(_context.t0);

            case 11:
              if (source) {
                _context.next = 13;
                break;
              }

              return _context.abrupt("return");

            case 13:
              _this.setState(function (prevState) {
                if (!prevState.pdf) {
                  return null;
                }

                return {
                  pdf: null
                };
              });

              _this$props = _this.props, options = _this$props.options, onLoadProgress = _this$props.onLoadProgress, onPassword = _this$props.onPassword;
              _context.prev = 15;
              // If another rendering is in progress, let's cancel it
              (0, _utils.cancelRunningTask)(_this.runningTask); // If another loading is in progress, let's destroy it

              if (_this.loadingTask) _this.loadingTask.destroy();
              _this.loadingTask = pdfjs.getDocument(_objectSpread(_objectSpread({}, source), options));
              _this.loadingTask.onPassword = onPassword;

              if (onLoadProgress) {
                _this.loadingTask.onProgress = onLoadProgress;
              }

              cancellable = (0, _makeCancellablePromise["default"])(_this.loadingTask.promise);
              _this.runningTask = cancellable;
              _context.next = 25;
              return cancellable.promise;

            case 25:
              pdf = _context.sent;

              _this.setState(function (prevState) {
                if (prevState.pdf && prevState.pdf.fingerprint === pdf.fingerprint) {
                  return null;
                }

                return {
                  pdf: pdf
                };
              }, _this.onLoadSuccess);

              _context.next = 32;
              break;

            case 29:
              _context.prev = 29;
              _context.t1 = _context["catch"](15);

              _this.onLoadError(_context.t1);

            case 32:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, null, [[1, 8], [15, 29]]);
    })));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "setupLinkService", function () {
      _this.linkService.setViewer(_this.viewer);

      var documentInstance = (0, _assertThisInitialized2["default"])(_this);
      Object.defineProperty(_this.linkService, 'externalLinkTarget', {
        get: function get() {
          var externalLinkTarget = documentInstance.props.externalLinkTarget;

          switch (externalLinkTarget) {
            case '_self':
              return 1;

            case '_blank':
              return 2;

            case '_parent':
              return 3;

            case '_top':
              return 4;

            default:
              return 0;
          }
        }
      });
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "onSourceSuccess", function () {
      var onSourceSuccess = _this.props.onSourceSuccess;
      if (onSourceSuccess) onSourceSuccess();
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "onSourceError", function (error) {
      (0, _utils.errorOnDev)(error);
      var onSourceError = _this.props.onSourceError;
      if (onSourceError) onSourceError(error);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "onLoadSuccess", function () {
      var onLoadSuccess = _this.props.onLoadSuccess;
      var pdf = _this.state.pdf;
      if (onLoadSuccess) onLoadSuccess(pdf);
      _this.pages = new Array(pdf.numPages);

      _this.linkService.setDocument(pdf);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "onLoadError", function (error) {
      _this.setState({
        pdf: false
      });

      (0, _utils.errorOnDev)(error);
      var onLoadError = _this.props.onLoadError;
      if (onLoadError) onLoadError(error);
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "findDocumentSource", /*#__PURE__*/(0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee2() {
      var file, fileByteString, url, otherParams, _fileByteString;

      return _regenerator["default"].wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              file = _this.props.file;

              if (file) {
                _context2.next = 3;
                break;
              }

              return _context2.abrupt("return", null);

            case 3:
              if (!(typeof file === 'string')) {
                _context2.next = 9;
                break;
              }

              if (!(0, _utils.isDataURI)(file)) {
                _context2.next = 7;
                break;
              }

              fileByteString = (0, _utils.dataURItoByteString)(file);
              return _context2.abrupt("return", {
                data: fileByteString
              });

            case 7:
              (0, _utils.displayCORSWarning)();
              return _context2.abrupt("return", {
                url: file
              });

            case 9:
              if (!(file instanceof PDFDataRangeTransport)) {
                _context2.next = 11;
                break;
              }

              return _context2.abrupt("return", {
                range: file
              });

            case 11:
              if (!(0, _utils.isArrayBuffer)(file)) {
                _context2.next = 13;
                break;
              }

              return _context2.abrupt("return", {
                data: file
              });

            case 13:
              if (!_utils.isBrowser) {
                _context2.next = 19;
                break;
              }

              if (!((0, _utils.isBlob)(file) || (0, _utils.isFile)(file))) {
                _context2.next = 19;
                break;
              }

              _context2.next = 17;
              return (0, _utils.loadFromFile)(file);

            case 17:
              _context2.t0 = _context2.sent;
              return _context2.abrupt("return", {
                data: _context2.t0
              });

            case 19:
              if (!((0, _typeof2["default"])(file) !== 'object')) {
                _context2.next = 21;
                break;
              }

              throw new Error('Invalid parameter in file, need either Uint8Array, string or a parameter object');

            case 21:
              if (!(!file.url && !file.data && !file.range)) {
                _context2.next = 23;
                break;
              }

              throw new Error('Invalid parameter object: need either .data, .range or .url');

            case 23:
              if (!(typeof file.url === 'string')) {
                _context2.next = 29;
                break;
              }

              if (!(0, _utils.isDataURI)(file.url)) {
                _context2.next = 28;
                break;
              }

              url = file.url, otherParams = (0, _objectWithoutProperties2["default"])(file, ["url"]);
              _fileByteString = (0, _utils.dataURItoByteString)(url);
              return _context2.abrupt("return", _objectSpread({
                data: _fileByteString
              }, otherParams));

            case 28:
              (0, _utils.displayCORSWarning)();

            case 29:
              return _context2.abrupt("return", file);

            case 30:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    })));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "registerPage", function (pageIndex, ref) {
      _this.pages[pageIndex] = ref;
    });
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "unregisterPage", function (pageIndex) {
      delete _this.pages[pageIndex];
    });
    return _this;
  }

  (0, _createClass2["default"])(Document, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      this.loadDocument();
      this.setupLinkService();
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate(prevProps) {
      var file = this.props.file;

      if (file !== prevProps.file) {
        this.loadDocument();
      }
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      // If rendering is in progress, let's cancel it
      (0, _utils.cancelRunningTask)(this.runningTask); // If loading is in progress, let's destroy it

      if (this.loadingTask) this.loadingTask.destroy();
    }
  }, {
    key: "renderChildren",
    value: function renderChildren() {
      var children = this.props.children;
      return /*#__PURE__*/_react["default"].createElement(_DocumentContext["default"].Provider, {
        value: this.childContext
      }, children);
    }
  }, {
    key: "renderContent",
    value: function renderContent() {
      var file = this.props.file;
      var pdf = this.state.pdf;

      if (!file) {
        var noData = this.props.noData;
        return /*#__PURE__*/_react["default"].createElement(_Message["default"], {
          type: "no-data"
        }, typeof noData === 'function' ? noData() : noData);
      }

      if (pdf === null) {
        var loading = this.props.loading;
        return /*#__PURE__*/_react["default"].createElement(_Message["default"], {
          type: "loading"
        }, typeof loading === 'function' ? loading() : loading);
      }

      if (pdf === false) {
        var error = this.props.error;
        return /*#__PURE__*/_react["default"].createElement(_Message["default"], {
          type: "error"
        }, typeof error === 'function' ? error() : error);
      }

      return this.renderChildren();
    }
  }, {
    key: "render",
    value: function render() {
      var _this$props2 = this.props,
          className = _this$props2.className,
          inputRef = _this$props2.inputRef;
      return /*#__PURE__*/_react["default"].createElement("div", (0, _extends2["default"])({
        className: (0, _mergeClassNames["default"])('react-pdf__Document', className),
        ref: inputRef
      }, this.eventProps), this.renderContent());
    }
  }, {
    key: "childContext",
    get: function get() {
      var linkService = this.linkService,
          registerPage = this.registerPage,
          unregisterPage = this.unregisterPage;
      var _this$props3 = this.props,
          imageResourcesPath = _this$props3.imageResourcesPath,
          renderMode = _this$props3.renderMode,
          rotate = _this$props3.rotate;
      var pdf = this.state.pdf;
      return {
        imageResourcesPath: imageResourcesPath,
        linkService: linkService,
        pdf: pdf,
        registerPage: registerPage,
        renderMode: renderMode,
        rotate: rotate,
        unregisterPage: unregisterPage
      };
    }
  }, {
    key: "eventProps",
    get: function get() {
      var _this2 = this;

      // eslint-disable-next-line react/destructuring-assignment
      return (0, _makeEventProps["default"])(this.props, function () {
        return _this2.state.pdf;
      });
    }
    /**
     * Called when a document source is resolved correctly
     */

  }]);
  return Document;
}(_react.PureComponent);

exports["default"] = Document;
Document.defaultProps = {
  error: 'Failed to load PDF file.',
  loading: 'Loading PDF…',
  noData: 'No PDF file specified.',
  onPassword: function onPassword(callback, reason) {
    switch (reason) {
      case _PasswordResponses["default"].NEED_PASSWORD:
        {
          // eslint-disable-next-line no-alert
          var password = prompt('Enter the password to open this PDF file.');
          callback(password);
          break;
        }

      case _PasswordResponses["default"].INCORRECT_PASSWORD:
        {
          // eslint-disable-next-line no-alert
          var _password = prompt('Invalid password. Please try again.');

          callback(_password);
          break;
        }

      default:
    }
  }
};

var isFunctionOrNode = _propTypes["default"].oneOfType([_propTypes["default"].func, _propTypes["default"].node]);

Document.propTypes = _objectSpread(_objectSpread({}, _propTypes2.eventProps), {}, {
  children: _propTypes["default"].node,
  className: _propTypes2.isClassName,
  error: isFunctionOrNode,
  file: _propTypes2.isFile,
  imageResourcesPath: _propTypes["default"].string,
  inputRef: _propTypes2.isRef,
  loading: isFunctionOrNode,
  noData: isFunctionOrNode,
  onItemClick: _propTypes["default"].func,
  onLoadError: _propTypes["default"].func,
  onLoadProgress: _propTypes["default"].func,
  onLoadSuccess: _propTypes["default"].func,
  onPassword: _propTypes["default"].func,
  onSourceError: _propTypes["default"].func,
  onSourceSuccess: _propTypes["default"].func,
  rotate: _propTypes["default"].number
});