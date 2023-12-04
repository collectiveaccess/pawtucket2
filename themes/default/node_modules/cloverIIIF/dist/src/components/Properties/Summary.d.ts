import { InternationalString } from "@iiif/presentation-3";
import React from "react";
interface PropertiesSummaryProps {
    summary: InternationalString | null;
    parent?: "manifest" | "canvas";
}
declare const PropertiesSummary: React.FC<PropertiesSummaryProps>;
export default PropertiesSummary;
