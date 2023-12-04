import React from "react";
import { LabeledResource } from "@/hooks/use-iiif/getSupplementingResources";
export interface TrackProps {
    resource: LabeledResource;
    ignoreCaptionLabels: string[];
}
declare const Track: React.FC<TrackProps>;
export default Track;
