import type { W3CSelector } from '@annotorious/core';
import type { Shape } from '../../core';
export interface SVGSelector extends W3CSelector {
    type: 'SvgSelector';
    value: string;
}
export declare const parseSVGSelector: <T extends Shape>(valueOrSelector: SVGSelector | string) => T;
export declare const serializeSVGSelector: (shape: Shape) => SVGSelector;
//# sourceMappingURL=SVGSelector.d.ts.map