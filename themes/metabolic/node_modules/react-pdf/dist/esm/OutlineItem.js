import _extends from "@babel/runtime/helpers/esm/extends";
import _objectWithoutProperties from "@babel/runtime/helpers/esm/objectWithoutProperties";
import _slicedToArray from "@babel/runtime/helpers/esm/slicedToArray";
import _regeneratorRuntime from "@babel/runtime/regenerator";
import _asyncToGenerator from "@babel/runtime/helpers/esm/asyncToGenerator";
import _classCallCheck from "@babel/runtime/helpers/esm/classCallCheck";
import _createClass from "@babel/runtime/helpers/esm/createClass";
import _assertThisInitialized from "@babel/runtime/helpers/esm/assertThisInitialized";
import _inherits from "@babel/runtime/helpers/esm/inherits";
import _possibleConstructorReturn from "@babel/runtime/helpers/esm/possibleConstructorReturn";
import _getPrototypeOf from "@babel/runtime/helpers/esm/getPrototypeOf";
import _defineProperty from "@babel/runtime/helpers/esm/defineProperty";

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import DocumentContext from './DocumentContext';
import OutlineContext from './OutlineContext';
import Ref from './Ref';
import { isDefined } from './shared/utils';
import { isPdf } from './shared/propTypes';
export var OutlineItemInternal = /*#__PURE__*/function (_PureComponent) {
  _inherits(OutlineItemInternal, _PureComponent);

  var _super = _createSuper(OutlineItemInternal);

  function OutlineItemInternal() {
    var _this;

    _classCallCheck(this, OutlineItemInternal);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));

    _defineProperty(_assertThisInitialized(_this), "getDestination", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime.mark(function _callee() {
      var _this$props, item, pdf;

      return _regeneratorRuntime.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this$props = _this.props, item = _this$props.item, pdf = _this$props.pdf;

              if (isDefined(_this.destination)) {
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

    _defineProperty(_assertThisInitialized(_this), "getPageIndex", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime.mark(function _callee2() {
      var pdf, destination, _destination, ref;

      return _regeneratorRuntime.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              pdf = _this.props.pdf;

              if (isDefined(_this.pageIndex)) {
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

              _destination = _slicedToArray(destination, 1), ref = _destination[0];
              _context2.next = 9;
              return pdf.getPageIndex(new Ref(ref));

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

    _defineProperty(_assertThisInitialized(_this), "getPageNumber", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime.mark(function _callee3() {
      return _regeneratorRuntime.wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              if (isDefined(_this.pageNumber)) {
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

    _defineProperty(_assertThisInitialized(_this), "onClick", /*#__PURE__*/function () {
      var _ref4 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime.mark(function _callee4(event) {
        var onClick, pageIndex, pageNumber;
        return _regeneratorRuntime.wrap(function _callee4$(_context4) {
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

  _createClass(OutlineItemInternal, [{
    key: "renderSubitems",
    value: function renderSubitems() {
      var _this$props2 = this.props,
          item = _this$props2.item,
          otherProps = _objectWithoutProperties(_this$props2, ["item"]);

      if (!item.items || !item.items.length) {
        return null;
      }

      var subitems = item.items;
      return /*#__PURE__*/React.createElement("ul", null, subitems.map(function (subitem, subitemIndex) {
        return /*#__PURE__*/React.createElement(OutlineItemInternal, _extends({
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

      return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
        href: "#",
        onClick: this.onClick
      }, item.title), this.renderSubitems());
    }
  }]);

  return OutlineItemInternal;
}(PureComponent);
var isDestination = PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.any)]);
OutlineItemInternal.propTypes = {
  item: PropTypes.shape({
    dest: isDestination,
    items: PropTypes.arrayOf(PropTypes.shape({
      dest: isDestination,
      title: PropTypes.string
    })),
    title: PropTypes.string
  }).isRequired,
  onClick: PropTypes.func,
  pdf: isPdf.isRequired
};

var OutlineItem = function OutlineItem(props) {
  return /*#__PURE__*/React.createElement(DocumentContext.Consumer, null, function (documentContext) {
    return /*#__PURE__*/React.createElement(OutlineContext.Consumer, null, function (outlineContext) {
      return /*#__PURE__*/React.createElement(OutlineItemInternal, _extends({}, documentContext, outlineContext, props));
    });
  });
};

export default OutlineItem;