import React from "react";
interface Props {
    handleCanvasToggle: (arg0: -1 | 1) => void;
    handleFilter: (arg0: String) => void;
    activeIndex: number;
    canvasLength: number;
}
declare const Controls: React.FC<Props>;
export default Controls;
