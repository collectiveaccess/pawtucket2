import { OmitProperties } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { Canvas } from './canvas';
import { LinkingProperties } from '../iiif/linking';
import { RightsProperties } from '../iiif/rights';

type SequenceTechnical = OmitProperties<TechnicalProperties, '@id' | 'format' | 'height' | 'width' | 'navDate'>;
type SequenceStructural = {
  /**
   * the set of pages in the object, represented by canvas resources, are listed in order in the canvases property.
   * There must be at least one canvas given.
   */
  canvases: Canvas[];
};

/**
 * The sequence conveys the ordering of the views of the object. The default sequence (and typically the only sequence)
 * must be embedded within the {@link Manifest manifest}, and may also be available from its own URI. The default
 * sequence may have a URI to identify it. Any additional sequences must be referred to from the manifest, not embedded
 * within it, and thus these additional sequences must have an HTTP URI.
 *
 * The {name} parameter in the URI structure must distinguish it from any other sequences that may be available for the
 * physical object. Typical default names for sequences are “normal” or “basic”.
 *
 * Sequences may have their own descriptive, rights and linking metadata using the same fields as for manifests. The
 * label property may be given for sequences and must be given if there is more than one referenced from a manifest.
 * After the metadata, the set of pages in the object, represented by {@link Canvas canvas} resources, are listed in
 * order in the canvases property. There must be at least one canvas given.
 *
 * Sequences may have a startCanvas with a single value containing the URI of a canvas resource that is contained
 * within the sequence. This is the canvas that a viewer should initialize its display with for the user. If it is not
 * present, then the viewer should use the first canvas in the sequence.
 *
 * In the manifest example above, the sequence is referenced by its URI and contains only the basic information of
 * label, @type and @id. The default sequence should be written out in full within the manifest file, as below but
 * must not have the @context property.
 */
export declare interface Sequence
  extends SequenceTechnical,
    DescriptiveProperties,
    RightsProperties,
    SequenceStructural,
    LinkingProperties {
  '@id'?: string;
}
