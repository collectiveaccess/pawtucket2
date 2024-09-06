import $8D4cD$babelruntimehelpersesmextends from "@babel/runtime/helpers/esm/extends";
import {forwardRef as $8D4cD$forwardRef, createElement as $8D4cD$createElement} from "react";
import {Primitive as $8D4cD$Primitive} from "@radix-ui/react-primitive";




/* -------------------------------------------------------------------------------------------------
 * AspectRatio
 * -----------------------------------------------------------------------------------------------*/ const $c1b5f66aac50e106$var$NAME = 'AspectRatio';
const $c1b5f66aac50e106$export$e840e8869344ca38 = /*#__PURE__*/ $8D4cD$forwardRef((props, forwardedRef)=>{
    const { ratio: ratio = 1 , style: style , ...aspectRatioProps } = props;
    return /*#__PURE__*/ $8D4cD$createElement("div", {
        style: {
            // ensures inner element is contained
            position: 'relative',
            // ensures padding bottom trick maths works
            width: '100%',
            paddingBottom: `${100 / ratio}%`
        },
        "data-radix-aspect-ratio-wrapper": ""
    }, /*#__PURE__*/ $8D4cD$createElement($8D4cD$Primitive.div, $8D4cD$babelruntimehelpersesmextends({}, aspectRatioProps, {
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
/*#__PURE__*/ Object.assign($c1b5f66aac50e106$export$e840e8869344ca38, {
    displayName: $c1b5f66aac50e106$var$NAME
});
/* -----------------------------------------------------------------------------------------------*/ const $c1b5f66aac50e106$export$be92b6f5f03c0fe9 = $c1b5f66aac50e106$export$e840e8869344ca38;




export {$c1b5f66aac50e106$export$e840e8869344ca38 as AspectRatio, $c1b5f66aac50e106$export$be92b6f5f03c0fe9 as Root};
//# sourceMappingURL=index.mjs.map
