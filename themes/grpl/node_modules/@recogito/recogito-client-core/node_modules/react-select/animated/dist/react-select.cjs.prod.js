"use strict";

Object.defineProperty(exports, "__esModule", {
  value: !0
});

var index$1 = require("../../dist/index-ea9e225d.cjs.prod.js"), _objectWithoutProperties = require("@babel/runtime/helpers/objectWithoutProperties"), memoizeOne = require("memoize-one"), _typeof = require("@babel/runtime/helpers/typeof"), React = require("react"), _extends = require("@babel/runtime/helpers/extends"), _classCallCheck = require("@babel/runtime/helpers/classCallCheck"), _createClass = require("@babel/runtime/helpers/createClass"), _inherits = require("@babel/runtime/helpers/inherits"), reactTransitionGroup = require("react-transition-group");

function _interopDefault(e) {
  return e && e.__esModule ? e : {
    default: e
  };
}

require("@emotion/react"), require("@babel/runtime/helpers/taggedTemplateLiteral"), 
require("react-input-autosize"), require("@babel/runtime/helpers/defineProperty"), 
require("react-dom");

var _objectWithoutProperties__default = _interopDefault(_objectWithoutProperties), memoizeOne__default = _interopDefault(memoizeOne), _typeof__default = _interopDefault(_typeof), React__default = _interopDefault(React), _extends__default = _interopDefault(_extends), _classCallCheck__default = _interopDefault(_classCallCheck), _createClass__default = _interopDefault(_createClass), _inherits__default = _interopDefault(_inherits), isArray = Array.isArray, keyList = Object.keys, hasProp = Object.prototype.hasOwnProperty;

function equal(a, b) {
  if (a === b) return !0;
  if (a && b && "object" == _typeof__default.default(a) && "object" == _typeof__default.default(b)) {
    var i, length, key, arrA = isArray(a), arrB = isArray(b);
    if (arrA && arrB) {
      if ((length = a.length) != b.length) return !1;
      for (i = length; 0 != i--; ) if (!equal(a[i], b[i])) return !1;
      return !0;
    }
    if (arrA != arrB) return !1;
    var dateA = a instanceof Date, dateB = b instanceof Date;
    if (dateA != dateB) return !1;
    if (dateA && dateB) return a.getTime() == b.getTime();
    var regexpA = a instanceof RegExp, regexpB = b instanceof RegExp;
    if (regexpA != regexpB) return !1;
    if (regexpA && regexpB) return a.toString() == b.toString();
    var keys = keyList(a);
    if ((length = keys.length) !== keyList(b).length) return !1;
    for (i = length; 0 != i--; ) if (!hasProp.call(b, keys[i])) return !1;
    for (i = length; 0 != i--; ) if (!("_owner" === (key = keys[i]) && a.$$typeof || equal(a[key], b[key]))) return !1;
    return !0;
  }
  return a != a && b != b;
}

function exportedEqual(a, b) {
  try {
    return equal(a, b);
  } catch (error) {
    if (error.message && error.message.match(/stack|recursion/i)) return console.warn("Warning: react-fast-compare does not handle circular references.", error.name, error.message), 
    !1;
    throw error;
  }
}

var AnimatedInput = function(WrappedComponent) {
  return function(_ref) {
    _ref.in, _ref.onExited, _ref.appear, _ref.enter, _ref.exit;
    var props = _objectWithoutProperties__default.default(_ref, [ "in", "onExited", "appear", "enter", "exit" ]);
    return React__default.default.createElement(WrappedComponent, props);
  };
}, Fade = function(_ref) {
  var Tag = _ref.component, _ref$duration = _ref.duration, duration = void 0 === _ref$duration ? 1 : _ref$duration, inProp = _ref.in;
  _ref.onExited;
  var props = _objectWithoutProperties__default.default(_ref, [ "component", "duration", "in", "onExited" ]), transition = {
    entering: {
      opacity: 0
    },
    entered: {
      opacity: 1,
      transition: "opacity ".concat(duration, "ms")
    },
    exiting: {
      opacity: 0
    },
    exited: {
      opacity: 0
    }
  };
  return React__default.default.createElement(reactTransitionGroup.Transition, {
    mountOnEnter: !0,
    unmountOnExit: !0,
    in: inProp,
    timeout: duration
  }, (function(state) {
    var innerProps = {
      style: index$1._objectSpread2({}, transition[state])
    };
    return React__default.default.createElement(Tag, _extends__default.default({
      innerProps: innerProps
    }, props));
  }));
}, collapseDuration = 260, Collapse = function(_Component) {
  _inherits__default.default(Collapse, _Component);
  var _super = index$1._createSuper(Collapse);
  function Collapse() {
    var _this;
    _classCallCheck__default.default(this, Collapse);
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) args[_key] = arguments[_key];
    return (_this = _super.call.apply(_super, [ this ].concat(args))).duration = collapseDuration, 
    _this.rafID = void 0, _this.state = {
      width: "auto"
    }, _this.transition = {
      exiting: {
        width: 0,
        transition: "width ".concat(_this.duration, "ms ease-out")
      },
      exited: {
        width: 0
      }
    }, _this.getWidth = function(ref) {
      ref && isNaN(_this.state.width) && (_this.rafID = window.requestAnimationFrame((function() {
        var width = ref.getBoundingClientRect().width;
        _this.setState({
          width: width
        });
      })));
    }, _this.getStyle = function(width) {
      return {
        overflow: "hidden",
        whiteSpace: "nowrap",
        width: width
      };
    }, _this.getTransition = function(state) {
      return _this.transition[state];
    }, _this;
  }
  return _createClass__default.default(Collapse, [ {
    key: "componentWillUnmount",
    value: function() {
      this.rafID && window.cancelAnimationFrame(this.rafID);
    }
  }, {
    key: "render",
    value: function() {
      var _this2 = this, _this$props = this.props, children = _this$props.children, inProp = _this$props.in, width = this.state.width;
      return React__default.default.createElement(reactTransitionGroup.Transition, {
        enter: !1,
        mountOnEnter: !0,
        unmountOnExit: !0,
        in: inProp,
        timeout: this.duration
      }, (function(state) {
        var style = index$1._objectSpread2(index$1._objectSpread2({}, _this2.getStyle(width)), _this2.getTransition(state));
        return React__default.default.createElement("div", {
          ref: _this2.getWidth,
          style: style
        }, children);
      }));
    }
  } ]), Collapse;
}(React.Component), AnimatedMultiValue = function(WrappedComponent) {
  return function(_ref) {
    var inProp = _ref.in, onExited = _ref.onExited, props = _objectWithoutProperties__default.default(_ref, [ "in", "onExited" ]);
    return React__default.default.createElement(Collapse, {
      in: inProp,
      onExited: onExited
    }, React__default.default.createElement(WrappedComponent, _extends__default.default({
      cropWithEllipsis: inProp
    }, props)));
  };
}, AnimatedPlaceholder = function(WrappedComponent) {
  return function(props) {
    return React__default.default.createElement(Fade, _extends__default.default({
      component: WrappedComponent,
      duration: props.isMulti ? collapseDuration : 1
    }, props));
  };
}, AnimatedSingleValue = function(WrappedComponent) {
  return function(props) {
    return React__default.default.createElement(Fade, _extends__default.default({
      component: WrappedComponent
    }, props));
  };
}, AnimatedValueContainer = function(WrappedComponent) {
  return function(props) {
    return React__default.default.createElement(reactTransitionGroup.TransitionGroup, _extends__default.default({
      component: WrappedComponent
    }, props));
  };
}, makeAnimated = function() {
  var externalComponents = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}, components = index$1.defaultComponents({
    components: externalComponents
  }), Input = components.Input, MultiValue = components.MultiValue, Placeholder = components.Placeholder, SingleValue = components.SingleValue, ValueContainer = components.ValueContainer, rest = _objectWithoutProperties__default.default(components, [ "Input", "MultiValue", "Placeholder", "SingleValue", "ValueContainer" ]);
  return index$1._objectSpread2({
    Input: AnimatedInput(Input),
    MultiValue: AnimatedMultiValue(MultiValue),
    Placeholder: AnimatedPlaceholder(Placeholder),
    SingleValue: AnimatedSingleValue(SingleValue),
    ValueContainer: AnimatedValueContainer(ValueContainer)
  }, rest);
}, AnimatedComponents = makeAnimated(), Input = AnimatedComponents.Input, MultiValue = AnimatedComponents.MultiValue, Placeholder = AnimatedComponents.Placeholder, SingleValue = AnimatedComponents.SingleValue, ValueContainer = AnimatedComponents.ValueContainer, index = memoizeOne__default.default(makeAnimated, exportedEqual);

exports.Input = Input, exports.MultiValue = MultiValue, exports.Placeholder = Placeholder, 
exports.SingleValue = SingleValue, exports.ValueContainer = ValueContainer, exports.default = index;
