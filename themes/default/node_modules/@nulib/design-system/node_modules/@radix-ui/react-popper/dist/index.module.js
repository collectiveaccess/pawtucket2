import $kY93V$babelruntimehelpersesmextends from "@babel/runtime/helpers/esm/extends";
import {useState as $kY93V$useState, createElement as $kY93V$createElement, forwardRef as $kY93V$forwardRef, useRef as $kY93V$useRef, useEffect as $kY93V$useEffect, useLayoutEffect as $kY93V$useLayoutEffect} from "react";
import {useFloating as $kY93V$useFloating, autoUpdate as $kY93V$autoUpdate, offset as $kY93V$offset, shift as $kY93V$shift, limitShift as $kY93V$limitShift, arrow as $kY93V$arrow, flip as $kY93V$flip, hide as $kY93V$hide} from "@floating-ui/react-dom";
import {Root as $kY93V$Root} from "@radix-ui/react-arrow";
import {useComposedRefs as $kY93V$useComposedRefs} from "@radix-ui/react-compose-refs";
import {createContextScope as $kY93V$createContextScope} from "@radix-ui/react-context";
import {Primitive as $kY93V$Primitive} from "@radix-ui/react-primitive";
import {useLayoutEffect as $kY93V$useLayoutEffect1} from "@radix-ui/react-use-layout-effect";
import {useSize as $kY93V$useSize} from "@radix-ui/react-use-size";










const $cf1ac5d9fe0e8206$export$36f0086da09c4b9f = [
    'top',
    'right',
    'bottom',
    'left'
];
const $cf1ac5d9fe0e8206$export$3671ffab7b302fc9 = [
    'start',
    'center',
    'end'
];
/* -------------------------------------------------------------------------------------------------
 * Popper
 * -----------------------------------------------------------------------------------------------*/ const $cf1ac5d9fe0e8206$var$POPPER_NAME = 'Popper';
const [$cf1ac5d9fe0e8206$var$createPopperContext, $cf1ac5d9fe0e8206$export$722aac194ae923] = $kY93V$createContextScope($cf1ac5d9fe0e8206$var$POPPER_NAME);
const [$cf1ac5d9fe0e8206$var$PopperProvider, $cf1ac5d9fe0e8206$var$usePopperContext] = $cf1ac5d9fe0e8206$var$createPopperContext($cf1ac5d9fe0e8206$var$POPPER_NAME);
const $cf1ac5d9fe0e8206$export$badac9ada3a0bdf9 = (props)=>{
    const { __scopePopper: __scopePopper , children: children  } = props;
    const [anchor, setAnchor] = $kY93V$useState(null);
    return /*#__PURE__*/ $kY93V$createElement($cf1ac5d9fe0e8206$var$PopperProvider, {
        scope: __scopePopper,
        anchor: anchor,
        onAnchorChange: setAnchor
    }, children);
};
/*#__PURE__*/ Object.assign($cf1ac5d9fe0e8206$export$badac9ada3a0bdf9, {
    displayName: $cf1ac5d9fe0e8206$var$POPPER_NAME
});
/* -------------------------------------------------------------------------------------------------
 * PopperAnchor
 * -----------------------------------------------------------------------------------------------*/ const $cf1ac5d9fe0e8206$var$ANCHOR_NAME = 'PopperAnchor';
const $cf1ac5d9fe0e8206$export$ecd4e1ccab6ed6d = /*#__PURE__*/ $kY93V$forwardRef((props, forwardedRef)=>{
    const { __scopePopper: __scopePopper , virtualRef: virtualRef , ...anchorProps } = props;
    const context = $cf1ac5d9fe0e8206$var$usePopperContext($cf1ac5d9fe0e8206$var$ANCHOR_NAME, __scopePopper);
    const ref = $kY93V$useRef(null);
    const composedRefs = $kY93V$useComposedRefs(forwardedRef, ref);
    $kY93V$useEffect(()=>{
        // Consumer can anchor the popper to something that isn't
        // a DOM node e.g. pointer position, so we override the
        // `anchorRef` with their virtual ref in this case.
        context.onAnchorChange((virtualRef === null || virtualRef === void 0 ? void 0 : virtualRef.current) || ref.current);
    });
    return virtualRef ? null : /*#__PURE__*/ $kY93V$createElement($kY93V$Primitive.div, $kY93V$babelruntimehelpersesmextends({}, anchorProps, {
        ref: composedRefs
    }));
});
/*#__PURE__*/ Object.assign($cf1ac5d9fe0e8206$export$ecd4e1ccab6ed6d, {
    displayName: $cf1ac5d9fe0e8206$var$ANCHOR_NAME
});
/* -------------------------------------------------------------------------------------------------
 * PopperContent
 * -----------------------------------------------------------------------------------------------*/ const $cf1ac5d9fe0e8206$var$CONTENT_NAME = 'PopperContent';
const [$cf1ac5d9fe0e8206$var$PopperContentProvider, $cf1ac5d9fe0e8206$var$useContentContext] = $cf1ac5d9fe0e8206$var$createPopperContext($cf1ac5d9fe0e8206$var$CONTENT_NAME);
const [$cf1ac5d9fe0e8206$var$PositionContextProvider, $cf1ac5d9fe0e8206$var$usePositionContext] = $cf1ac5d9fe0e8206$var$createPopperContext($cf1ac5d9fe0e8206$var$CONTENT_NAME, {
    hasParent: false,
    positionUpdateFns: new Set()
});
const $cf1ac5d9fe0e8206$export$bc4ae5855d3c4fc = /*#__PURE__*/ $kY93V$forwardRef((props, forwardedRef)=>{
    var _arrowSize$width, _arrowSize$height, _middlewareData$arrow, _middlewareData$arrow2, _middlewareData$arrow3, _middlewareData$hide, _middlewareData$trans, _middlewareData$trans2;
    const { __scopePopper: __scopePopper , side: side = 'bottom' , sideOffset: sideOffset = 0 , align: align = 'center' , alignOffset: alignOffset = 0 , arrowPadding: arrowPadding = 0 , collisionBoundary: collisionBoundary = [] , collisionPadding: collisionPaddingProp = 0 , sticky: sticky = 'partial' , hideWhenDetached: hideWhenDetached = false , avoidCollisions: avoidCollisions = true , ...contentProps } = props;
    const context = $cf1ac5d9fe0e8206$var$usePopperContext($cf1ac5d9fe0e8206$var$CONTENT_NAME, __scopePopper);
    const [content, setContent] = $kY93V$useState(null);
    const composedRefs = $kY93V$useComposedRefs(forwardedRef, (node)=>setContent(node)
    );
    const [arrow, setArrow] = $kY93V$useState(null);
    const arrowSize = $kY93V$useSize(arrow);
    const arrowWidth = (_arrowSize$width = arrowSize === null || arrowSize === void 0 ? void 0 : arrowSize.width) !== null && _arrowSize$width !== void 0 ? _arrowSize$width : 0;
    const arrowHeight = (_arrowSize$height = arrowSize === null || arrowSize === void 0 ? void 0 : arrowSize.height) !== null && _arrowSize$height !== void 0 ? _arrowSize$height : 0;
    const desiredPlacement = side + (align !== 'center' ? '-' + align : '');
    const collisionPadding = typeof collisionPaddingProp === 'number' ? collisionPaddingProp : {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0,
        ...collisionPaddingProp
    };
    const boundary = Array.isArray(collisionBoundary) ? collisionBoundary : [
        collisionBoundary
    ];
    const hasExplicitBoundaries = boundary.length > 0;
    const detectOverflowOptions = {
        padding: collisionPadding,
        boundary: boundary.filter($cf1ac5d9fe0e8206$var$isNotNull),
        // with `strategy: 'fixed'`, this is the only way to get it to respect boundaries
        altBoundary: hasExplicitBoundaries
    };
    const { reference: reference , floating: floating , strategy: strategy , x: x , y: y , placement: placement , middlewareData: middlewareData , update: update  } = $kY93V$useFloating({
        // default to `fixed` strategy so users don't have to pick and we also avoid focus scroll issues
        strategy: 'fixed',
        placement: desiredPlacement,
        whileElementsMounted: $kY93V$autoUpdate,
        middleware: [
            $kY93V$offset({
                mainAxis: sideOffset + arrowHeight,
                alignmentAxis: alignOffset
            }),
            avoidCollisions ? $kY93V$shift({
                mainAxis: true,
                crossAxis: false,
                limiter: sticky === 'partial' ? $kY93V$limitShift() : undefined,
                ...detectOverflowOptions
            }) : undefined,
            arrow ? $kY93V$arrow({
                element: arrow,
                padding: arrowPadding
            }) : undefined,
            avoidCollisions ? $kY93V$flip({
                ...detectOverflowOptions
            }) : undefined,
            $cf1ac5d9fe0e8206$var$transformOrigin({
                arrowWidth: arrowWidth,
                arrowHeight: arrowHeight
            }),
            hideWhenDetached ? $kY93V$hide({
                strategy: 'referenceHidden'
            }) : undefined
        ].filter($cf1ac5d9fe0e8206$var$isDefined)
    }); // assign the reference dynamically once `Content` has mounted so we can collocate the logic
    $kY93V$useLayoutEffect1(()=>{
        reference(context.anchor);
    }, [
        reference,
        context.anchor
    ]);
    const isPlaced = x !== null && y !== null;
    const [placedSide, placedAlign] = $cf1ac5d9fe0e8206$var$getSideAndAlignFromPlacement(placement);
    const arrowX = (_middlewareData$arrow = middlewareData.arrow) === null || _middlewareData$arrow === void 0 ? void 0 : _middlewareData$arrow.x;
    const arrowY = (_middlewareData$arrow2 = middlewareData.arrow) === null || _middlewareData$arrow2 === void 0 ? void 0 : _middlewareData$arrow2.y;
    const cannotCenterArrow = ((_middlewareData$arrow3 = middlewareData.arrow) === null || _middlewareData$arrow3 === void 0 ? void 0 : _middlewareData$arrow3.centerOffset) !== 0;
    const [contentZIndex, setContentZIndex] = $kY93V$useState();
    $kY93V$useLayoutEffect1(()=>{
        if (content) setContentZIndex(window.getComputedStyle(content).zIndex);
    }, [
        content
    ]);
    const { hasParent: hasParent , positionUpdateFns: positionUpdateFns  } = $cf1ac5d9fe0e8206$var$usePositionContext($cf1ac5d9fe0e8206$var$CONTENT_NAME, __scopePopper);
    const isRoot = !hasParent;
    $kY93V$useLayoutEffect(()=>{
        if (!isRoot) {
            positionUpdateFns.add(update);
            return ()=>{
                positionUpdateFns.delete(update);
            };
        }
    }, [
        isRoot,
        positionUpdateFns,
        update
    ]); // when nested contents are rendered in portals, they are appended out of order causing
    // children to be positioned incorrectly if initially open.
    // we need to re-compute the positioning once the parent has finally been placed.
    // https://github.com/floating-ui/floating-ui/issues/1531
    $kY93V$useLayoutEffect(()=>{
        if (isRoot && isPlaced) Array.from(positionUpdateFns).reverse().forEach((fn)=>requestAnimationFrame(fn)
        );
    }, [
        isRoot,
        isPlaced,
        positionUpdateFns
    ]);
    const commonProps = {
        'data-side': placedSide,
        'data-align': placedAlign,
        ...contentProps,
        ref: composedRefs,
        style: {
            ...contentProps.style,
            // if the PopperContent hasn't been placed yet (not all measurements done)
            // we prevent animations so that users's animation don't kick in too early referring wrong sides
            animation: !isPlaced ? 'none' : undefined,
            // hide the content if using the hide middleware and should be hidden
            opacity: (_middlewareData$hide = middlewareData.hide) !== null && _middlewareData$hide !== void 0 && _middlewareData$hide.referenceHidden ? 0 : undefined
        }
    };
    return /*#__PURE__*/ $kY93V$createElement("div", {
        ref: floating,
        "data-radix-popper-content-wrapper": "",
        style: {
            position: strategy,
            left: 0,
            top: 0,
            transform: isPlaced ? `translate3d(${Math.round(x)}px, ${Math.round(y)}px, 0)` : 'translate3d(0, -200%, 0)',
            // keep off the page when measuring
            minWidth: 'max-content',
            zIndex: contentZIndex,
            ['--radix-popper-transform-origin']: [
                (_middlewareData$trans = middlewareData.transformOrigin) === null || _middlewareData$trans === void 0 ? void 0 : _middlewareData$trans.x,
                (_middlewareData$trans2 = middlewareData.transformOrigin) === null || _middlewareData$trans2 === void 0 ? void 0 : _middlewareData$trans2.y
            ].join(' ')
        }
    }, /*#__PURE__*/ $kY93V$createElement($cf1ac5d9fe0e8206$var$PopperContentProvider, {
        scope: __scopePopper,
        placedSide: placedSide,
        onArrowChange: setArrow,
        arrowX: arrowX,
        arrowY: arrowY,
        shouldHideArrow: cannotCenterArrow
    }, isRoot ? /*#__PURE__*/ $kY93V$createElement($cf1ac5d9fe0e8206$var$PositionContextProvider, {
        scope: __scopePopper,
        hasParent: true,
        positionUpdateFns: positionUpdateFns
    }, /*#__PURE__*/ $kY93V$createElement($kY93V$Primitive.div, commonProps)) : /*#__PURE__*/ $kY93V$createElement($kY93V$Primitive.div, commonProps)));
});
/*#__PURE__*/ Object.assign($cf1ac5d9fe0e8206$export$bc4ae5855d3c4fc, {
    displayName: $cf1ac5d9fe0e8206$var$CONTENT_NAME
});
/* -------------------------------------------------------------------------------------------------
 * PopperArrow
 * -----------------------------------------------------------------------------------------------*/ const $cf1ac5d9fe0e8206$var$ARROW_NAME = 'PopperArrow';
const $cf1ac5d9fe0e8206$var$OPPOSITE_SIDE = {
    top: 'bottom',
    right: 'left',
    bottom: 'top',
    left: 'right'
};
const $cf1ac5d9fe0e8206$export$79d62cd4e10a3fd0 = /*#__PURE__*/ $kY93V$forwardRef(function $cf1ac5d9fe0e8206$export$79d62cd4e10a3fd0(props, forwardedRef) {
    const { __scopePopper: __scopePopper , ...arrowProps } = props;
    const contentContext = $cf1ac5d9fe0e8206$var$useContentContext($cf1ac5d9fe0e8206$var$ARROW_NAME, __scopePopper);
    const baseSide = $cf1ac5d9fe0e8206$var$OPPOSITE_SIDE[contentContext.placedSide];
    return(/*#__PURE__*/ // we have to use an extra wrapper because `ResizeObserver` (used by `useSize`)
    // doesn't report size as we'd expect on SVG elements.
    // it reports their bounding box which is effectively the largest path inside the SVG.
    $kY93V$createElement("span", {
        ref: contentContext.onArrowChange,
        style: {
            position: 'absolute',
            left: contentContext.arrowX,
            top: contentContext.arrowY,
            [baseSide]: 0,
            transformOrigin: {
                top: '',
                right: '0 0',
                bottom: 'center 0',
                left: '100% 0'
            }[contentContext.placedSide],
            transform: {
                top: 'translateY(100%)',
                right: 'translateY(50%) rotate(90deg) translateX(-50%)',
                bottom: `rotate(180deg)`,
                left: 'translateY(50%) rotate(-90deg) translateX(50%)'
            }[contentContext.placedSide],
            visibility: contentContext.shouldHideArrow ? 'hidden' : undefined
        }
    }, /*#__PURE__*/ $kY93V$createElement($kY93V$Root, $kY93V$babelruntimehelpersesmextends({}, arrowProps, {
        ref: forwardedRef,
        style: {
            ...arrowProps.style,
            // ensures the element can be measured correctly (mostly for if SVG)
            display: 'block'
        }
    }))));
});
/*#__PURE__*/ Object.assign($cf1ac5d9fe0e8206$export$79d62cd4e10a3fd0, {
    displayName: $cf1ac5d9fe0e8206$var$ARROW_NAME
});
/* -----------------------------------------------------------------------------------------------*/ function $cf1ac5d9fe0e8206$var$isDefined(value) {
    return value !== undefined;
}
function $cf1ac5d9fe0e8206$var$isNotNull(value) {
    return value !== null;
}
const $cf1ac5d9fe0e8206$var$transformOrigin = (options)=>({
        name: 'transformOrigin',
        options: options,
        fn (data) {
            var _middlewareData$arrow4, _middlewareData$arrow5, _middlewareData$arrow6, _middlewareData$arrow7, _middlewareData$arrow8;
            const { placement: placement , rects: rects , middlewareData: middlewareData  } = data;
            const cannotCenterArrow = ((_middlewareData$arrow4 = middlewareData.arrow) === null || _middlewareData$arrow4 === void 0 ? void 0 : _middlewareData$arrow4.centerOffset) !== 0;
            const isArrowHidden = cannotCenterArrow;
            const arrowWidth = isArrowHidden ? 0 : options.arrowWidth;
            const arrowHeight = isArrowHidden ? 0 : options.arrowHeight;
            const [placedSide, placedAlign] = $cf1ac5d9fe0e8206$var$getSideAndAlignFromPlacement(placement);
            const noArrowAlign = {
                start: '0%',
                center: '50%',
                end: '100%'
            }[placedAlign];
            const arrowXCenter = ((_middlewareData$arrow5 = (_middlewareData$arrow6 = middlewareData.arrow) === null || _middlewareData$arrow6 === void 0 ? void 0 : _middlewareData$arrow6.x) !== null && _middlewareData$arrow5 !== void 0 ? _middlewareData$arrow5 : 0) + arrowWidth / 2;
            const arrowYCenter = ((_middlewareData$arrow7 = (_middlewareData$arrow8 = middlewareData.arrow) === null || _middlewareData$arrow8 === void 0 ? void 0 : _middlewareData$arrow8.y) !== null && _middlewareData$arrow7 !== void 0 ? _middlewareData$arrow7 : 0) + arrowHeight / 2;
            let x = '';
            let y = '';
            if (placedSide === 'bottom') {
                x = isArrowHidden ? noArrowAlign : `${arrowXCenter}px`;
                y = `${-arrowHeight}px`;
            } else if (placedSide === 'top') {
                x = isArrowHidden ? noArrowAlign : `${arrowXCenter}px`;
                y = `${rects.floating.height + arrowHeight}px`;
            } else if (placedSide === 'right') {
                x = `${-arrowHeight}px`;
                y = isArrowHidden ? noArrowAlign : `${arrowYCenter}px`;
            } else if (placedSide === 'left') {
                x = `${rects.floating.width + arrowHeight}px`;
                y = isArrowHidden ? noArrowAlign : `${arrowYCenter}px`;
            }
            return {
                data: {
                    x: x,
                    y: y
                }
            };
        }
    })
;
function $cf1ac5d9fe0e8206$var$getSideAndAlignFromPlacement(placement) {
    const [side, align = 'center'] = placement.split('-');
    return [
        side,
        align
    ];
}
const $cf1ac5d9fe0e8206$export$be92b6f5f03c0fe9 = $cf1ac5d9fe0e8206$export$badac9ada3a0bdf9;
const $cf1ac5d9fe0e8206$export$b688253958b8dfe7 = $cf1ac5d9fe0e8206$export$ecd4e1ccab6ed6d;
const $cf1ac5d9fe0e8206$export$7c6e2c02157bb7d2 = $cf1ac5d9fe0e8206$export$bc4ae5855d3c4fc;
const $cf1ac5d9fe0e8206$export$21b07c8f274aebd5 = $cf1ac5d9fe0e8206$export$79d62cd4e10a3fd0;




export {$cf1ac5d9fe0e8206$export$722aac194ae923 as createPopperScope, $cf1ac5d9fe0e8206$export$badac9ada3a0bdf9 as Popper, $cf1ac5d9fe0e8206$export$ecd4e1ccab6ed6d as PopperAnchor, $cf1ac5d9fe0e8206$export$bc4ae5855d3c4fc as PopperContent, $cf1ac5d9fe0e8206$export$79d62cd4e10a3fd0 as PopperArrow, $cf1ac5d9fe0e8206$export$be92b6f5f03c0fe9 as Root, $cf1ac5d9fe0e8206$export$b688253958b8dfe7 as Anchor, $cf1ac5d9fe0e8206$export$7c6e2c02157bb7d2 as Content, $cf1ac5d9fe0e8206$export$21b07c8f274aebd5 as Arrow, $cf1ac5d9fe0e8206$export$36f0086da09c4b9f as SIDE_OPTIONS, $cf1ac5d9fe0e8206$export$3671ffab7b302fc9 as ALIGN_OPTIONS};
//# sourceMappingURL=index.module.js.map
