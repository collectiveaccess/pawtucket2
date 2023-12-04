import { MetadataItem } from "@iiif/presentation-3";
import React from "react";
interface PropertiesMetadataProps {
    metadata: MetadataItem[] | null;
    parent?: "manifest" | "canvas";
}
declare const PropertiesMetadata: React.FC<PropertiesMetadataProps>;
export default PropertiesMetadata;
