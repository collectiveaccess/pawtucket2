import _extends from "@babel/runtime/helpers/esm/extends";
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
import mergeRefs from 'merge-refs';
import PageContext from '../PageContext';
import { errorOnDev, getPixelRatio, isCancelException, makePageCallback } from '../shared/utils';
import { isPage, isRef, isRotate } from '../shared/propTypes';
export var PageCanvasInternal = /*#__PURE__*/function (_PureComponent) {
  _inherits(PageCanvasInternal, _PureComponent);

  var _super = _createSuper(PageCanvasInternal);

  function PageCanvasInternal() {
    var _this;

    _classCallCheck(this, PageCanvasInternal);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));

    _defineProperty(_assertThisInitialized(_this), "onRenderSuccess", function () {
      _this.renderer = null;
      var _this$props = _this.props,
          onRenderSuccess = _this$props.onRenderSuccess,
          page = _this$props.page,
          scale = _this$props.scale;
      if (onRenderSuccess) onRenderSuccess(makePageCallback(page, scale));
    });

    _defineProperty(_assertThisInitialized(_this), "onRenderError", function (error) {
      if (isCancelException(error)) {
        return;
      }

      errorOnDev(error);
      var onRenderError = _this.props.onRenderError;
      if (onRenderError) onRenderError(error);
    });

    _defineProperty(_assertThisInitialized(_this), "drawPageOnCanvas", function () {
      var _assertThisInitialize = _assertThisInitialized(_this),
          canvas = _assertThisInitialize.canvasLayer;

      if (!canvas) {
        return null;
      }

      var _assertThisInitialize2 = _assertThisInitialized(_this),
          renderViewport = _assertThisInitialize2.renderViewport,
          viewport = _assertThisInitialize2.viewport;

      var _this$props2 = _this.props,
          page = _this$props2.page,
          renderInteractiveForms = _this$props2.renderInteractiveForms;
      canvas.width = renderViewport.width;
      canvas.height = renderViewport.height;
      canvas.style.width = "".concat(Math.floor(viewport.width), "px");
      canvas.style.height = "".concat(Math.floor(viewport.height), "px");
      var renderContext = {
        get canvasContext() {
          return canvas.getContext('2d');
        },

        viewport: renderViewport,
        renderInteractiveForms: renderInteractiveForms
      }; // If another render is in progress, let's cancel it

      _this.cancelRenderingTask();

      _this.renderer = page.render(renderContext);
      return _this.renderer.promise.then(_this.onRenderSuccess)["catch"](_this.onRenderError);
    });

    return _this;
  }

  _createClass(PageCanvasInternal, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      this.drawPageOnCanvas();
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate(prevProps) {
      var _this$props3 = this.props,
          page = _this$props3.page,
          renderInteractiveForms = _this$props3.renderInteractiveForms;

      if (renderInteractiveForms !== prevProps.renderInteractiveForms) {
        // Ensures the canvas will be re-rendered from scratch. Otherwise all form data will stay.
        page.cleanup();
        this.drawPageOnCanvas();
      }
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      this.cancelRenderingTask();
      /**
       * Zeroing the width and height cause most browsers to release graphics
       * resources immediately, which can greatly reduce memory consumption.
       */

      if (this.canvasLayer) {
        this.canvasLayer.width = 0;
        this.canvasLayer.height = 0;
        this.canvasLayer = null;
      }
    }
  }, {
    key: "cancelRenderingTask",
    value: function cancelRenderingTask() {
      if (this.renderer) {
        this.renderer.cancel();
        this.renderer = null;
      }
    }
    /**
     * Called when a page is rendered successfully.
     */

  }, {
    key: "render",
    value: function render() {
      var _this2 = this;

      var canvasRef = this.props.canvasRef;
      return /*#__PURE__*/React.createElement("canvas", {
        className: "react-pdf__Page__canvas",
        dir: "ltr",
        ref: mergeRefs(canvasRef, function (ref) {
          _this2.canvasLayer = ref;
        }),
        style: {
          display: 'block',
          userSelect: 'none'
        }
      });
    }
  }, {
    key: "renderViewport",
    get: function get() {
      var _this$props4 = this.props,
          page = _this$props4.page,
          rotate = _this$props4.rotate,
          scale = _this$props4.scale;
      var pixelRatio = getPixelRatio();
      return page.getViewport({
        scale: scale * pixelRatio,
        rotation: rotate
      });
    }
  }, {
    key: "viewport",
    get: function get() {
      var _this$props5 = this.props,
          page = _this$props5.page,
          rotate = _this$props5.rotate,
          scale = _this$props5.scale;
      return page.getViewport({
        scale: scale,
        rotation: rotate
      });
    }
  }]);

  return PageCanvasInternal;
}(PureComponent);
PageCanvasInternal.propTypes = {
  canvasRef: isRef,
  onRenderError: PropTypes.func,
  onRenderSuccess: PropTypes.func,
  page: isPage.isRequired,
  renderInteractiveForms: PropTypes.bool,
  rotate: isRotate,
  scale: PropTypes.number.isRequired
};
export default function PageCanvas(props) {
  return /*#__PURE__*/React.createElement(PageContext.Consumer, null, function (context) {
    return /*#__PURE__*/React.createElement(PageCanvasInternal, _extends({}, context, props));
  });
}