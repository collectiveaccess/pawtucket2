"use strict";

var _interopRequireWildcard = require("@babel/runtime/helpers/interopRequireWildcard");

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = exports.OutlineItemInternal = void 0;

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _slicedToArray2 = _interopRequireDefault(require("@babel/runtime/helpers/slicedToArray"));

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

var _DocumentContext = _interopRequireDefault(require("./DocumentContext"));

var _OutlineContext = _interopRequireDefault(require("./OutlineContext"));

var _Ref = _interopRequireDefault(require("./Ref"));

var _utils = require("./shared/utils");

var _propTypes2 = require("./shared/propTypes");

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = (0, _getPrototypeOf2["default"])(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = (0, _getPrototypeOf2["default"])(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return (0, _possibleConstructorReturn2["default"])(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

var OutlineItemInternal = /*#__PURE__*/function (_PureComponent) {
  (0, _inherits2["default"])(OutlineItemInternal, _PureComponent);

  var _super = _createSuper(OutlineItemInternal);

  function OutlineItemInternal() {
    var _this;

    (0, _classCallCheck2["default"])(this, OutlineItemInternal);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "getDestination", /*#__PURE__*/(0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee() {
      var _this$props, item, pdf;

      return _regenerator["default"].wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this$props = _this.props, item = _this$props.item, pdf = _this$props.pdf;

              if ((0, _utils.isDefined)(_this.destination)) {
                _context.next = 9;
                break;
              }

              if (!(typeof item.dest === 'string')) {
                _context.next = 8;
                break;
              }

              _context.next = 5;
              return pdf.getDestination(item.dest);

            case 5:
              _this.destination = _context.sent;
              _context.next = 9;
              break;

            case 8:
              _this.destination = item.dest;

            case 9:
              return _context.abrupt("return", _this.destination);

            case 10:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    })));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "getPageIndex", /*#__PURE__*/(0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee2() {
      var pdf, destination, _destination, ref;

      return _regenerator["default"].wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              pdf = _this.props.pdf;

              if ((0, _utils.isDefined)(_this.pageIndex)) {
                _context2.next = 10;
                break;
              }

              _context2.next = 4;
              return _this.getDestination();

            case 4:
              destination = _context2.sent;

              if (!destination) {
                _context2.next = 10;
                break;
              }

              _destination = (0, _slicedToArray2["default"])(destination, 1), ref = _destination[0];
              _context2.next = 9;
              return pdf.getPageIndex(new _Ref["default"](ref));

            case 9:
              _this.pageIndex = _context2.sent;

            case 10:
              return _context2.abrupt("return", _this.pageIndex);

            case 11:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    })));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "getPageNumber", /*#__PURE__*/(0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee3() {
      return _regenerator["default"].wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              if ((0, _utils.isDefined)(_this.pageNumber)) {
                _context3.next = 5;
                break;
              }

              _context3.next = 3;
              return _this.getPageIndex();

            case 3:
              _context3.t0 = _context3.sent;
              _this.pageNumber = _context3.t0 + 1;

            case 5:
              return _context3.abrupt("return", _this.pageNumber);

            case 6:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3);
    })));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "onClick", /*#__PURE__*/function () {
      var _ref4 = (0, _asyncToGenerator2["default"])( /*#__PURE__*/_regenerator["default"].mark(function _callee4(event) {
        var onClick, pageIndex, pageNumber;
        return _regenerator["default"].wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                onClick = _this.props.onClick;
                event.preventDefault();
                _context4.next = 4;
                return _this.getPageIndex();

              case 4:
                pageIndex = _context4.sent;
                _context4.next = 7;
                return _this.getPageNumber();

              case 7:
                pageNumber = _context4.sent;

                if (onClick) {
                  onClick({
                    pageIndex: pageIndex,
                    pageNumber: pageNumber
                  });
                }

              case 9:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }));

      return function (_x) {
        return _ref4.apply(this, arguments);
      };
    }());
    return _this;
  }

  (0, _createClass2["default"])(OutlineItemInternal, [{
    key: "renderSubitems",
    value: function renderSubitems() {
      var _this$props2 = this.props,
          item = _this$props2.item,
          otherProps = (0, _objectWithoutProperties2["default"])(_this$props2, ["item"]);

      if (!item.items || !item.items.length) {
        return null;
      }

      var subitems = item.items;
      return /*#__PURE__*/_react["default"].createElement("ul", null, subitems.map(function (subitem, subitemIndex) {
        return /*#__PURE__*/_react["default"].createElement(OutlineItemInternal, (0, _extends2["default"])({
          key: typeof subitem.destination === 'string' ? subitem.destination : subitemIndex,
          item: subitem
        }, otherProps));
      }));
    }
  }, {
    key: "render",
    value: function render() {
      var item = this.props.item;
      /* eslint-disable jsx-a11y/anchor-is-valid */

      return /*#__PURE__*/_react["default"].createElement("li", null, /*#__PURE__*/_react["default"].createElement("a", {
        href: "#",
        onClick: this.onClick
      }, item.title), this.renderSubitems());
    }
  }]);
  return OutlineItemInternal;
}(_react.PureComponent);

exports.OutlineItemInternal = OutlineItemInternal;

var isDestination = _propTypes["default"].oneOfType([_propTypes["default"].string, _propTypes["default"].arrayOf(_propTypes["default"].any)]);

OutlineItemInternal.propTypes = {
  item: _propTypes["default"].shape({
    dest: isDestination,
    items: _propTypes["default"].arrayOf(_propTypes["default"].shape({
      dest: isDestination,
      title: _propTypes["default"].string
    })),
    title: _propTypes["default"].string
  }).isRequired,
  onClick: _propTypes["default"].func,
  pdf: _propTypes2.isPdf.isRequired
};

var OutlineItem = function OutlineItem(props) {
  return /*#__PURE__*/_react["default"].createElement(_DocumentContext["default"].Consumer, null, function (documentContext) {
    return /*#__PURE__*/_react["default"].createElement(_OutlineContext["default"].Consumer, null, function (outlineContext) {
      return /*#__PURE__*/_react["default"].createElement(OutlineItemInternal, (0, _extends2["default"])({}, documentContext, outlineContext, props));
    });
  });
};

var _default = OutlineItem;
exports["default"] = _default;