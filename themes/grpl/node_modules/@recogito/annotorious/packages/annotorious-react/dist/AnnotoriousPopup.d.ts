import { ReactNode } from 'react';
import { ImageAnnotation } from '@annotorious/annotorious';
export interface AnnotoriousPopupProps {
    selected: {
        annotation: ImageAnnotation;
        editable?: boolean;
    }[];
}
export interface DraggableProps {
    children: ReactNode;
    className?: string;
    onDragStart?(): void;
    onDragEnd?(): void;
}
export declare const Draggable: import("react").ForwardRefExoticComponent<DraggableProps & import("react").RefAttributes<HTMLDivElement>>;
//# sourceMappingURL=AnnotoriousPopup.d.ts.map