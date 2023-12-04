import React from "react";
import { Canvas } from "@iiif/presentation-3";
interface MediaProps {
    items: Canvas[];
    activeItem: number;
}
declare const Media: React.FC<MediaProps>;
export default Media;
