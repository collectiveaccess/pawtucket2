import type { ImageAnnotation } from '../model';
import type { AnnotoriousOpts } from '../AnnotoriousOpts';
import { type AnnotatorState, type HoverState, type SelectionState } from '@annotorious/core';
import type { ImageAnnotationStore, SvelteImageAnnotatorState } from './ImageAnnotationStore';
export type ImageAnnotatorState<T extends ImageAnnotationStore = ImageAnnotationStore> = AnnotatorState<ImageAnnotation> & {
    store: T;
    selection: SelectionState<ImageAnnotation>;
    hover: HoverState<ImageAnnotation>;
};
export declare const createImageAnnotatorState: <E extends unknown>(opts: AnnotoriousOpts<ImageAnnotation, E>) => ImageAnnotatorState<ImageAnnotationStore>;
export declare const createSvelteImageAnnotatorState: <E extends unknown>(opts: AnnotoriousOpts<ImageAnnotation, E>) => SvelteImageAnnotatorState;
//# sourceMappingURL=ImageAnnotatorState.d.ts.map