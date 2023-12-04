import { Annotation, AnnotationPageNormalized, Canvas, CanvasNormalized, ExternalResourceTypes } from "@iiif/presentation-3";
export interface CanvasEntity {
    canvas: CanvasNormalized | undefined;
    accompanyingCanvas: Canvas | undefined;
    annotationPage: AnnotationPageNormalized | undefined;
    annotations: Array<Annotation | undefined>;
}
export declare const getCanvasByCriteria: (vault: any, item: Canvas, motivation: string, paintingType: Array<ExternalResourceTypes>) => CanvasEntity;
