import { LanguageProperty, OmitProperties, OneOrMany } from '../utility';
import { AnnotationList } from './annotation-list';
import { LinkingProperties } from '../iiif/linking';

/**
 * An ordered list of annotation lists. Layers allow higher level groupings of annotations to be recorded. For example,
 * all of the English translation annotations of a medieval French document could be kept separate from the
 * transcription or an edition in modern French.
 */
export declare type Layer = OmitProperties<LinkingProperties, 'startCanvas'> & {
  '@id': string;
  '@type': 'sc:Layer';
  label?: OneOrMany<LanguageProperty>;
  otherContent?: AnnotationList[];
};
