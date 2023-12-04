var $f0mF1$babelruntimehelpersextends = require("@babel/runtime/helpers/extends");
var $f0mF1$react = require("react");
var $f0mF1$radixuiprimitive = require("@radix-ui/primitive");
var $f0mF1$radixuireactcontext = require("@radix-ui/react-context");
var $f0mF1$radixuireactusecontrollablestate = require("@radix-ui/react-use-controllable-state");
var $f0mF1$radixuireactuselayouteffect = require("@radix-ui/react-use-layout-effect");
var $f0mF1$radixuireactcomposerefs = require("@radix-ui/react-compose-refs");
var $f0mF1$radixuireactprimitive = require("@radix-ui/react-primitive");
var $f0mF1$radixuireactpresence = require("@radix-ui/react-presence");
var $f0mF1$radixuireactid = require("@radix-ui/react-id");

function $parcel$export(e, n, v, s) {
  Object.defineProperty(e, n, {get: v, set: s, enumerable: true, configurable: true});
}
function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}

$parcel$export(module.exports, "createCollapsibleScope", () => $e729681ae85df948$export$952b32dcbe73087a);
$parcel$export(module.exports, "Collapsible", () => $e729681ae85df948$export$6eb0f7ddcda6131f);
$parcel$export(module.exports, "CollapsibleTrigger", () => $e729681ae85df948$export$c135dce7b15bbbdc);
$parcel$export(module.exports, "CollapsibleContent", () => $e729681ae85df948$export$aadde00976f34151);
$parcel$export(module.exports, "Root", () => $e729681ae85df948$export$be92b6f5f03c0fe9);
$parcel$export(module.exports, "Trigger", () => $e729681ae85df948$export$41fb9f06171c75f4);
$parcel$export(module.exports, "Content", () => $e729681ae85df948$export$7c6e2c02157bb7d2);










/* -------------------------------------------------------------------------------------------------
 * Collapsible
 * -----------------------------------------------------------------------------------------------*/ const $e729681ae85df948$var$COLLAPSIBLE_NAME = 'Collapsible';
const [$e729681ae85df948$var$createCollapsibleContext, $e729681ae85df948$export$952b32dcbe73087a] = $f0mF1$radixuireactcontext.createContextScope($e729681ae85df948$var$COLLAPSIBLE_NAME);
const [$e729681ae85df948$var$CollapsibleProvider, $e729681ae85df948$var$useCollapsibleContext] = $e729681ae85df948$var$createCollapsibleContext($e729681ae85df948$var$COLLAPSIBLE_NAME);
const $e729681ae85df948$export$6eb0f7ddcda6131f = /*#__PURE__*/ $f0mF1$react.forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , open: openProp , defaultOpen: defaultOpen , disabled: disabled , onOpenChange: onOpenChange , ...collapsibleProps } = props;
    const [open = false, setOpen] = $f0mF1$radixuireactusecontrollablestate.useControllableState({
        prop: openProp,
        defaultProp: defaultOpen,
        onChange: onOpenChange
    });
    return /*#__PURE__*/ $f0mF1$react.createElement($e729681ae85df948$var$CollapsibleProvider, {
        scope: __scopeCollapsible,
        disabled: disabled,
        contentId: $f0mF1$radixuireactid.useId(),
        open: open,
        onOpenToggle: $f0mF1$react.useCallback(()=>setOpen((prevOpen)=>!prevOpen
            )
        , [
            setOpen
        ])
    }, /*#__PURE__*/ $f0mF1$react.createElement($f0mF1$radixuireactprimitive.Primitive.div, ($parcel$interopDefault($f0mF1$babelruntimehelpersextends))({
        "data-state": $e729681ae85df948$var$getState(open),
        "data-disabled": disabled ? '' : undefined
    }, collapsibleProps, {
        ref: forwardedRef
    })));
});
/*#__PURE__*/ Object.assign($e729681ae85df948$export$6eb0f7ddcda6131f, {
    displayName: $e729681ae85df948$var$COLLAPSIBLE_NAME
});
/* -------------------------------------------------------------------------------------------------
 * CollapsibleTrigger
 * -----------------------------------------------------------------------------------------------*/ const $e729681ae85df948$var$TRIGGER_NAME = 'CollapsibleTrigger';
const $e729681ae85df948$export$c135dce7b15bbbdc = /*#__PURE__*/ $f0mF1$react.forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , ...triggerProps } = props;
    const context = $e729681ae85df948$var$useCollapsibleContext($e729681ae85df948$var$TRIGGER_NAME, __scopeCollapsible);
    return /*#__PURE__*/ $f0mF1$react.createElement($f0mF1$radixuireactprimitive.Primitive.button, ($parcel$interopDefault($f0mF1$babelruntimehelpersextends))({
        type: "button",
        "aria-controls": context.contentId,
        "aria-expanded": context.open || false,
        "data-state": $e729681ae85df948$var$getState(context.open),
        "data-disabled": context.disabled ? '' : undefined,
        disabled: context.disabled
    }, triggerProps, {
        ref: forwardedRef,
        onClick: $f0mF1$radixuiprimitive.composeEventHandlers(props.onClick, context.onOpenToggle)
    }));
});
/*#__PURE__*/ Object.assign($e729681ae85df948$export$c135dce7b15bbbdc, {
    displayName: $e729681ae85df948$var$TRIGGER_NAME
});
/* -------------------------------------------------------------------------------------------------
 * CollapsibleContent
 * -----------------------------------------------------------------------------------------------*/ const $e729681ae85df948$var$CONTENT_NAME = 'CollapsibleContent';
const $e729681ae85df948$export$aadde00976f34151 = /*#__PURE__*/ $f0mF1$react.forwardRef((props, forwardedRef)=>{
    const { forceMount: forceMount , ...contentProps } = props;
    const context = $e729681ae85df948$var$useCollapsibleContext($e729681ae85df948$var$CONTENT_NAME, props.__scopeCollapsible);
    return /*#__PURE__*/ $f0mF1$react.createElement($f0mF1$radixuireactpresence.Presence, {
        present: forceMount || context.open
    }, ({ present: present  })=>/*#__PURE__*/ $f0mF1$react.createElement($e729681ae85df948$var$CollapsibleContentImpl, ($parcel$interopDefault($f0mF1$babelruntimehelpersextends))({}, contentProps, {
            ref: forwardedRef,
            present: present
        }))
    );
});
/*#__PURE__*/ Object.assign($e729681ae85df948$export$aadde00976f34151, {
    displayName: $e729681ae85df948$var$CONTENT_NAME
});
/* -----------------------------------------------------------------------------------------------*/ const $e729681ae85df948$var$CollapsibleContentImpl = /*#__PURE__*/ $f0mF1$react.forwardRef((props, forwardedRef)=>{
    const { __scopeCollapsible: __scopeCollapsible , present: present , children: children , ...contentProps } = props;
    const context = $e729681ae85df948$var$useCollapsibleContext($e729681ae85df948$var$CONTENT_NAME, __scopeCollapsible);
    const [isPresent, setIsPresent] = $f0mF1$react.useState(present);
    const ref = $f0mF1$react.useRef(null);
    const composedRefs = $f0mF1$radixuireactcomposerefs.useComposedRefs(forwardedRef, ref);
    const heightRef = $f0mF1$react.useRef(0);
    const height = heightRef.current;
    const widthRef = $f0mF1$react.useRef(0);
    const width = widthRef.current; // when opening we want it to immediately open to retrieve dimensions
    // when closing we delay `present` to retrieve dimensions before closing
    const isOpen = context.open || isPresent;
    const isMountAnimationPreventedRef = $f0mF1$react.useRef(isOpen);
    const originalStylesRef = $f0mF1$react.useRef();
    $f0mF1$react.useEffect(()=>{
        const rAF = requestAnimationFrame(()=>isMountAnimationPreventedRef.current = false
        );
        return ()=>cancelAnimationFrame(rAF)
        ;
    }, []);
    $f0mF1$radixuireactuselayouteffect.useLayoutEffect(()=>{
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
    return /*#__PURE__*/ $f0mF1$react.createElement($f0mF1$radixuireactprimitive.Primitive.div, ($parcel$interopDefault($f0mF1$babelruntimehelpersextends))({
        "data-state": $e729681ae85df948$var$getState(context.open),
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
/* -----------------------------------------------------------------------------------------------*/ function $e729681ae85df948$var$getState(open) {
    return open ? 'open' : 'closed';
}
const $e729681ae85df948$export$be92b6f5f03c0fe9 = $e729681ae85df948$export$6eb0f7ddcda6131f;
const $e729681ae85df948$export$41fb9f06171c75f4 = $e729681ae85df948$export$c135dce7b15bbbdc;
const $e729681ae85df948$export$7c6e2c02157bb7d2 = $e729681ae85df948$export$aadde00976f34151;




//# sourceMappingURL=index.js.map
