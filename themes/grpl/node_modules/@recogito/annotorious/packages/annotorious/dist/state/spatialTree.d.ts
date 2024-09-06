import type { ImageAnnotationTarget } from '../model';
interface IndexedTarget {
    minX: number;
    minY: number;
    maxX: number;
    maxY: number;
    target: ImageAnnotationTarget;
}
export declare const createSpatialTree: () => {
    all: () => IndexedTarget[];
    clear: () => void;
    getAt: (x: number, y: number) => ImageAnnotationTarget | null;
    getIntersecting: (x: number, y: number, width: number, height: number) => ImageAnnotationTarget[];
    insert: (target: ImageAnnotationTarget) => void;
    remove: (target: ImageAnnotationTarget) => void;
    set: (targets: ImageAnnotationTarget[], replace?: boolean) => void;
    size: () => number;
    update: (previous: ImageAnnotationTarget, updated: ImageAnnotationTarget) => void;
};
export {};
//# sourceMappingURL=spatialTree.d.ts.map