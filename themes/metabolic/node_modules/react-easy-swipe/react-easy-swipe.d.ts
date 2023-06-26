/* eslint-disable */
import * as React from 'react';

export interface SwipePosition {
  x: number;
  y: number;
}

export type SwipeEvent = React.TouchEvent | React.MouseEvent;

interface SwipeProps {
  tagName?: string;
  className?: string;
  style?: React.CSSProperties;  
  allowMouseEvents?: boolean;
  onSwipeUp?: (trigger: 1) => void;
  onSwipeDown?: (trigger: 1) => void;
  onSwipeLeft?: (trigger: 1) => void;
  onSwipeRight?: (trigger: 1) => void;
  onSwipeStart?: (e: SwipeEvent) => void;
  onSwipeMove?: (position: SwipePosition, e: SwipeEvent) => void;
  onSwipeEnd?: (e: SwipeEvent) => void;
  innerRef: (node: any) => void;
  tolerance?: number
}

export default class Swipe extends React.Component<SwipeProps> {}
