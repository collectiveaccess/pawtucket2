import React from "react";
import "@recogito/annotorious-openseadragon/dist/annotorious.min.css";
import { type Plugin } from "@samvera/clover-iiif";
interface PropType extends Plugin {
    token?: string;
    annotationServer?: string;
}
declare const AnnotationEditor: React.FC<PropType>;
export default AnnotationEditor;
