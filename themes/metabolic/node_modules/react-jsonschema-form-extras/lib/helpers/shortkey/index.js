"use strict";

var _suggestion = require("./suggestion");

var _suggestion2 = _interopRequireDefault(_suggestion);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var getDecorators = function getDecorators(config) {
  return [
  // new Shortkey(config.mentionClassName).getShortkeyDecorator(),
  new _suggestion2.default(config).getSuggestionDecorator()];
}; // import Shortkey from "./shortkey";


module.exports = getDecorators;