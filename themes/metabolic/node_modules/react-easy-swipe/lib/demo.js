(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define(['react', 'react-dom', './react-swipe'], factory);
  } else if (typeof exports !== "undefined") {
    factory(require('react'), require('react-dom'), require('./react-swipe'));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.react, global.reactDom, global.reactSwipe);
    global.demo = mod.exports;
  }
})(this, function (_react, _reactDom, _reactSwipe) {
  'use strict';

  var _react2 = _interopRequireDefault(_react);

  var _reactDom2 = _interopRequireDefault(_reactDom);

  var _reactSwipe2 = _interopRequireDefault(_reactSwipe);

  function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
      default: obj
    };
  }

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  var _createClass = function () {
    function defineProperties(target, props) {
      for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ("value" in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
      }
    }

    return function (Constructor, protoProps, staticProps) {
      if (protoProps) defineProperties(Constructor.prototype, protoProps);
      if (staticProps) defineProperties(Constructor, staticProps);
      return Constructor;
    };
  }();

  function _possibleConstructorReturn(self, call) {
    if (!self) {
      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    }

    return call && (typeof call === "object" || typeof call === "function") ? call : self;
  }

  function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
      throw new TypeError("Super expression must either be null or a function, not " + typeof superClass);
    }

    subClass.prototype = Object.create(superClass && superClass.prototype, {
      constructor: {
        value: subClass,
        enumerable: false,
        writable: true,
        configurable: true
      }
    });
    if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
  }

  var MyComponent = function (_Component) {
    _inherits(MyComponent, _Component);

    function MyComponent() {
      _classCallCheck(this, MyComponent);

      return _possibleConstructorReturn(this, (MyComponent.__proto__ || Object.getPrototypeOf(MyComponent)).apply(this, arguments));
    }

    _createClass(MyComponent, [{
      key: 'onSwipeStart',
      value: function onSwipeStart(event) {
        console.log('Start swiping...', event);
      }
    }, {
      key: 'onSwipeMove',
      value: function onSwipeMove(position, event) {
        console.log('Moved ' + position.x + ' pixels horizontally', event);
        console.log('Moved ' + position.y + ' pixels vertically', event);
      }
    }, {
      key: 'onSwipeEnd',
      value: function onSwipeEnd(event) {
        console.log('End swiping...', event);
      }
    }, {
      key: 'render',
      value: function render() {
        var boxStyle = {
          width: '100%',
          margin: '20px auto',
          height: '300px',
          border: '1px solid black',
          background: '#ccc',
          padding: '20px',
          fontSize: '3em'
        };

        return _react2.default.createElement(
          _reactSwipe2.default,
          {
            onSwipeStart: this.onSwipeStart,
            onSwipeMove: this.onSwipeMove,
            onSwipeEnd: this.onSwipeEnd
          },
          _react2.default.createElement(
            'div',
            { style: boxStyle },
            'Open the console and swipe me'
          )
        );
      }
    }]);

    return MyComponent;
  }(_react.Component);

  _reactDom2.default.render(_react2.default.createElement(MyComponent, null), document.getElementById('root'));
});