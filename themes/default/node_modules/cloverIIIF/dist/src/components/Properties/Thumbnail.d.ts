import { IIIFExternalWebResource, InternationalString } from "@iiif/presentation-3";
import React from "react";
interface PropertiesThumbnailProps {
    label: InternationalString | null;
    thumbnail: IIIFExternalWebResource[];
}
declare const PropertiesThumbnail: React.FC<PropertiesThumbnailProps>;
export default PropertiesThumbnail;
