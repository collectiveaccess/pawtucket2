import { OmitProperties } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { LinkingProperties } from '../iiif/linking';
import { Annotation } from './annotation';
import { AnnotationList } from './annotation-list';
import { RightsProperties } from '../iiif/rights';

type CanvasOmittedTechnical = 'format' | 'viewingDirection' | 'navDate';
type CanvasOmittedLinking = 'startCanvas';

type CanvasStructural = {
  images: Annotation[];
  otherContent?: Array<AnnotationList>;
};

/**
 * A virtual container that represents a page or view and has content resources associated with it or with parts of it.
 * The canvas provides a frame of reference for the layout of the content. The concept of a canvas is borrowed from
 * standards like PDF and HTML, or applications like Photoshop and Powerpoint, where the display starts from a blank
 * canvas and images, text and other resources are “painted” on to it.
 */
export interface Canvas
  extends OmitProperties<TechnicalProperties, CanvasOmittedTechnical>,
    DescriptiveProperties,
    RightsProperties,
    CanvasStructural,
    Partial<OmitProperties<LinkingProperties, CanvasOmittedLinking>> {}
