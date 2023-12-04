import $8Wolv$babelruntimehelpersesmextends from "@babel/runtime/helpers/esm/extends";
import {forwardRef as $8Wolv$forwardRef, createElement as $8Wolv$createElement, useRef as $8Wolv$useRef, useEffect as $8Wolv$useEffect, useState as $8Wolv$useState} from "react";
import {composeEventHandlers as $8Wolv$composeEventHandlers} from "@radix-ui/primitive";
import {useComposedRefs as $8Wolv$useComposedRefs} from "@radix-ui/react-compose-refs";
import {createContextScope as $8Wolv$createContextScope} from "@radix-ui/react-context";
import {Primitive as $8Wolv$Primitive} from "@radix-ui/react-primitive";
import {createRovingFocusGroupScope as $8Wolv$createRovingFocusGroupScope, Root as $8Wolv$Root, Item as $8Wolv$Item} from "@radix-ui/react-roving-focus";
import {useControllableState as $8Wolv$useControllableState} from "@radix-ui/react-use-controllable-state";
import {useDirection as $8Wolv$useDirection} from "@radix-ui/react-direction";
import {useSize as $8Wolv$useSize} from "@radix-ui/react-use-size";
import {usePrevious as $8Wolv$usePrevious} from "@radix-ui/react-use-previous";
import {Presence as $8Wolv$Presence} from "@radix-ui/react-presence";




















/* -------------------------------------------------------------------------------------------------
 * Radio
 * -----------------------------------------------------------------------------------------------*/ const $ce77a8961b41be9e$var$RADIO_NAME = 'Radio';
const [$ce77a8961b41be9e$var$createRadioContext, $ce77a8961b41be9e$export$67d2296460f1b002] = $8Wolv$createContextScope($ce77a8961b41be9e$var$RADIO_NAME);
const [$ce77a8961b41be9e$var$RadioProvider, $ce77a8961b41be9e$var$useRadioContext] = $ce77a8961b41be9e$var$createRadioContext($ce77a8961b41be9e$var$RADIO_NAME);
const $ce77a8961b41be9e$export$d7b12c4107be0d61 = /*#__PURE__*/ $8Wolv$forwardRef((props, forwardedRef)=>{
    const { __scopeRadio: __scopeRadio , name: name , checked: checked = false , required: required , disabled: disabled , value: value = 'on' , onCheck: onCheck , ...radioProps } = props;
    const [button, setButton] = $8Wolv$useState(null);
    const composedRefs = $8Wolv$useComposedRefs(forwardedRef, (node)=>setButton(node)
    );
    const hasConsumerStoppedPropagationRef = $8Wolv$useRef(false); // We set this to true by default so that events bubble to forms without JS (SSR)
    const isFormControl = button ? Boolean(button.closest('form')) : true;
    return /*#__PURE__*/ $8Wolv$createElement($ce77a8961b41be9e$var$RadioProvider, {
        scope: __scopeRadio,
        checked: checked,
        disabled: disabled
    }, /*#__PURE__*/ $8Wolv$createElement($8Wolv$Primitive.button, $8Wolv$babelruntimehelpersesmextends({
        type: "button",
        role: "radio",
        "aria-checked": checked,
        "data-state": $ce77a8961b41be9e$var$getState(checked),
        "data-disabled": disabled ? '' : undefined,
        disabled: disabled,
        value: value
    }, radioProps, {
        ref: composedRefs,
        onClick: $8Wolv$composeEventHandlers(props.onClick, (event)=>{
            // radios cannot be unchecked so we only communicate a checked state
            if (!checked) onCheck === null || onCheck === void 0 || onCheck();
            if (isFormControl) {
                hasConsumerStoppedPropagationRef.current = event.isPropagationStopped(); // if radio is in a form, stop propagation from the button so that we only propagate
                // one click event (from the input). We propagate changes from an input so that native
                // form validation works and form events reflect radio updates.
                if (!hasConsumerStoppedPropagationRef.current) event.stopPropagation();
            }
        })
    })), isFormControl && /*#__PURE__*/ $8Wolv$createElement($ce77a8961b41be9e$var$BubbleInput, {
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
/*#__PURE__*/ Object.assign($ce77a8961b41be9e$export$d7b12c4107be0d61, {
    displayName: $ce77a8961b41be9e$var$RADIO_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioIndicator
 * -----------------------------------------------------------------------------------------------*/ const $ce77a8961b41be9e$var$INDICATOR_NAME = 'RadioIndicator';
const $ce77a8961b41be9e$export$d35a9ffa9a04f9e7 = /*#__PURE__*/ $8Wolv$forwardRef((props, forwardedRef)=>{
    const { __scopeRadio: __scopeRadio , forceMount: forceMount , ...indicatorProps } = props;
    const context = $ce77a8961b41be9e$var$useRadioContext($ce77a8961b41be9e$var$INDICATOR_NAME, __scopeRadio);
    return /*#__PURE__*/ $8Wolv$createElement($8Wolv$Presence, {
        present: forceMount || context.checked
    }, /*#__PURE__*/ $8Wolv$createElement($8Wolv$Primitive.span, $8Wolv$babelruntimehelpersesmextends({
        "data-state": $ce77a8961b41be9e$var$getState(context.checked),
        "data-disabled": context.disabled ? '' : undefined
    }, indicatorProps, {
        ref: forwardedRef
    })));
});
/*#__PURE__*/ Object.assign($ce77a8961b41be9e$export$d35a9ffa9a04f9e7, {
    displayName: $ce77a8961b41be9e$var$INDICATOR_NAME
});
/* ---------------------------------------------------------------------------------------------- */ const $ce77a8961b41be9e$var$BubbleInput = (props)=>{
    const { control: control , checked: checked , bubbles: bubbles = true , ...inputProps } = props;
    const ref = $8Wolv$useRef(null);
    const prevChecked = $8Wolv$usePrevious(checked);
    const controlSize = $8Wolv$useSize(control); // Bubble checked change to parents (e.g form change event)
    $8Wolv$useEffect(()=>{
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
    return /*#__PURE__*/ $8Wolv$createElement("input", $8Wolv$babelruntimehelpersesmextends({
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
function $ce77a8961b41be9e$var$getState(checked) {
    return checked ? 'checked' : 'unchecked';
}


const $f99a8c78507165f7$var$ARROW_KEYS = [
    'ArrowUp',
    'ArrowDown',
    'ArrowLeft',
    'ArrowRight'
];
/* -------------------------------------------------------------------------------------------------
 * RadioGroup
 * -----------------------------------------------------------------------------------------------*/ const $f99a8c78507165f7$var$RADIO_GROUP_NAME = 'RadioGroup';
const [$f99a8c78507165f7$var$createRadioGroupContext, $f99a8c78507165f7$export$c547093f11b76da2] = $8Wolv$createContextScope($f99a8c78507165f7$var$RADIO_GROUP_NAME, [
    $8Wolv$createRovingFocusGroupScope,
    $ce77a8961b41be9e$export$67d2296460f1b002
]);
const $f99a8c78507165f7$var$useRovingFocusGroupScope = $8Wolv$createRovingFocusGroupScope();
const $f99a8c78507165f7$var$useRadioScope = $ce77a8961b41be9e$export$67d2296460f1b002();
const [$f99a8c78507165f7$var$RadioGroupProvider, $f99a8c78507165f7$var$useRadioGroupContext] = $f99a8c78507165f7$var$createRadioGroupContext($f99a8c78507165f7$var$RADIO_GROUP_NAME);
const $f99a8c78507165f7$export$a98f0dcb43a68a25 = /*#__PURE__*/ $8Wolv$forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , name: name , defaultValue: defaultValue , value: valueProp , required: required = false , disabled: disabled = false , orientation: orientation , dir: dir , loop: loop = true , onValueChange: onValueChange , ...groupProps } = props;
    const rovingFocusGroupScope = $f99a8c78507165f7$var$useRovingFocusGroupScope(__scopeRadioGroup);
    const direction = $8Wolv$useDirection(dir);
    const [value, setValue] = $8Wolv$useControllableState({
        prop: valueProp,
        defaultProp: defaultValue,
        onChange: onValueChange
    });
    return /*#__PURE__*/ $8Wolv$createElement($f99a8c78507165f7$var$RadioGroupProvider, {
        scope: __scopeRadioGroup,
        name: name,
        required: required,
        disabled: disabled,
        value: value,
        onValueChange: setValue
    }, /*#__PURE__*/ $8Wolv$createElement($8Wolv$Root, $8Wolv$babelruntimehelpersesmextends({
        asChild: true
    }, rovingFocusGroupScope, {
        orientation: orientation,
        dir: direction,
        loop: loop
    }), /*#__PURE__*/ $8Wolv$createElement($8Wolv$Primitive.div, $8Wolv$babelruntimehelpersesmextends({
        role: "radiogroup",
        "aria-required": required,
        "aria-orientation": orientation,
        "data-disabled": disabled ? '' : undefined,
        dir: direction
    }, groupProps, {
        ref: forwardedRef
    }))));
});
/*#__PURE__*/ Object.assign($f99a8c78507165f7$export$a98f0dcb43a68a25, {
    displayName: $f99a8c78507165f7$var$RADIO_GROUP_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioGroupItem
 * -----------------------------------------------------------------------------------------------*/ const $f99a8c78507165f7$var$ITEM_NAME = 'RadioGroupItem';
const $f99a8c78507165f7$export$9f866c100ef519e4 = /*#__PURE__*/ $8Wolv$forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , disabled: disabled , ...itemProps } = props;
    const context = $f99a8c78507165f7$var$useRadioGroupContext($f99a8c78507165f7$var$ITEM_NAME, __scopeRadioGroup);
    const isDisabled = context.disabled || disabled;
    const rovingFocusGroupScope = $f99a8c78507165f7$var$useRovingFocusGroupScope(__scopeRadioGroup);
    const radioScope = $f99a8c78507165f7$var$useRadioScope(__scopeRadioGroup);
    const ref = $8Wolv$useRef(null);
    const composedRefs = $8Wolv$useComposedRefs(forwardedRef, ref);
    const checked = context.value === itemProps.value;
    const isArrowKeyPressedRef = $8Wolv$useRef(false);
    $8Wolv$useEffect(()=>{
        const handleKeyDown = (event)=>{
            if ($f99a8c78507165f7$var$ARROW_KEYS.includes(event.key)) isArrowKeyPressedRef.current = true;
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
    return /*#__PURE__*/ $8Wolv$createElement($8Wolv$Item, $8Wolv$babelruntimehelpersesmextends({
        asChild: true
    }, rovingFocusGroupScope, {
        focusable: !isDisabled,
        active: checked
    }), /*#__PURE__*/ $8Wolv$createElement($ce77a8961b41be9e$export$d7b12c4107be0d61, $8Wolv$babelruntimehelpersesmextends({
        disabled: isDisabled,
        required: context.required,
        checked: checked
    }, radioScope, itemProps, {
        name: context.name,
        ref: composedRefs,
        onCheck: ()=>context.onValueChange(itemProps.value)
        ,
        onKeyDown: $8Wolv$composeEventHandlers((event)=>{
            // According to WAI ARIA, radio groups don't activate items on enter keypress
            if (event.key === 'Enter') event.preventDefault();
        }),
        onFocus: $8Wolv$composeEventHandlers(itemProps.onFocus, ()=>{
            var _ref$current;
            /**
       * Our `RovingFocusGroup` will focus the radio when navigating with arrow keys
       * and we need to "check" it in that case. We click it to "check" it (instead
       * of updating `context.value`) so that the radio change event fires.
       */ if (isArrowKeyPressedRef.current) (_ref$current = ref.current) === null || _ref$current === void 0 || _ref$current.click();
        })
    })));
});
/*#__PURE__*/ Object.assign($f99a8c78507165f7$export$9f866c100ef519e4, {
    displayName: $f99a8c78507165f7$var$ITEM_NAME
});
/* -------------------------------------------------------------------------------------------------
 * RadioGroupIndicator
 * -----------------------------------------------------------------------------------------------*/ const $f99a8c78507165f7$var$INDICATOR_NAME = 'RadioGroupIndicator';
const $f99a8c78507165f7$export$5fb54c671a65c88 = /*#__PURE__*/ $8Wolv$forwardRef((props, forwardedRef)=>{
    const { __scopeRadioGroup: __scopeRadioGroup , ...indicatorProps } = props;
    const radioScope = $f99a8c78507165f7$var$useRadioScope(__scopeRadioGroup);
    return /*#__PURE__*/ $8Wolv$createElement($ce77a8961b41be9e$export$d35a9ffa9a04f9e7, $8Wolv$babelruntimehelpersesmextends({}, radioScope, indicatorProps, {
        ref: forwardedRef
    }));
});
/*#__PURE__*/ Object.assign($f99a8c78507165f7$export$5fb54c671a65c88, {
    displayName: $f99a8c78507165f7$var$INDICATOR_NAME
});
/* ---------------------------------------------------------------------------------------------- */ const $f99a8c78507165f7$export$be92b6f5f03c0fe9 = $f99a8c78507165f7$export$a98f0dcb43a68a25;
const $f99a8c78507165f7$export$6d08773d2e66f8f2 = $f99a8c78507165f7$export$9f866c100ef519e4;
const $f99a8c78507165f7$export$adb584737d712b70 = $f99a8c78507165f7$export$5fb54c671a65c88;




export {$f99a8c78507165f7$export$c547093f11b76da2 as createRadioGroupScope, $f99a8c78507165f7$export$a98f0dcb43a68a25 as RadioGroup, $f99a8c78507165f7$export$9f866c100ef519e4 as RadioGroupItem, $f99a8c78507165f7$export$5fb54c671a65c88 as RadioGroupIndicator, $f99a8c78507165f7$export$be92b6f5f03c0fe9 as Root, $f99a8c78507165f7$export$6d08773d2e66f8f2 as Item, $f99a8c78507165f7$export$adb584737d712b70 as Indicator};
//# sourceMappingURL=index.mjs.map
