/// <reference types="react" />
import { CarouselProps } from './types';
export declare const noop: () => void;
export declare const defaultStatusFormatter: (current: number, total: number) => string;
export declare const isKeyboardEvent: (e?: import("react").MouseEvent<Element, MouseEvent> | import("react").KeyboardEvent<Element> | undefined) => e is import("react").KeyboardEvent<Element>;
/**
 * Gets the list 'position' relative to a current index
 * @param index
 */
export declare const getPosition: (index: number, props: CarouselProps) => number;
/**
 * Sets the 'position' transform for sliding animations
 * @param position
 * @param forceReflow
 */
export declare const setPosition: (position: number, axis: 'horizontal' | 'vertical') => React.CSSProperties;
//# sourceMappingURL=utils.d.ts.map