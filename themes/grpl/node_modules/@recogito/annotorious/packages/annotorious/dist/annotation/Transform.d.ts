export interface Transform {
    elementToImage: (offsetX: number, offsetY: number) => [number, number];
}
export declare const IdentityTransform: Transform;
export declare const createSVGTransform: (svg: SVGSVGElement) => Transform;
//# sourceMappingURL=Transform.d.ts.map