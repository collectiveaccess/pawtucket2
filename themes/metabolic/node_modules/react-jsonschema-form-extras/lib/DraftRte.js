"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

exports.mapFromObject = mapFromObject;
exports.mapFromSchema = mapFromSchema;
exports.optionToString = optionToString;
exports.mapLabelKey = mapLabelKey;

var _react = require("react");

var _react2 = _interopRequireDefault(_react);

var _draftJs = require("draft-js");

var _modifiedDraftRte = require("./modified-draft-rte");

var _modifiedDraftRte2 = _interopRequireDefault(_modifiedDraftRte);

var _draftjsToHtml = require("draftjs-to-html");

var _draftjsToHtml2 = _interopRequireDefault(_draftjsToHtml);

var _htmlToDraftjs = require("html-to-draftjs");

var _htmlToDraftjs2 = _interopRequireDefault(_htmlToDraftjs);

var _propTypes = require("prop-types");

var _propTypes2 = _interopRequireDefault(_propTypes);

var _Label = require("./Label");

var _keyDown = require("./helpers/event-handler/keyDown");

var _keyDown2 = _interopRequireDefault(_keyDown);

var _selectn = require("selectn");

var _selectn2 = _interopRequireDefault(_selectn);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var debounce = require("lodash.debounce");

function mapFromObject(data, mapping, defVal) {
  return Object.keys(mapping).reduce(function (agg, field) {
    var eventField = mapping[field];
    if ((typeof eventField === "undefined" ? "undefined" : _typeof(eventField)) === "object") {
      Object.assign(agg, mapFromObject(data[field], mapping, {}));
    } else {
      if (data[eventField]) {
        agg[field] = data[eventField];
      } else {
        agg[field] = eventField;
      }
    }
    return agg;
  }, defVal);
}
/**
 *
 * @param {*} data
 * @param {*} mapping
 * Mapped object is converted to the object mapping takes
 */
function mapFromSchema(data, mapping) {
  /* if (isEmpty(data)) {
    return;
  } */
  if (!mapping || mapping === null) {
    return data;
  } else if ((typeof mapping === "undefined" ? "undefined" : _typeof(mapping)) === mapping) {
    return _defineProperty({}, mapping, data);
  } else if ((typeof mapping === "undefined" ? "undefined" : _typeof(mapping)) === "object") {
    return mapFromObject(data, mapping, {});
  } else {
    return data;
  }
}

/**
 *
 * @param {*} data
 * @param {*} mapping
 * prepare the String to display
 */
function optionToString(fields, separator) {
  return function (option) {
    return fields.map(function (field) {
      return (0, _selectn2.default)(field, option);
    }).filter(function (fieldVal) {
      return fieldVal;
    }).reduce(function (agg, fieldVal, i) {
      if (i === 0) {
        return fieldVal;
      } else {
        if (Array.isArray(separator)) {
          return "" + agg + separator[i - 1] + fieldVal;
        }
        return "" + agg + separator + fieldVal;
      }
    }, "");
  };
}
/**
 *
 * @param {*} data
 * @param {*} mapping
 * maping the label
 */
function mapLabelKey(labelKey) {
  if (Array.isArray(labelKey)) {
    return this.optionToString(labelKey, " ");
  } else if ((typeof labelKey === "undefined" ? "undefined" : _typeof(labelKey)) === "object" && labelKey.fields && labelKey.separator) {
    var fields = labelKey.fields,
        separator = labelKey.separator;

    return optionToString(fields, separator);
  }
  return labelKey;
}

var DraftRTE = function (_Component) {
  _inherits(DraftRTE, _Component);

  /**
   *
   * @param {*} props
   * Currently only supports HTML
   */
  function DraftRTE(props) {
    _classCallCheck(this, DraftRTE);

    var _this = _possibleConstructorReturn(this, (DraftRTE.__proto__ || Object.getPrototypeOf(DraftRTE)).call(this, props));

    _initialiseProps.call(_this);

    var _props$formData = props.formData,
        formData = _props$formData === undefined ? "" : _props$formData,
        uiSchema = props.uiSchema;

    var autoFocus = uiSchema["ui:autofocus"] ? uiSchema["ui:autofocus"] : false;

    // Initializing the editor state (ref: https://jpuri.github.io/react-draft-wysiwyg/#/docs)
    var blocksFromHtml = (0, _htmlToDraftjs2.default)(formData);
    var contentBlocks = blocksFromHtml.contentBlocks,
        entityMap = blocksFromHtml.entityMap;

    var contentState = _draftJs.ContentState.createFromBlockArray(contentBlocks, entityMap);

    var editorState = null;

    if (autoFocus) {
      editorState = _draftJs.EditorState.moveFocusToEnd(_draftJs.EditorState.createWithContent(contentState));
    } else {
      editorState = _draftJs.EditorState.createWithContent(contentState);
    }

    _this.state = {
      editorState: editorState,
      suggestions: [],
      triggers: [],
      startingCharacter: props.startingCharacter,
      endingCharacter: props.endingCharacter,
      placeholderKeyPairs: props.placeholderKeyPairs
    };
    return _this;
  }
  /**
   * updates formData by calling parent's onChange function with current html content
   */


  /**
   * handles editor's onChange
   * handles logic to update form data based on props supplied to the component
   */
  //will only be executed if debounce is present

  /**
   * handles the logic to update formData on blur
   */


  /**
   * handles the logic to load the suggestions on the time of focus
   */


  _createClass(DraftRTE, [{
    key: "render",


    /**
     * react render function
     */
    value: function render() {
      var _this2 = this;

      var editorState = this.state.editorState;
      var _props = this.props,
          draftRte = _props.uiSchema.draftRte,
          _props$idSchema = _props.idSchema;
      _props$idSchema = _props$idSchema === undefined ? {} : _props$idSchema;
      var $id = _props$idSchema.$id;


      return _react2.default.createElement(
        "div",
        { id: $id, onKeyDown: _keyDown2.default.onKeyDown },
        _react2.default.createElement(_Label.DefaultLabel, this.props),
        _react2.default.createElement(
          "div",
          { id: "rjfe-draft-rte-wrapper" },
          _react2.default.createElement(_modifiedDraftRte2.default, _extends({
            wrapperClassName: "draftRte-wrapper",
            editorClassName: "draftRte-editor",
            editorState: editorState,
            onEditorStateChange: this.onEditorStateChange,
            onBlur: this.handleBlur,
            editorRef: this.setEditorReference,
            spellCheck: true,
            handlePastedText: function handlePastedText() {
              return false;
            },
            getEditorState: function getEditorState() {
              return _this2.state.editorState;
            },
            onFocus: this.handleOnFocus,
            customSuggestions: function customSuggestions() {
              return _this2.state.suggestions;
            },
            customSuggestionTriggers: function customSuggestionTriggers() {
              return _this2.state.triggers;
            },
            startingCharacter: this.state.startingCharacter,
            endingCharacter: this.state.endingCharacter,
            placeholderKeyPairs: this.state.placeholderKeyPairs
          }, draftRte))
        )
      );
    }
  }]);

  return DraftRTE;
}(_react.Component);

var _initialiseProps = function _initialiseProps() {
  var _this3 = this;

  this.updateFormData = function () {
    var onChange = _this3.props.onChange;
    var editorState = _this3.state.editorState; //eslint-disable-line

    if (onChange) {
      onChange((0, _draftjsToHtml2.default)((0, _draftJs.convertToRaw)(_this3.state.editorState.getCurrentContent())));
    }
  };

  this.onEditorStateChange = function (editorState) {
    var _props$uiSchema = _this3.props.uiSchema,
        _props$uiSchema$updat = _props$uiSchema.updateOnBlur,
        updateOnBlur = _props$uiSchema$updat === undefined ? false : _props$uiSchema$updat,
        _props$uiSchema$draft = _props$uiSchema.draftRte;
    _props$uiSchema$draft = _props$uiSchema$draft === undefined ? {} : _props$uiSchema$draft;
    var _props$uiSchema$draft2 = _props$uiSchema$draft.debounce;
    _props$uiSchema$draft2 = _props$uiSchema$draft2 === undefined ? {} : _props$uiSchema$draft2;
    var interval = _props$uiSchema$draft2.interval,
        _props$uiSchema$draft3 = _props$uiSchema$draft2.shouldDebounce,
        shouldDebounce = _props$uiSchema$draft3 === undefined ? false : _props$uiSchema$draft3;

    _this3.setState({ editorState: editorState }, function () {
      !updateOnBlur && !shouldDebounce && _this3.updateFormData();
      if (shouldDebounce && interval) {
        _this3.handleDebounce();
      }
    });
  };

  this.handleDebounce = this.props.uiSchema.draftRte ? this.props.uiSchema.draftRte.debounce ? debounce(this.updateFormData, this.props.uiSchema.draftRte.debounce.interval) : function () {} : function () {};

  this.handleBlur = function () {
    var _props$uiSchema$updat2 = _this3.props.uiSchema.updateOnBlur,
        updateOnBlur = _props$uiSchema$updat2 === undefined ? false : _props$uiSchema$updat2;

    if (updateOnBlur) {
      _this3.updateFormData();
    }
  };

  this.setEditorReference = function (ref) {
    var autoFocus = _this3.props.uiSchema["ui:autofocus"] ? _this3.props.uiSchema["ui:autofocus"] : false;
    ref && autoFocus && ref.focus();
  };

  this.handleOnFocus = function () {
    var _state$suggestions = _this3.state.suggestions,
        suggestions = _state$suggestions === undefined ? [] : _state$suggestions;
    var _props$uiSchema$draft4 = _this3.props.uiSchema.draftRte,
        _props$uiSchema$draft5 = _props$uiSchema$draft4.enableAutocomplete,
        enableAutocomplete = _props$uiSchema$draft5 === undefined ? false : _props$uiSchema$draft5,
        _props$uiSchema$draft6 = _props$uiSchema$draft4.autocomplete,
        autocomplete = _props$uiSchema$draft6 === undefined ? {} : _props$uiSchema$draft6;

    if (!enableAutocomplete) {
      return false;
    }
    if (suggestions.length <= 0) {
      var url = autocomplete.url,
          shortKeysPath = autocomplete.shortKeysPath,
          keyToDisplay = autocomplete.keyToDisplay,
          keyToMaping = autocomplete.keyToMaping,
          _autocomplete$loadSug = autocomplete.loadSuggestions,
          loadSuggestions = _autocomplete$loadSug === undefined ? function (url) {
        return fetch("" + url).then(function (res) {
          return res.json();
        });
      } : _autocomplete$loadSug;


      loadSuggestions(url).then(function (json) {
        return shortKeysPath !== "" ? (0, _selectn2.default)(shortKeysPath, json) : json;
      }).then(function (suggestions) {
        var dynamicSuggestions = []; //
        var dynamicShortkeys = [];
        if (suggestions.length > 0) {
          suggestions.map(function (item) {
            //Dynamically set theSuggestion Triggers
            //deciding the field name to display on the RTE field
            var labelKey = mapLabelKey(keyToDisplay);
            labelKey = typeof labelKey === "function" ? labelKey(item) : item[labelKey];
            //Mapping the needed values with API data
            var mapping = mapFromSchema(item, keyToMaping);
            //collecting the Triigers from the API data
            if (dynamicShortkeys.indexOf(mapping.hotkey) == -1) {
              dynamicShortkeys.push(mapping.hotkey);
            }
            //Consolidating the suggestion
            dynamicSuggestions.push(Object.assign({}, mapping, { text: labelKey }));
          });
        }
        _this3.setState({
          suggestions: dynamicSuggestions,
          triggers: dynamicShortkeys
        });
      });
    }
  };
};

exports.default = DraftRTE;


DraftRTE.propTypes = {
  uiSchema: _propTypes2.default.shape({
    updateOnBlur: _propTypes2.default.bool,
    draftRte: _propTypes2.default.object
  })
};