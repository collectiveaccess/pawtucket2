import { OmitProperties } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { LinkingProperties } from '../iiif/linking';
import { PagingProperties } from '../iiif/paging';
import { Annotation } from './annotation';
import { RightsProperties } from '../iiif/rights';

type AnnotationListOmittedTechnical = 'format' | 'height' | 'width' | 'viewingDirection' | 'navDate';
type AnnotationListOmittedLinking = 'startCanvas';
type AnnotationListOmittedPaging = 'first' | 'last' | 'total';

type AnnotationListStructural = {
  resources: Annotation[];
};

/**
 * Content resources and commentary are associated with a canvas via an annotation. This provides a single, coherent
 * method for aligning information, and provides a standards based framework for distinguishing parts of resources and
 * parts of canvases. As annotations can be added later, it promotes a distributed system in which publishers can align
 * their content with the descriptions created by others.
 */
export interface AnnotationList
  extends OmitProperties<TechnicalProperties, AnnotationListOmittedTechnical>,
    DescriptiveProperties,
    RightsProperties,
    AnnotationListStructural,
    OmitProperties<PagingProperties, AnnotationListOmittedPaging>,
    OmitProperties<LinkingProperties, AnnotationListOmittedLinking> {}
