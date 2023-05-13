import React, { FC } from "react";
import { ScrollConfig } from "./ScrollSyncNode";
export interface ScrollSyncProps {
    children: React.ReactNode;
    /**syncing enable control */
    disabled?: boolean;
    /** In case we want scroll to be proportionally applied regardless of the width and/or height*/
    proportional?: boolean;
}
/**
 * node should be scrollable
 */
declare type Node = (EventTarget & HTMLElement) | null;
/**
 * node should be scrollable
 */
interface SyncableElement {
    node: Node;
    scroll: ScrollConfig;
}
interface ScrollingSyncerContextValues {
    /**
     * register node to be synced with other scrolled nodes
     */
    registerNode: (node: SyncableElement, groups: string[]) => void;
    /**
     * unregister node to stop syncing with other scrolled nodes
     */
    unregisterNode: (node: SyncableElement, group: string[]) => void;
    /**
     * scroll handler for each node.onScroll
     */
    onScroll: (e: React.UIEvent<HTMLElement>, groups: string[]) => void;
}
/**
 * ScrollingSyncerContext is the context to be handling scrolled nodes
 */
export declare const ScrollingSyncerContext: React.Context<ScrollingSyncerContextValues>;
/**
 * ScrollSync component is a context based component,
 * that wrappes children to be .Provided with context utils and eventsHandlers
 * @param props ScrollSyncProps
 */
export declare const ScrollSync: FC<ScrollSyncProps>;
export default ScrollSync;
