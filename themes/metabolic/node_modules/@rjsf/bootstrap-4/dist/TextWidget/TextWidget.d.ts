import { WidgetProps } from "@rjsf/core";
export interface TextWidgetProps extends WidgetProps {
    type?: string;
}
declare const TextWidget: ({ id, placeholder, required, readonly, disabled, type, label, value, onChange, onBlur, onFocus, autofocus, options, schema, rawErrors, }: TextWidgetProps) => JSX.Element;
export default TextWidget;
