import React from "react";
import { InternationalString } from "@iiif/presentation-3";
interface Props {
    manifestId: string;
    manifestLabel: InternationalString;
}
declare const ViewerHeader: React.FC<Props>;
export default ViewerHeader;
