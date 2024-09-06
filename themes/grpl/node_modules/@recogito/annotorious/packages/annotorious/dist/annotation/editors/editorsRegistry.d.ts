import { ShapeType, type Shape } from '../../model';
import type { SvelteComponent } from 'svelte';
export declare const getEditor: (shape: Shape) => typeof SvelteComponent;
export declare const registerEditor: (shapeType: ShapeType, editor: typeof SvelteComponent) => Map<ShapeType, typeof SvelteComponent>;
//# sourceMappingURL=editorsRegistry.d.ts.map