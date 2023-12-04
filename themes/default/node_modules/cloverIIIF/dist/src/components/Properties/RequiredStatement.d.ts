import { MetadataItem } from "@iiif/presentation-3";
import React from "react";
interface PropertiesSummaryProps {
    requiredStatement: MetadataItem | null;
    parent?: "manifest" | "canvas";
}
declare const PropertiesRequiredStatement: React.FC<PropertiesSummaryProps>;
export default PropertiesRequiredStatement;
