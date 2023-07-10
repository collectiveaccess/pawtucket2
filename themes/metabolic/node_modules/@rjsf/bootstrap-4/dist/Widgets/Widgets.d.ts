/// <reference types="@rjsf/core" />
declare const _default: {
    CheckboxWidget: (props: import("@rjsf/core").WidgetProps) => JSX.Element;
    CheckboxesWidget: ({ schema, label, id, disabled, options, value, autofocus, readonly, required, onChange, onBlur, onFocus, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    ColorWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    DateWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    DateTimeWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    EmailWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    PasswordWidget: ({ id, required, readonly, disabled, value, label, onFocus, onBlur, onChange, options, autofocus, schema, rawErrors, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    RadioWidget: ({ id, schema, options, value, required, disabled, readonly, label, onChange, onBlur, onFocus, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    RangeWidget: ({ value, readonly, disabled, onBlur, onFocus, options, schema, onChange, required, label, id, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    SelectWidget: ({ schema, id, options, label, required, disabled, readonly, value, multiple, autofocus, onChange, onBlur, onFocus, placeholder, rawErrors, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    TextareaWidget: ({ id, placeholder, value, required, disabled, autofocus, label, readonly, onBlur, onFocus, onChange, options, schema, rawErrors, }: import("@rjsf/core").WidgetProps & {
        options: any;
    }) => JSX.Element;
    TextWidget: ({ id, placeholder, required, readonly, disabled, type, label, value, onChange, onBlur, onFocus, autofocus, options, schema, rawErrors, }: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    UpDownWidget: ({ id, required, readonly, disabled, label, value, onChange, onBlur, onFocus, autofocus, }: import("@rjsf/core").WidgetProps) => JSX.Element;
    URLWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
    FileWidget: (props: import("../TextWidget/TextWidget").TextWidgetProps) => JSX.Element;
};
export default _default;
