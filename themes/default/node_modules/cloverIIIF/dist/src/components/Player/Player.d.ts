import React from "react";
import { IIIFExternalWebResource } from "@iiif/presentation-3";
import { LabeledResource } from "@/hooks/use-iiif/getSupplementingResources";
interface PlayerProps {
    painting: IIIFExternalWebResource;
    resources: LabeledResource[];
}
declare const Player: React.FC<PlayerProps>;
export default Player;
