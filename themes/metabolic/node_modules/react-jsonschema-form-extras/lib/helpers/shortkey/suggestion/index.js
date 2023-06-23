"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = require("react");

var _react2 = _interopRequireDefault(_react);

var _propTypes = require("prop-types");

var _propTypes2 = _interopRequireDefault(_propTypes);

var _classnames = require("classnames");

var _classnames2 = _interopRequireDefault(_classnames);

var _addMention = require("../addMention");

var _addMention2 = _interopRequireDefault(_addMention);

var _keyDown = require("../../event-handler/keyDown");

var _keyDown2 = _interopRequireDefault(_keyDown);

var _suggestions = require("../../event-handler/suggestions");

var _suggestions2 = _interopRequireDefault(_suggestions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Suggestion = function Suggestion(config) {
  _classCallCheck(this, Suggestion);

  _initialiseProps.call(this);

  var separator = config.separator,
      getTriggers = config.getTriggers,
      getSuggestions = config.getSuggestions,
      onChange = config.onChange,
      getEditorState = config.getEditorState,
      getWrapperRef = config.getWrapperRef,
      caseSensitive = config.caseSensitive,
      dropdownClassName = config.dropdownClassName,
      _config$optionClassNa = config.optionClassName,
      optionClassName = _config$optionClassNa === undefined ? "" : _config$optionClassNa,
      modalHandler = config.modalHandler,
      startingCharacter = config.startingCharacter,
      endingCharacter = config.endingCharacter,
      placeholderKeyPairs = config.placeholderKeyPairs;

  this.config = {
    separator: separator,
    getTriggers: getTriggers,
    getSuggestions: getSuggestions,
    onChange: onChange,
    getEditorState: getEditorState,
    getWrapperRef: getWrapperRef,
    caseSensitive: caseSensitive,
    dropdownClassName: dropdownClassName,
    optionClassName: optionClassName,
    modalHandler: modalHandler,
    startingCharacter: startingCharacter,
    endingCharacter: endingCharacter,
    placeholderKeyPairs: placeholderKeyPairs
  };
};

var _initialiseProps = function _initialiseProps() {
  var _this3 = this;

  this.findSuggestionEntities = function (contentBlock, callback) {
    if (_this3.config.getEditorState()) {
      var _config = _this3.config,
          separator = _config.separator,
          getTriggers = _config.getTriggers,
          getSuggestions = _config.getSuggestions,
          getEditorState = _config.getEditorState;

      var selection = getEditorState().getSelection();
      if (selection.get("anchorKey") === contentBlock.get("key") && selection.get("anchorKey") === selection.get("focusKey")) {
        var text = contentBlock.getText();
        text = text.substr(0, selection.get("focusOffset") === text.length - 1 ? text.length : selection.get("focusOffset") + 1);
        //Need to find the latest match with mutiple triggers, then pass that trigger along through.
        var index = -1;

        var currentTrigger = void 0;
        getTriggers().some(function (trigger) {
          currentTrigger = trigger;
          var internalIndex = text.lastIndexOf(separator + trigger);
          if (internalIndex >= 0 && text[internalIndex - 1] !== trigger) {
            index = internalIndex;
            return true;
          }
        });
        //let index = text.lastIndexOf(separator + trigger);
        var preText = separator + currentTrigger;
        if ((index === undefined || index < 0) && text[0] === currentTrigger) {
          index = 0;
          preText = currentTrigger;
        }
        if (index >= 0) {
          var mentionText = text.substr(index + preText.length, text.length);
          var suggestionPresent = getSuggestions().some(function (suggestion) {
            if (suggestion.phrase) {
              if (_this3.config.caseSensitive) {
                _this3.config.trigger = currentTrigger;
                return suggestion.phrase.indexOf(mentionText) >= 0;
              }
              _this3.config.trigger = currentTrigger;

              if (mentionText && mentionText.trim().length <= 0) {
                return false;
              }
              return suggestion.phrase.toLowerCase().indexOf(mentionText && mentionText.toLowerCase()) >= 0;
            }
            return false;
          });
          if (suggestionPresent) {
            callback(index === 0 ? 0 : index, text.length);
          }
        }
      }
    }
  };

  this.getSuggestionComponent = getSuggestionComponent.bind(this);

  this.getSuggestionDecorator = function () {
    return {
      strategy: _this3.findSuggestionEntities,
      component: _this3.getSuggestionComponent()
    };
  };
};

function getSuggestionComponent() {
  var _class, _temp2;

  var config = this.config;

  return _temp2 = _class = function (_Component) {
    _inherits(SuggestionComponent, _Component);

    function SuggestionComponent() {
      var _ref;

      var _temp, _this, _ret;

      _classCallCheck(this, SuggestionComponent);

      for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = SuggestionComponent.__proto__ || Object.getPrototypeOf(SuggestionComponent)).call.apply(_ref, [this].concat(args))), _this), _this.state = {
        style: { left: 15 },
        activeOption: 0,
        showSuggestions: true
      }, _this.onEditorKeyDown = function (event) {
        var activeOption = _this.state.activeOption;

        var newState = {};
        if (event.key === "ArrowDown") {
          event.preventDefault();
          if (activeOption === _this.filteredSuggestions.length - 1) {
            newState.activeOption = 0;
          } else {
            newState.activeOption = activeOption + 1;
          }
        } else if (event.key === "ArrowUp") {
          event.preventDefault();
          if (activeOption <= 0) {
            newState.activeOption = _this.filteredSuggestions.length - 1;
          } else {
            newState.activeOption = activeOption - 1;
          }
        } else if (event.key === "Escape") {
          newState.showSuggestions = false;
          _suggestions2.default.close();
          newState.activeOption = -1;
        } else if (event.key === "Enter") {
          if (_this.state.showSuggestions === true) {
            newState.showSuggestions = false;
            _this.addMention();
            newState.activeOption = -1;
          }
        }
        _this.setState(newState);
      }, _this.onOptionMouseEnter = function (event) {
        var index = event.target.getAttribute("data-index");
        _this.setState({
          activeOption: index
        });
      }, _this.onOptionMouseLeave = function () {
        _this.setState({
          activeOption: 0
        });
      }, _this.setSuggestionReference = function (ref) {
        _this.suggestion = ref;
      }, _this.setDropdownReference = function (ref) {
        _this.dropdown = ref;
      }, _this.closeSuggestionDropdown = function () {
        _this.setState({
          showSuggestions: false
        });
      }, _this.filteredSuggestions = [], _this.filterSuggestions = function (props) {
        var separator = config.separator;
        var shortkeyText = props.children[0].props.text.substr(separator.length + 1);
        var suggestions = config.getSuggestions();
        var trigger = config.trigger;
        _this.filteredSuggestions = suggestions && suggestions.filter(function (suggestion) {
          if (!shortkeyText || shortkeyText.length === 0) {
            if (trigger === suggestion.hotkey) {
              return true;
            }
          }
          if (config.caseSensitive) {
            return suggestion.phrase.indexOf(shortkeyText) >= 0;
          }

          if (trigger === suggestion.hotkey) {
            return suggestion.phrase.toLowerCase().indexOf(shortkeyText && shortkeyText.toLowerCase()) >= 0;
          }
        });
      }, _this.addMention = function () {
        var activeOption = _this.state.activeOption;

        var editorState = config.getEditorState();
        var onChange = config.onChange,
            separator = config.separator,
            trigger = config.trigger,
            startingCharacter = config.startingCharacter,
            endingCharacter = config.endingCharacter,
            placeholderKeyPairs = config.placeholderKeyPairs;

        var selectedMention = _this.filteredSuggestions[activeOption];
        if (selectedMention) {
          (0, _addMention2.default)(editorState, onChange, separator, trigger, selectedMention, startingCharacter, endingCharacter, placeholderKeyPairs);
        }
      }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(SuggestionComponent, [{
      key: "componentDidMount",
      value: function componentDidMount() {
        // originally this is gotten from the parent ref. Need to do more research on this.
        var wrapper = document.getElementById("rjfe-draft-rte-wrapper");
        var editorRect = wrapper.getBoundingClientRect();
        var suggestionRect = this.suggestion.getBoundingClientRect();
        var dropdownRect = this.dropdown.getBoundingClientRect();
        var left = void 0;
        var right = void 0;
        var bottom = void 0;
        if (editorRect.width < suggestionRect.left - editorRect.left + dropdownRect.width) {
          right = 15;
        } else {
          left = 15;
        }
        // if (editorRect.bottom < dropdownRect.bottom) {
        //   bottom = 0;
        // }
        this.setState({
          // eslint-disable-line react/no-did-mount-set-state
          style: { left: left, right: right, bottom: bottom }
        });
        _keyDown2.default.registerCallBack(this.onEditorKeyDown);
        _suggestions2.default.open();
        config.modalHandler.setSuggestionCallback(this.closeSuggestionDropdown);
        this.filterSuggestions(this.props);
      }
    }, {
      key: "componentWillReceiveProps",
      value: function componentWillReceiveProps(props) {
        if (this.props.children !== props.children) {
          this.filterSuggestions(props);
          this.setState({
            showSuggestions: true
          });
        }
      }
    }, {
      key: "componentWillUnmount",
      value: function componentWillUnmount() {
        _keyDown2.default.deregisterCallBack(this.onEditorKeyDown);
        _suggestions2.default.close();
        config.modalHandler.removeSuggestionCallback();
      }
    }, {
      key: "render",
      value: function render() {
        var _this2 = this;

        var children = this.props.children;
        var _state = this.state,
            activeOption = _state.activeOption,
            showSuggestions = _state.showSuggestions;
        var dropdownClassName = config.dropdownClassName,
            optionClassName = config.optionClassName;

        return _react2.default.createElement(
          "span",
          {
            className: "rdw-suggestion-wrapper",
            ref: this.setSuggestionReference,
            onClick: config.modalHandler.onSuggestionClick,
            "aria-haspopup": "true",
            "aria-label": "rdw-suggestion-popup",
            "data-offset-key": children[0] && children[0].key ? children[0].key : ""
          },
          children,
          showSuggestions && _react2.default.createElement(
            "span",
            {
              className: (0, _classnames2.default)("rdw-suggestion-dropdown", dropdownClassName),
              contentEditable: "false",
              suppressContentEditableWarning: true,
              style: this.state.style,
              ref: this.setDropdownReference,
              "data-offset-key": children[0] && children[0].key ? children[0].key : ""
            },
            this.filteredSuggestions.map(function (suggestion, index) {
              return _react2.default.createElement(
                "span",
                {
                  key: index,
                  spellCheck: false,
                  onClick: _this2.addMention,
                  "data-index": index,
                  onMouseEnter: _this2.onOptionMouseEnter,
                  onMouseLeave: _this2.onOptionMouseLeave,
                  className: (0, _classnames2.default)("rdw-suggestion-option", optionClassName, { "rdw-suggestion-option-active": index == activeOption })
                },
                suggestion.phrase,
                _react2.default.createElement("br", null),
                _react2.default.createElement("div", {
                  style: {
                    overflow: "hidden",
                    maxWidth: "30ch",
                    height: "18px",
                    fontSize: "12px"
                  },
                  dangerouslySetInnerHTML: { __html: suggestion.text }
                })
              );
            })
          )
        );
      }
    }]);

    return SuggestionComponent;
  }(_react.Component), _class.propTypes = {
    children: _propTypes2.default.array
  }, _temp2;
}

module.exports = Suggestion;