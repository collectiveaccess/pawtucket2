import type { SvelteImageAnnotationStore } from '../state';
import type { ImageAnnotation } from '../model';
export interface SVGAnnotationLayerPointerEvent {
    originalEvent: PointerEvent;
    annotation?: ImageAnnotation;
}
export declare const addEventListeners: (svg: SVGSVGElement, store: SvelteImageAnnotationStore) => {
    onPointerDown: () => number;
    onPointerUp: (evt: PointerEvent) => void;
};
//# sourceMappingURL=SVGAnnotationLayerPointerEvent.d.ts.map