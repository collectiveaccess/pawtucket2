import { OmitProperties, OneOrMany } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { LinkingProperties } from '../iiif/linking';
import { ContentResource, ContentResourceSelector } from './content-resource';
import { RightsProperties } from '../iiif/rights';

type AnnotationOmittedTechnical = '@id' | 'format' | 'height' | 'width' | 'viewingDirection' | 'navDate';
type AnnotationOmittedLinking = 'startCanvas';

type AnnotationStructural = {
  motivation: OneOrMany<string>;
  resource: OneOrMany<ContentResource>;
  stylesheet?: {
    '@type': ['oa:CssStyle', 'cnt:ContentAsText'];
    chars: string;
  };
  on: OneOrMany<string | { '@id': string } | SpecificResource>; // @todo maybe need to expand this.
};

export declare type SpecificResource = {
  '@type': 'oa:SpecificResource',
  full: string | ContentResource,
  selector: ContentResourceSelector,
};

/**
 * Content resources and commentary are associated with a canvas via an annotation. This provides a single, coherent
 * method for aligning information, and provides a standards based framework for distinguishing parts of resources and
 * parts of canvases. As annotations can be added later, it promotes a distributed system in which publishers can align
 * their content with the descriptions created by others.
 */
export interface Annotation
  extends OmitProperties<TechnicalProperties, AnnotationOmittedTechnical>,
    DescriptiveProperties,
    RightsProperties,
    AnnotationStructural,
    OmitProperties<LinkingProperties, AnnotationOmittedLinking> {
  '@id'?: string;
}
