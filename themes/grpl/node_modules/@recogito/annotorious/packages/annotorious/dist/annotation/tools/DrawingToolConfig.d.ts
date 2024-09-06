import type { SvelteComponent } from 'svelte';
export interface ToolConfig {
    component: typeof SvelteComponent;
    opts?: {
        [key: string]: any;
    };
}
//# sourceMappingURL=DrawingToolConfig.d.ts.map