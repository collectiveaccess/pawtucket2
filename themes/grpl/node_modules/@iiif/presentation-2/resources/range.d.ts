import { OmitProperties } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { LinkingProperties } from '../iiif/linking';
import { RightsProperties } from '../iiif/rights';

type RangeOmittedTechnical = 'format' | 'viewingDirection' | 'navDate';
type RangeOmittedLinking = 'startCanvas';

type RangeStructural = {
  canvases?: string[];
  ranges?: string[];
  members?: Array<
    | {
        '@id': string;
        '@type': 'sc:Canvas';
        label: string;
        contentLayer?: string;
      }
    | {
        '@id': string;
        '@type': 'sc:Range';
        label: string;
        contentLayer?: string;
      }
  >;
};

/**
 * A virtual container that represents a page or view and has content resources associated with it or with parts of it.
 * The canvas provides a frame of reference for the layout of the content. The concept of a canvas is borrowed from
 * standards like PDF and HTML, or applications like Photoshop and Powerpoint, where the display starts from a blank
 * canvas and images, text and other resources are “painted” on to it.
 */
export interface Range
  extends OmitProperties<TechnicalProperties, RangeOmittedTechnical>,
    DescriptiveProperties,
    RightsProperties,
    RangeStructural,
    Partial<OmitProperties<LinkingProperties, RangeOmittedLinking>> {}
