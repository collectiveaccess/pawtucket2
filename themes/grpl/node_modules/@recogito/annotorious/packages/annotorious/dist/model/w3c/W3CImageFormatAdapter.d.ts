import type { FormatAdapter, ParseResult, W3CAnnotation } from '@annotorious/core';
import type { ImageAnnotation } from '../core';
export type W3CImageFormatAdapter = FormatAdapter<ImageAnnotation, W3CAnnotation>;
export declare const W3CImageFormat: (source: string, invertY?: boolean) => W3CImageFormatAdapter;
export declare const parseW3CImageAnnotation: (annotation: W3CAnnotation, invertY?: boolean) => ParseResult<ImageAnnotation>;
export declare const serializeW3CImageAnnotation: (annotation: ImageAnnotation, source: string) => W3CAnnotation;
//# sourceMappingURL=W3CImageFormatAdapter.d.ts.map