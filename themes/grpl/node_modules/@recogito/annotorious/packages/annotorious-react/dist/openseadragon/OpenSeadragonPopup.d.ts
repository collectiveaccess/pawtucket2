import { ReactNode } from 'react';
import OpenSeadragon from 'openseadragon';
import { AnnotoriousPopupProps } from '../AnnotoriousPopup';
export type OpenSeadragonPopupProps = AnnotoriousPopupProps & {
    viewer: OpenSeadragon.Viewer;
};
export type OpenSeadragonPopupContainerProps = {
    popup(props: OpenSeadragonPopupProps): ReactNode;
};
export declare const OpenSeadragonPopup: (props: OpenSeadragonPopupContainerProps) => import("react/jsx-runtime").JSX.Element;
//# sourceMappingURL=OpenSeadragonPopup.d.ts.map