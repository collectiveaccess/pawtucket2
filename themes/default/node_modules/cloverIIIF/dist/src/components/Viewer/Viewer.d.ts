import React from "react";
import { ManifestNormalized } from "@iiif/presentation-3";
interface ViewerProps {
    manifest: ManifestNormalized;
    theme?: any;
}
declare const Viewer: React.FC<ViewerProps>;
export default Viewer;
