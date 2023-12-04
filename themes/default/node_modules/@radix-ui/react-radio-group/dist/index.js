var $9yYIj$babelruntimehelpersextends = require("@babel/runtime/helpers/extends");
var $9yYIj$react = require("react");
var $9yYIj$radixuiprimitive = require("@radix-ui/primitive");
var $9yYIj$radixuireactcomposerefs = require("@radix-ui/react-compose-refs");
var $9yYIj$radixuireactcontext = require("@radix-ui/react-context");
var $9yYIj$radixuireactprimitive = require("@radix-ui/react-primitive");
var $9yYIj$radixuireactrovingfocus = require("@radix-ui/react-roving-focus");
var $9yYIj$radixuireactusecontrollablestate = require("@radix-ui/react-use-controllable-state");
var $9yYIj$radixuireactdirection = require("@radix-ui/react-direction");
var $9yYIj$radixuireactusesize = require("@radix-ui/react-use-size");
var $9yYIj$radixuireactuseprevious = require("@radix-ui/react-use-previous");
var $9yYIj$radixuireactpresence = require("@radix-ui/react-presence");

function $parcel$export(e, n, v, s) {
  Object.defineProperty(e, n, {get: v, set: s, enumerable: true, configurable: true});
}
function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}

$parcel$export(module.exports, "createRadioGroupScope", () => $240483839a8a76fd$export$c547093f11b76da2);
$parcel$export(module.exports, "RadioGroup", () => $240483839a8a76fd$export$a98f0dcb43a68a25);
$parcel$export(module.exports, "RadioGroupItem", () => $240483839a8a76fd$export$9f866c100ef519e4);
$parcel$export(module.exports, "RadioGroupIndicator", () => $240483839a8a76fd$export$5fb54c671a65c88);
$parcel$export(module.exports, "Root", () => $240483839a8a76fd$export$be92b6f5f03c0fe9);
$parcel$export(module.exports, "Item", () => $240483839a8a76fd$export$6d08773d2e66f8f2);
$parcel$export(module.exports, "Indicator", () => $240483839a8a76fd$export$adb584737d712b70);



















/* -------------------------------------------------------------------------------------------------
 * Radio
 * -----------------------------------------------------------------------------------------------*/ const $ce74a64c62457efb$var$RADIO_NAME = 'Radio';
const [$ce74a64c62457efb$var$createRadioContext, $ce74a64c62457efb$export$67d2296460f1b002] = $9yYIj$radixuireactcontext.createContextScope($ce74a64c62457efb$var$RADIO_NAME);
const [$ce74a64c62457efb$var$RadioProvider, $ce74a64c62457efb$var$useRadioContext] = $ce74a64c62457efb$var$createRadioContext($ce74a64c62457efb$var$RADIO_NAME);
const $ce74a64c62457efb$export$d7b12c4107be0d61 = /*#__PURE__*/ $9yYIj$react.forwardRef((props, forwardedRef)=>{
    const { __scopeRadio: __scopeRadio , name: name , checked: checked = false , required: required , disabled: disabled , value: value = 'on' , onCheck: onCheck , ...radioProps } = props;
    const [button, setButton] = $9yYIj$react.useState(null);
    const composedRefs = $9yYIj$radixuireactcomposerefs.useComposedRefs(forwardedRef, (node)=>setButton(node)
    );
    const hasConsumerStoppedPropagationRef = $9yYIj$react.useRef(false); // We set this to true by default so that events bubble to forms without JS (SSR)
    const isFormControl = button ? Boolean(button.closest('form')) : true;
    return /*#__PURE__*/ $9yYIj$react.createElement($ce74a64c62457efb$var$RadioProvider, {
        scope: __scopeRadio,
        checked: checked,
        disabled: disabled
    }, /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactprimitive.Primitive.button, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        type: "button",
        role: "radio",
        "aria-checked": checked,
        "data-state": $ce74a64c62457efb$var$getState(checked),
        "data-disabled": disabled ? '' : undefined,
        disabled: disabled,
        value: value
    }, radioProps, {
        ref: composedRefs,
        onClick: $9yYIj$radixuiprimitive.composeEventHandlers(props.onClick, (event)=>{
            // radios cannot be unchecked so we only communicate a checked state
            if (!checked) onCheck === null || onCheck === void 0 || onCheck();
            if (isFormControl) {
                hasConsumerStoppedPropagationRef.current = event.isPropagationStopped(); // if radio is in a form, stop propagation from the button so that we only propagate
                // one click event (from the input). We propagate changes from an input so that native
                // form validation works and form events reflect radio updates.
                if (!hasConsumerStoppedPropagationRef.current) event.stopPropagation();
            }
        })
    })), isFormControl && /*#__PURE__*/ $9yYIj$react.createElement($ce74a64c62457efb$var$BubbleInput, {
        control: button,
        bubbles: !hasConsumerStoppedPropagationRef.current,
        name: name,
        value: value,
        checked: checked,
        required: required,
        disabled: disabled // We transform because the input is absolutely positioned but we have
        ,
        style: {
            transform: 'translateX(-100%)'
        }
    }));
});
/*#__PURE__*/ Object.assign($ce74a64c62457efb$export$d7b12c4107be0d61, {
    displayName: $ce74a64c62457efb$var$RADIO_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioIndicator
 * -----------------------------------------------------------------------------------------------*/ const $ce74a64c62457efb$var$INDICATOR_NAME = 'RadioIndicator';
const $ce74a64c62457efb$export$d35a9ffa9a04f9e7 = /*#__PURE__*/ $9yYIj$react.forwardRef((props, forwardedRef)=>{
    const { __scopeRadio: __scopeRadio , forceMount: forceMount , ...indicatorProps } = props;
    const context = $ce74a64c62457efb$var$useRadioContext($ce74a64c62457efb$var$INDICATOR_NAME, __scopeRadio);
    return /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactpresence.Presence, {
        present: forceMount || context.checked
    }, /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactprimitive.Primitive.span, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        "data-state": $ce74a64c62457efb$var$getState(context.checked),
        "data-disabled": context.disabled ? '' : undefined
    }, indicatorProps, {
        ref: forwardedRef
    })));
});
/*#__PURE__*/ Object.assign($ce74a64c62457efb$export$d35a9ffa9a04f9e7, {
    displayName: $ce74a64c62457efb$var$INDICATOR_NAME
});
/* ---------------------------------------------------------------------------------------------- */ const $ce74a64c62457efb$var$BubbleInput = (props)=>{
    const { control: control , checked: checked , bubbles: bubbles = true , ...inputProps } = props;
    const ref = $9yYIj$react.useRef(null);
    const prevChecked = $9yYIj$radixuireactuseprevious.usePrevious(checked);
    const controlSize = $9yYIj$radixuireactusesize.useSize(control); // Bubble checked change to parents (e.g form change event)
    $9yYIj$react.useEffect(()=>{
        const input = ref.current;
        const inputProto = window.HTMLInputElement.prototype;
        const descriptor = Object.getOwnPropertyDescriptor(inputProto, 'checked');
        const setChecked = descriptor.set;
        if (prevChecked !== checked && setChecked) {
            const event = new Event('click', {
                bubbles: bubbles
            });
            setChecked.call(input, checked);
            input.dispatchEvent(event);
        }
    }, [
        prevChecked,
        checked,
        bubbles
    ]);
    return /*#__PURE__*/ $9yYIj$react.createElement("input", ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        type: "radio",
        "aria-hidden": true,
        defaultChecked: checked
    }, inputProps, {
        tabIndex: -1,
        ref: ref,
        style: {
            ...props.style,
            ...controlSize,
            position: 'absolute',
            pointerEvents: 'none',
            opacity: 0,
            margin: 0
        }
    }));
};
function $ce74a64c62457efb$var$getState(checked) {
    return checked ? 'checked' : 'unchecked';
}


const $240483839a8a76fd$var$ARROW_KEYS = [
    'ArrowUp',
    'ArrowDown',
    'ArrowLeft',
    'ArrowRight'
];
/* -------------------------------------------------------------------------------------------------
 * RadioGroup
 * -----------------------------------------------------------------------------------------------*/ const $240483839a8a76fd$var$RADIO_GROUP_NAME = 'RadioGroup';
const [$240483839a8a76fd$var$createRadioGroupContext, $240483839a8a76fd$export$c547093f11b76da2] = $9yYIj$radixuireactcontext.createContextScope($240483839a8a76fd$var$RADIO_GROUP_NAME, [
    $9yYIj$radixuireactrovingfocus.createRovingFocusGroupScope,
    $ce74a64c62457efb$export$67d2296460f1b002
]);
const $240483839a8a76fd$var$useRovingFocusGroupScope = $9yYIj$radixuireactrovingfocus.createRovingFocusGroupScope();
const $240483839a8a76fd$var$useRadioScope = $ce74a64c62457efb$export$67d2296460f1b002();
const [$240483839a8a76fd$var$RadioGroupProvider, $240483839a8a76fd$var$useRadioGroupContext] = $240483839a8a76fd$var$createRadioGroupContext($240483839a8a76fd$var$RADIO_GROUP_NAME);
const $240483839a8a76fd$export$a98f0dcb43a68a25 = /*#__PURE__*/ $9yYIj$react.forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , name: name , defaultValue: defaultValue , value: valueProp , required: required = false , disabled: disabled = false , orientation: orientation , dir: dir , loop: loop = true , onValueChange: onValueChange , ...groupProps } = props;
    const rovingFocusGroupScope = $240483839a8a76fd$var$useRovingFocusGroupScope(__scopeRadioGroup);
    const direction = $9yYIj$radixuireactdirection.useDirection(dir);
    const [value, setValue] = $9yYIj$radixuireactusecontrollablestate.useControllableState({
        prop: valueProp,
        defaultProp: defaultValue,
        onChange: onValueChange
    });
    return /*#__PURE__*/ $9yYIj$react.createElement($240483839a8a76fd$var$RadioGroupProvider, {
        scope: __scopeRadioGroup,
        name: name,
        required: required,
        disabled: disabled,
        value: value,
        onValueChange: setValue
    }, /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactrovingfocus.Root, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        asChild: true
    }, rovingFocusGroupScope, {
        orientation: orientation,
        dir: direction,
        loop: loop
    }), /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactprimitive.Primitive.div, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        role: "radiogroup",
        "aria-required": required,
        "aria-orientation": orientation,
        "data-disabled": disabled ? '' : undefined,
        dir: direction
    }, groupProps, {
        ref: forwardedRef
    }))));
});
/*#__PURE__*/ Object.assign($240483839a8a76fd$export$a98f0dcb43a68a25, {
    displayName: $240483839a8a76fd$var$RADIO_GROUP_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioGroupItem
 * -----------------------------------------------------------------------------------------------*/ const $240483839a8a76fd$var$ITEM_NAME = 'RadioGroupItem';
const $240483839a8a76fd$export$9f866c100ef519e4 = /*#__PURE__*/ $9yYIj$react.forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , disabled: disabled , ...itemProps } = props;
    const context = $240483839a8a76fd$var$useRadioGroupContext($240483839a8a76fd$var$ITEM_NAME, __scopeRadioGroup);
    const isDisabled = context.disabled || disabled;
    const rovingFocusGroupScope = $240483839a8a76fd$var$useRovingFocusGroupScope(__scopeRadioGroup);
    const radioScope = $240483839a8a76fd$var$useRadioScope(__scopeRadioGroup);
    const ref = $9yYIj$react.useRef(null);
    const composedRefs = $9yYIj$radixuireactcomposerefs.useComposedRefs(forwardedRef, ref);
    const checked = context.value === itemProps.value;
    const isArrowKeyPressedRef = $9yYIj$react.useRef(false);
    $9yYIj$react.useEffect(()=>{
        const handleKeyDown = (event)=>{
            if ($240483839a8a76fd$var$ARROW_KEYS.includes(event.key)) isArrowKeyPressedRef.current = true;
        };
        const handleKeyUp = ()=>isArrowKeyPressedRef.current = false
        ;
        document.addEventListener('keydown', handleKeyDown);
        document.addEventListener('keyup', handleKeyUp);
        return ()=>{
            document.removeEventListener('keydown', handleKeyDown);
            document.removeEventListener('keyup', handleKeyUp);
        };
    }, []);
    return /*#__PURE__*/ $9yYIj$react.createElement($9yYIj$radixuireactrovingfocus.Item, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        asChild: true
    }, rovingFocusGroupScope, {
        focusable: !isDisabled,
        active: checked
    }), /*#__PURE__*/ $9yYIj$react.createElement($ce74a64c62457efb$export$d7b12c4107be0d61, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({
        disabled: isDisabled,
        required: context.required,
        checked: checked
    }, radioScope, itemProps, {
        name: context.name,
        ref: composedRefs,
        onCheck: ()=>context.onValueChange(itemProps.value)
        ,
        onKeyDown: $9yYIj$radixuiprimitive.composeEventHandlers((event)=>{
            // According to WAI ARIA, radio groups don't activate items on enter keypress
            if (event.key === 'Enter') event.preventDefault();
        }),
        onFocus: $9yYIj$radixuiprimitive.composeEventHandlers(itemProps.onFocus, ()=>{
            var _ref$current;
            /**
       * Our `RovingFocusGroup` will focus the radio when navigating with arrow keys
       * and we need to "check" it in that case. We click it to "check" it (instead
       * of updating `context.value`) so that the radio change event fires.
       */ if (isArrowKeyPressedRef.current) (_ref$current = ref.current) === null || _ref$current === void 0 || _ref$current.click();
        })
    })));
});
/*#__PURE__*/ Object.assign($240483839a8a76fd$export$9f866c100ef519e4, {
    displayName: $240483839a8a76fd$var$ITEM_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioGroupIndicator
 * -----------------------------------------------------------------------------------------------*/ const $240483839a8a76fd$var$INDICATOR_NAME = 'RadioGroupIndicator';
const $240483839a8a76fd$export$5fb54c671a65c88 = /*#__PURE__*/ $9yYIj$react.forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , ...indicatorProps } = props;
    const radioScope = $240483839a8a76fd$var$useRadioScope(__scopeRadioGroup);
    return /*#__PURE__*/ $9yYIj$react.createElement($ce74a64c62457efb$export$d35a9ffa9a04f9e7, ($parcel$interopDefault($9yYIj$babelruntimehelpersextends))({}, radioScope, indicatorProps, {
        ref: forwardedRef
    }));
});
/*#__PURE__*/ Object.assign($240483839a8a76fd$export$5fb54c671a65c88, {
    displayName: $240483839a8a76fd$var$INDICATOR_NAME
});
/* ---------------------------------------------------------------------------------------------- */ const $240483839a8a76fd$export$be92b6f5f03c0fe9 = $240483839a8a76fd$export$a98f0dcb43a68a25;
const $240483839a8a76fd$export$6d08773d2e66f8f2 = $240483839a8a76fd$export$9f866c100ef519e4;
const $240483839a8a76fd$export$adb584737d712b70 = $240483839a8a76fd$export$5fb54c671a65c88;




//# sourceMappingURL=index.js.map
