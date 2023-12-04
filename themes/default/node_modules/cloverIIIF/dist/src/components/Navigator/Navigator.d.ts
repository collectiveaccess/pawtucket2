import React from "react";
import { LabeledResource } from "@/hooks/use-iiif/getSupplementingResources";
interface NavigatorProps {
    activeCanvas: string;
    resources?: Array<LabeledResource>;
}
export declare const Navigator: React.FC<NavigatorProps>;
export default Navigator;
