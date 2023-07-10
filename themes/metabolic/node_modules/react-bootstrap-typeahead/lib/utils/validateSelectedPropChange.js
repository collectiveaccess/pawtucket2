"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = validateSelectedPropChange;

var _warn = _interopRequireDefault(require("./warn"));

function validateSelectedPropChange(prevSelected, selected) {
  var uncontrolledToControlled = !prevSelected && selected;
  var controlledToUncontrolled = prevSelected && !selected;
  var from, to, precedent;

  if (uncontrolledToControlled) {
    from = 'uncontrolled';
    to = 'controlled';
    precedent = 'an';
  } else {
    from = 'controlled';
    to = 'uncontrolled';
    precedent = 'a';
  }

  var message = "You are changing ".concat(precedent, " ").concat(from, " typeahead to be ").concat(to, ". ") + "Input elements should not switch from ".concat(from, " to ").concat(to, " (or vice versa). ") + 'Decide between using a controlled or uncontrolled element for the ' + 'lifetime of the component.';
  (0, _warn["default"])(!(uncontrolledToControlled || controlledToUncontrolled), message);
}