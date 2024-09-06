import { Collection } from './resources/collection';
import { Manifest } from './resources/manifest';
import { Canvas } from './resources/canvas';
import { AnnotationList } from './resources/annotation-list';
import { Annotation } from './resources/annotation';
import { ChoiceEmbeddedContent, ContentResource } from './resources/content-resource';
import { Sequence } from './resources/sequence';
import { Service } from '@iiif/presentation-3';
import { Layer } from './resources/layer';
import { Range } from './resources/range';

export type Traversal<T> = (jsonLd: T) => Partial<T> | any;

export type TraversalMap = {
  collection?: Array<Traversal<Collection>>;
  manifest?: Array<Traversal<Manifest>>;
  canvas?: Array<Traversal<Canvas>>;
  annotationList?: Array<Traversal<AnnotationList>>;
  annotation?: Array<Traversal<Annotation>>;
  contentResource?: Array<Traversal<ContentResource>>;
  choice?: Array<Traversal<ChoiceEmbeddedContent>>;
  range?: Array<Traversal<Range>>;
  service?: Array<Traversal<Service>>;
  sequence?: Array<Traversal<Sequence>>;
  layer?: Array<Traversal<Layer>>;
};

export type TraversableEntityTypes =
  | 'sc:Collection'
  | 'sc:Manifest'
  | 'sc:Canvas'
  | 'sc:AnnotationList'
  | 'oa:Annotation'
  | 'sc:Range'
  | 'sc:Layer'
  | 'sc:Sequence'
  | 'oa:Choice'
  // Opaque.
  | 'Service'
  | 'ContentResource';
