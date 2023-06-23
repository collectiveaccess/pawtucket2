/// <reference types="react" />
import { Options } from 'react-overlays/usePopper';
export default function useOverlayOffset(): [
    React.RefObject<HTMLElement>,
    Options['modifiers']
];
