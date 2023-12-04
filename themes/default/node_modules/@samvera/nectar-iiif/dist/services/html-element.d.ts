/// <reference types="react" />
declare function createMarkup(html: string): {
    __html: string;
};
declare function sanitizeAttributes(props: any, remove: string[]): import("react").HTMLAttributes<HTMLElement>;
declare function sanitizeHTML(html: string): string;
export { createMarkup, sanitizeAttributes, sanitizeHTML };
