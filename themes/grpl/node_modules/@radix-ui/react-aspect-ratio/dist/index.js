var $frJTO$babelruntimehelpersextends = require("@babel/runtime/helpers/extends");
var $frJTO$react = require("react");
var $frJTO$radixuireactprimitive = require("@radix-ui/react-primitive");

function $parcel$export(e, n, v, s) {
  Object.defineProperty(e, n, {get: v, set: s, enumerable: true, configurable: true});
}
function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}

$parcel$export(module.exports, "AspectRatio", () => $f950105f8166e93b$export$e840e8869344ca38);
$parcel$export(module.exports, "Root", () => $f950105f8166e93b$export$be92b6f5f03c0fe9);



/* -------------------------------------------------------------------------------------------------
 * AspectRatio
 * -----------------------------------------------------------------------------------------------*/ const $f950105f8166e93b$var$NAME = 'AspectRatio';
const $f950105f8166e93b$export$e840e8869344ca38 = /*#__PURE__*/ $frJTO$react.forwardRef((props, forwardedRef)=>{
    const { ratio: ratio = 1 , style: style , ...aspectRatioProps } = props;
    return /*#__PURE__*/ $frJTO$react.createElement("div", {
        style: {
            // ensures inner element is contained
            position: 'relative',
            // ensures padding bottom trick maths works
            width: '100%',
            paddingBottom: `${100 / ratio}%`
        },
        "data-radix-aspect-ratio-wrapper": ""
    }, /*#__PURE__*/ $frJTO$react.createElement($frJTO$radixuireactprimitive.Primitive.div, ($parcel$interopDefault($frJTO$babelruntimehelpersextends))({}, aspectRatioProps, {
        ref: forwardedRef,
        style: {
            ...style,
            // ensures children expand in ratio
            position: 'absolute',
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    })));
});
/*#__PURE__*/ Object.assign($f950105f8166e93b$export$e840e8869344ca38, {
    displayName: $f950105f8166e93b$var$NAME
});
/* -----------------------------------------------------------------------------------------------*/ const $f950105f8166e93b$export$be92b6f5f03c0fe9 = $f950105f8166e93b$export$e840e8869344ca38;




//# sourceMappingURL=index.js.map
