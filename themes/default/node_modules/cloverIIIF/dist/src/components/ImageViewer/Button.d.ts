import React from "react";
interface ButtonProps {
    id: string;
    label: string;
    children: React.ReactChild;
}
declare const Button: React.FC<ButtonProps>;
export default Button;
