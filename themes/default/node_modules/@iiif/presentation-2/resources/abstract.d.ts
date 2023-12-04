import { LinkingProperties } from '../iiif/linking';
import { DescriptiveProperties } from '../iiif/descriptive';
import { PagingProperties } from '../iiif/paging';
import { RightsProperties } from '../iiif/rights';
import { TechnicalProperties } from '../iiif/technical';
import { AnnotationStructural } from './annotation';
import { AnnotationListStructural } from './annotation-list';
import { CanvasStructural } from './canvas';
import { CollectionStructural } from './collection';
import { ManifestStructural } from './manifest';
import { RangeStructural } from './range';
import { SequenceStructural } from './sequence';

export type AbstractResource = Partial<
  DescriptiveProperties &
    LinkingProperties &
    PagingProperties &
    RightsProperties &
    TechnicalProperties &
    AnnotationStructural &
    AnnotationListStructural &
    CanvasStructural &
    CollectionStructural &
    ManifestStructural &
    RangeStructural &
    SequenceStructural
>;
