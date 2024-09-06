import type { W3CSelector } from '@annotorious/core';
import type { Rectangle, RectangleGeometry } from '../../core';
export interface FragmentSelector extends W3CSelector {
    type: 'FragmentSelector';
    conformsTo: 'http://www.w3.org/TR/media-frags/';
    value: string;
}
export declare const parseFragmentSelector: (fragmentOrSelector: FragmentSelector | string, invertY?: boolean) => Rectangle;
export declare const serializeFragmentSelector: (geometry: RectangleGeometry) => FragmentSelector;
//# sourceMappingURL=FragmentSelector.d.ts.map