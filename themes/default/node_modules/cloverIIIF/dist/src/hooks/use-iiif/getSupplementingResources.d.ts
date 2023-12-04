import { InternationalString } from "@iiif/presentation-3";
export interface LabeledResource {
    id?: string;
    type: "Dataset" | "Image" | "Video" | "Sound" | "Text";
    format?: string;
    label: InternationalString;
    language?: string | string[];
    processingLanguage?: string;
    textDirection?: "ltr" | "rtl" | "auto";
}
export declare const getSupplementingResources: (vault: any, activeCanvas: string, format: string) => Array<LabeledResource>;
