"use strict";

var _react = require("react");

var _react2 = _interopRequireDefault(_react);

var _propTypes = require("prop-types");

var _propTypes2 = _interopRequireDefault(_propTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Shortkey = function Shortkey(className) {
  var _this = this;

  _classCallCheck(this, Shortkey);

  this.getShortkeyComponent = function () {
    var ShortkeyComponent = function ShortkeyComponent(_ref) {
      var entityKey = _ref.entityKey,
          children = _ref.children,
          contentState = _ref.contentState;

      // const { text } = contentState.getEntity(entityKey).getData();
      return _react2.default.createElement(
        "span",
        null,
        children
      );
    };
    ShortkeyComponent.propTypes = {
      entityKey: _propTypes2.default.number,
      children: _propTypes2.default.array,
      contentState: _propTypes2.default.object
    };
    return ShortkeyComponent;
  };

  this.getShortkeyDecorator = function () {
    return {
      strategy: _this.findShortkeyEntities,
      component: _this.getShortkeyComponent()
    };
  };

  this.className = className;
};

Shortkey.prototype.findShortkeyEntities = function (contentBlock, callback, contentState) {
  contentBlock.findEntityRanges(function (character) {
    var entityKey = character.getEntity();
    return entityKey !== null && contentState.getEntity(entityKey).getType() === "SHORTKEY";
  }, callback);
};

module.exports = Shortkey;