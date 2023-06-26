import React from "react";
/**
 * ScrollSyncNode Component
 *
 * Wrap your content in it to keep its scroll position in sync with other panes
 */
export declare type ScrollConfig = "synced-only" | "syncer-only" | "two-way";
export declare type LockAxis = "X" | "Y" | "XY" | null;
interface ScrollSyncNodeProps {
    /**
     * Children
     */
    children: React.ReactElement;
    /**
     * Groups to make the children attached to
     */
    group?: string | string[];
    /**
     * If the scrolling is enabled or not
     */
    scroll?: ScrollConfig;
    /**
     * Prevent scroll on current node if axis is locked
     */
    selfLockAxis?: LockAxis;
    /**
     * Callback for scroll handling
     */
    onScroll?: (e: React.UIEvent<HTMLElement>) => void;
}
declare const ScrollSyncNode: React.ForwardRefExoticComponent<ScrollSyncNodeProps & React.RefAttributes<EventTarget & HTMLElement>>;
export default ScrollSyncNode;
