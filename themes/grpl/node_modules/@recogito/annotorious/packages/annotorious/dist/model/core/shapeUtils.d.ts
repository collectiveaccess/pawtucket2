import type { Bounds, Shape, ShapeType } from './Shape';
export interface ShapeUtil<T extends Shape> {
    area: (shape: T) => number;
    intersects: (shape: T, x: number, y: number) => boolean;
}
/**
 * Registers a new ShapeUtil for a given shape type.
 * @param type the shape type
 * @param util the ShapeUtil implementation for this shape type
 */
export declare const registerShapeUtil: (type: ShapeType | string, util: ShapeUtil<any>) => ShapeUtil<any>;
/**
 * Computes the area of the given shape. Delegates to the corresponding ShapeUtil.
 * @param shape the shape
 */
export declare const computeArea: (shape: Shape) => number;
/**
 * Tests if the given shape intersects the given point. Delegates to
 * the corresponding ShapeUtil.
 * @param shape the shape
 * @param x point x coord
 * @param y point y coord
 * @returns true if shape and point intersect
 */
export declare const intersects: (shape: Shape, x: number, y: number) => boolean;
/**
 * Computes Bounds from a given list of points.
 * @param points the points
 * @returns the Bounds
 */
export declare const boundsFromPoints: (points: Array<[
    number,
    number
]>) => Bounds;
//# sourceMappingURL=shapeUtils.d.ts.map