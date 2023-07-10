import React from 'react';
import Thumbs from '../Thumbs';
import { CarouselProps, CarouselState } from './types';
export default class Carousel extends React.Component<CarouselProps, CarouselState> {
    private thumbsRef?;
    private carouselWrapperRef?;
    private listRef?;
    private itemsRef?;
    private timer?;
    private animationHandler;
    static displayName: string;
    static defaultProps: CarouselProps;
    constructor(props: CarouselProps);
    componentDidMount(): void;
    componentDidUpdate(prevProps: CarouselProps, prevState: CarouselState): void;
    componentWillUnmount(): void;
    setThumbsRef: (node: Thumbs) => void;
    setCarouselWrapperRef: (node: HTMLDivElement) => void;
    setListRef: (node: HTMLElement | HTMLUListElement) => void;
    setItemsRef: (node: HTMLElement, index: number) => void;
    setupCarousel(): void;
    destroyCarousel(): void;
    setupAutoPlay(): void;
    destroyAutoPlay(): void;
    bindEvents(): void;
    unbindEvents(): void;
    autoPlay: () => void;
    clearAutoPlay: () => void;
    resetAutoPlay: () => void;
    stopOnHover: () => void;
    startOnLeave: () => void;
    forceFocus(): void;
    isFocusWithinTheCarousel: () => boolean;
    navigateWithKeyboard: (e: KeyboardEvent) => void;
    updateSizes: () => void;
    setMountState: () => void;
    handleClickItem: (index: number, item: React.ReactNode) => void;
    /**
     * On Change handler, Passes the index and React node to the supplied onChange prop
     * @param index of the carousel item
     * @param item React node of the item being changed
     */
    handleOnChange: (index: number, item: React.ReactNode) => void;
    handleClickThumb: (index: number, item: React.ReactNode) => void;
    onSwipeStart: (event: React.TouchEvent) => void;
    onSwipeEnd: (event: React.TouchEvent) => void;
    onSwipeMove: (delta: {
        x: number;
        y: number;
    }, event: React.TouchEvent) => boolean;
    /**
     * Decrements the selectedItem index a number of positions through the children list
     * @param positions
     * @param fromSwipe
     */
    decrement: (positions?: number) => void;
    /**
     * Increments the selectedItem index a number of positions through the children list
     * @param positions
     * @param fromSwipe
     */
    increment: (positions?: number) => void;
    /**
     * Moves the selected item to the position provided
     * @param position
     * @param fromSwipe
     */
    moveTo: (position?: number | undefined) => void;
    onClickNext: () => void;
    onClickPrev: () => void;
    onSwipeForward: () => void;
    onSwipeBackwards: () => void;
    changeItem: (newIndex: number) => (e: React.MouseEvent | React.KeyboardEvent) => void;
    /**
     * This function is called when you want to 'select' a new item, or rather move to a 'selected' item
     * It also handles the onChange callback wrapper
     * @param state state object with updated selected item, and swiping bool if relevant
     */
    selectItem: (state: Pick<CarouselState, 'selectedItem' | 'swiping'>) => void;
    getInitialImage: () => HTMLImageElement;
    getVariableItemHeight: (position: number) => number | null;
    renderItems(isClone?: boolean): JSX.Element[];
    renderControls(): JSX.Element | null;
    renderStatus(): JSX.Element | null;
    renderThumbs(): JSX.Element | null;
    render(): JSX.Element | null;
}
//# sourceMappingURL=index.d.ts.map