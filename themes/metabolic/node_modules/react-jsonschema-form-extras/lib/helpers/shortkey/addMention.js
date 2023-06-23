"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = addMention;

var _draftJs = require("draft-js");

var _draftjsUtils = require("draftjs-utils");

var _htmlToDraftjs = require("html-to-draftjs");

var _htmlToDraftjs2 = _interopRequireDefault(_htmlToDraftjs);

var _immutable = require("immutable");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function addMention(editorState, onChange, separator, trigger, suggestion, startingCharacter, endingCharacter) {
  var placeholderKeyPairs = arguments.length > 7 && arguments[7] !== undefined ? arguments[7] : [];
  var text = suggestion.text;
  // Before we start our manipulation to insert this into the editor, lets process our placeholder replacements first.

  var availableReplacements = true;
  var searchStartingIndex = 0;

  var _loop = function _loop() {
    var startIndex = 0;
    var endIndex = 0;
    startIndex = text.indexOf(startingCharacter, searchStartingIndex);
    // If we don't even find a starting character, we can just return now.
    if (startIndex === -1) {
      availableReplacements = false;
    }
    endIndex = text.indexOf(endingCharacter, searchStartingIndex);
    // If we don't find an ending character, just return
    if (endIndex === -1) {
      availableReplacements = false;
    }
    // Lets make sure that our endingCharacter is not located before the starting one.
    if (endIndex < startIndex) {
      // If we do find an end character, it could be possible that there is still another valid replacement afterwards.
      // Need to implement logic here to check for that, adjust index to search past inital ending bracket.
      searchStartingIndex = endIndex;
    }

    var textToMatch = text.slice(startIndex + 1, endIndex);
    var fullText = text.slice(startIndex, endIndex + 1);
    //Now that we have the text in our match, lets see if there is a pair for it.
    var matchedReplacement = null;
    placeholderKeyPairs.some(function (pair) {
      if (pair.match === textToMatch) {
        // match found, return this pair.
        matchedReplacement = pair;
        return true;
      }
    });

    // Let's replace it, and then repeat until we don't find any more matches to replace.
    if (matchedReplacement && matchedReplacement !== undefined && matchedReplacement !== null) {
      text = text.replace(fullText, matchedReplacement.replacement);
    } else {
      availableReplacements = false;
    }
  };

  while (availableReplacements) {
    _loop();
  }

  var selectedBlock = (0, _draftjsUtils.getSelectedBlock)(editorState);
  var selectedBlockText = selectedBlock.getText();
  var focusOffset = editorState.getSelection().focusOffset;
  var mentionIndex = selectedBlockText.lastIndexOf(separator + trigger, focusOffset) || 0;
  var spaceAlreadyPresent = false;
  if (selectedBlockText.length === mentionIndex + 1) {
    focusOffset = selectedBlockText.length;
  }
  if (selectedBlockText[focusOffset] === " ") {
    spaceAlreadyPresent = true;
  }
  var updatedSelection = editorState.getSelection().merge({
    anchorOffset: mentionIndex + separator.length,
    focusOffset: focusOffset + separator.length
  });

  var newEditorState = _draftJs.EditorState.acceptSelection(editorState, updatedSelection);
  var contentState = {};
  var contentBlock = (0, _htmlToDraftjs2.default)(text);
  if (suggestion.advanced) {
    contentState = editorState.getCurrentContent();
    contentBlock.entityMap.forEach(function (value, key) {
      contentState = contentState.mergeEntityData(key, value);
    });
    contentState = _draftJs.Modifier.replaceWithFragment(contentState, updatedSelection, new _immutable.List(contentBlock.contentBlocks));
  } else {

    contentState = _draftJs.Modifier.replaceText(newEditorState.getCurrentContent(), updatedSelection, "" + text, newEditorState.getCurrentInlineStyle(), undefined);
  }

  newEditorState = _draftJs.EditorState.push(newEditorState, contentState, "insert-characters");

  if (!spaceAlreadyPresent) {
    // insert a blank space after mention
    if (suggestion.advanced) {
      updatedSelection = newEditorState.getSelection().merge({
        anchorOffset: mentionIndex + contentBlock.contentBlocks[0].text.length + separator.length,
        focusOffset: mentionIndex + contentBlock.contentBlocks[0].text.length + separator.length
      });
    } else {
      updatedSelection = newEditorState.getSelection().merge({
        anchorOffset: mentionIndex + text.length + separator.length,
        focusOffset: mentionIndex + text.length + separator.length
      });
    }
    newEditorState = _draftJs.EditorState.acceptSelection(newEditorState, updatedSelection);
    contentState = _draftJs.Modifier.insertText(newEditorState.getCurrentContent(), updatedSelection, " ", newEditorState.getCurrentInlineStyle(), undefined);
  }
  onChange(_draftJs.EditorState.push(newEditorState, contentState, "insert-characters"));
}