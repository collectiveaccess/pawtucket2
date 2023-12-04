import React from "react";
import { CanvasNormalized, IIIFExternalWebResource } from "@iiif/presentation-3";
/**
 * Render thumbnail for IIIF canvas item
 */
export interface ThumbnailProps {
    canvas: CanvasNormalized;
    canvasIndex: number;
    isActive: boolean;
    thumbnail?: IIIFExternalWebResource;
    type: string;
    handleChange: (arg0: string) => void;
}
declare const Thumbnail: React.FC<ThumbnailProps>;
export default Thumbnail;
