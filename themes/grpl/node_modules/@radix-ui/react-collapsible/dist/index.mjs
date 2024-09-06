import $73KQ4$babelruntimehelpersesmextends from "@babel/runtime/helpers/esm/extends";
import {forwardRef as $73KQ4$forwardRef, createElement as $73KQ4$createElement, useCallback as $73KQ4$useCallback, useState as $73KQ4$useState, useRef as $73KQ4$useRef, useEffect as $73KQ4$useEffect} from "react";
import {composeEventHandlers as $73KQ4$composeEventHandlers} from "@radix-ui/primitive";
import {createContextScope as $73KQ4$createContextScope} from "@radix-ui/react-context";
import {useControllableState as $73KQ4$useControllableState} from "@radix-ui/react-use-controllable-state";
import {useLayoutEffect as $73KQ4$useLayoutEffect} from "@radix-ui/react-use-layout-effect";
import {useComposedRefs as $73KQ4$useComposedRefs} from "@radix-ui/react-compose-refs";
import {Primitive as $73KQ4$Primitive} from "@radix-ui/react-primitive";
import {Presence as $73KQ4$Presence} from "@radix-ui/react-presence";
import {useId as $73KQ4$useId} from "@radix-ui/react-id";











/* -------------------------------------------------------------------------------------------------
 * Collapsible
 * -----------------------------------------------------------------------------------------------*/ const $409067139f391064$var$COLLAPSIBLE_NAME = 'Collapsible';
const [$409067139f391064$var$createCollapsibleContext, $409067139f391064$export$952b32dcbe73087a] = $73KQ4$createContextScope($409067139f391064$var$COLLAPSIBLE_NAME);
const [$409067139f391064$var$CollapsibleProvider, $409067139f391064$var$useCollapsibleContext] = $409067139f391064$var$createCollapsibleContext($409067139f391064$var$COLLAPSIBLE_NAME);
const $409067139f391064$export$6eb0f7ddcda6131f = /*#__PURE__*/ $73KQ4$forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , open: openProp , defaultOpen: defaultOpen , disabled: disabled , onOpenChange: onOpenChange , ...collapsibleProps } = props;
    const [open = false, setOpen] = $73KQ4$useControllableState({
        prop: openProp,
        defaultProp: defaultOpen,
        onChange: onOpenChange
    });
    return /*#__PURE__*/ $73KQ4$createElement($409067139f391064$var$CollapsibleProvider, {
        scope: __scopeCollapsible,
        disabled: disabled,
        contentId: $73KQ4$useId(),
        open: open,
        onOpenToggle: $73KQ4$useCallback(()=>setOpen((prevOpen)=>!prevOpen
            )
        , [
            setOpen
        ])
    }, /*#__PURE__*/ $73KQ4$createElement($73KQ4$Primitive.div, $73KQ4$babelruntimehelpersesmextends({
        "data-state": $409067139f391064$var$getState(open),
        "data-disabled": disabled ? '' : undefined
    }, collapsibleProps, {
        ref: forwardedRef
    })));
});
/*#__PURE__*/ Object.assign($409067139f391064$export$6eb0f7ddcda6131f, {
    displayName: $409067139f391064$var$COLLAPSIBLE_NAME
});
/* -------------------------------------------------------------------------------------------------
 * CollapsibleTrigger
 * -----------------------------------------------------------------------------------------------*/ const $409067139f391064$var$TRIGGER_NAME = 'CollapsibleTrigger';
const $409067139f391064$export$c135dce7b15bbbdc = /*#__PURE__*/ $73KQ4$forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , ...triggerProps } = props;
    const context = $409067139f391064$var$useCollapsibleContext($409067139f391064$var$TRIGGER_NAME, __scopeCollapsible);
    return /*#__PURE__*/ $73KQ4$createElement($73KQ4$Primitive.button, $73KQ4$babelruntimehelpersesmextends({
        type: "button",
        "aria-controls": context.contentId,
        "aria-expanded": context.open || false,
        "data-state": $409067139f391064$var$getState(context.open),
        "data-disabled": context.disabled ? '' : undefined,
        disabled: context.disabled
    }, triggerProps, {
        ref: forwardedRef,
        onClick: $73KQ4$composeEventHandlers(props.onClick, context.onOpenToggle)
    }));
});
/*#__PURE__*/ Object.assign($409067139f391064$export$c135dce7b15bbbdc, {
    displayName: $409067139f391064$var$TRIGGER_NAME
});
/* -------------------------------------------------------------------------------------------------
 * CollapsibleContent
 * -----------------------------------------------------------------------------------------------*/ const $409067139f391064$var$CONTENT_NAME = 'CollapsibleContent';
const $409067139f391064$export$aadde00976f34151 = /*#__PURE__*/ $73KQ4$forwardRef((props, forwardedRef)=>{
    const { forceMount: forceMount , ...contentProps } = props;
    const context = $409067139f391064$var$useCollapsibleContext($409067139f391064$var$CONTENT_NAME, props.__scopeCollapsible);
    return /*#__PURE__*/ $73KQ4$createElement($73KQ4$Presence, {
        present: forceMount || context.open
    }, ({ present: present  })=>/*#__PURE__*/ $73KQ4$createElement($409067139f391064$var$CollapsibleContentImpl, $73KQ4$babelruntimehelpersesmextends({}, contentProps, {
            ref: forwardedRef,
            present: present
        }))
    );
});
/*#__PURE__*/ Object.assign($409067139f391064$export$aadde00976f34151, {
    displayName: $409067139f391064$var$CONTENT_NAME
});
/* -----------------------------------------------------------------------------------------------*/ const $409067139f391064$var$CollapsibleContentImpl = /*#__PURE__*/ $73KQ4$forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , present: present , children: children , ...contentProps } = props;
    const context = $409067139f391064$var$useCollapsibleContext($409067139f391064$var$CONTENT_NAME, __scopeCollapsible);
    const [isPresent, setIsPresent] = $73KQ4$useState(present);
    const ref = $73KQ4$useRef(null);
    const composedRefs = $73KQ4$useComposedRefs(forwardedRef, ref);
    const heightRef = $73KQ4$useRef(0);
    const height = heightRef.current;
    const widthRef = $73KQ4$useRef(0);
    const width = widthRef.current; // when opening we want it to immediately open to retrieve dimensions
    // when closing we delay `present` to retrieve dimensions before closing
    const isOpen = context.open || isPresent;
    const isMountAnimationPreventedRef = $73KQ4$useRef(isOpen);
    const originalStylesRef = $73KQ4$useRef();
    $73KQ4$useEffect(()=>{
        const rAF = requestAnimationFrame(()=>isMountAnimationPreventedRef.current = false
        );
        return ()=>cancelAnimationFrame(rAF)
        ;
    }, []);
    $73KQ4$useLayoutEffect(()=>{
        const node = ref.current;
        if (node) {
            originalStylesRef.current = originalStylesRef.current || {
                transitionDuration: node.style.transitionDuration,
                animationName: node.style.animationName
            }; // block any animations/transitions so the element renders at its full dimensions
            node.style.transitionDuration = '0s';
            node.style.animationName = 'none'; // get width and height from full dimensions
            const rect = node.getBoundingClientRect();
            heightRef.current = rect.height;
            widthRef.current = rect.width; // kick off any animations/transitions that were originally set up if it isn't the initial mount
            if (!isMountAnimationPreventedRef.current) {
                node.style.transitionDuration = originalStylesRef.current.transitionDuration;
                node.style.animationName = originalStylesRef.current.animationName;
            }
            setIsPresent(present);
        }
    /**
     * depends on `context.open` because it will change to `false`
     * when a close is triggered but `present` will be `false` on
     * animation end (so when close finishes). This allows us to
     * retrieve the dimensions *before* closing.
     */ }, [
        context.open,
        present
    ]);
    return /*#__PURE__*/ $73KQ4$createElement($73KQ4$Primitive.div, $73KQ4$babelruntimehelpersesmextends({
        "data-state": $409067139f391064$var$getState(context.open),
        "data-disabled": context.disabled ? '' : undefined,
        id: context.contentId,
        hidden: !isOpen
    }, contentProps, {
        ref: composedRefs,
        style: {
            [`--radix-collapsible-content-height`]: height ? `${height}px` : undefined,
            [`--radix-collapsible-content-width`]: width ? `${width}px` : undefined,
            ...props.style
        }
    }), isOpen && children);
});
/* -----------------------------------------------------------------------------------------------*/ function $409067139f391064$var$getState(open) {
    return open ? 'open' : 'closed';
}
const $409067139f391064$export$be92b6f5f03c0fe9 = $409067139f391064$export$6eb0f7ddcda6131f;
const $409067139f391064$export$41fb9f06171c75f4 = $409067139f391064$export$c135dce7b15bbbdc;
const $409067139f391064$export$7c6e2c02157bb7d2 = $409067139f391064$export$aadde00976f34151;




export {$409067139f391064$export$952b32dcbe73087a as createCollapsibleScope, $409067139f391064$export$6eb0f7ddcda6131f as Collapsible, $409067139f391064$export$c135dce7b15bbbdc as CollapsibleTrigger, $409067139f391064$export$aadde00976f34151 as CollapsibleContent, $409067139f391064$export$be92b6f5f03c0fe9 as Root, $409067139f391064$export$41fb9f06171c75f4 as Trigger, $409067139f391064$export$7c6e2c02157bb7d2 as Content};
//# sourceMappingURL=index.mjs.map
