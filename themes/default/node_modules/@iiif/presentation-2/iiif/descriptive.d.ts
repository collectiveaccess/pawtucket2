import { LanguageProperty, OneOrMany } from '../utility';
import { ImageResourceSegment, ImageResourceSegmentWithService } from '../resources/content-resource';

export declare type DescriptiveProperties = {
  /**
   * A human readable label, name or title for the resource. This property is intended to be displayed as a short,
   * textual surrogate for the resource if a human needs to make a distinction between it and similar resources,
   * for example between pages or between a choice of images to display.
   *
   * - A {@link Collection} must have at least one label.
   * - A {@link Manifest} must have at least one label, such as the name of the object or title of the intellectual work that
   *   it embodies.
   * - A {@link Sequence} may have one or more labels, and if there are multiple sequences in a single manifest then they must
   *   each have at least one label.
   * - A {@link Canvas} must have at least one label, such as the page number or short description of the view.
   * - A content resource may have one or more labels, and if there is a choice of content resource for the same canvas,
   *   then they should each have at least one label.
   * - A {@link Range} must have at least one label.
   * - A {@link Layer} must have at least one label.
   * - Other resource types may have labels.
   *
   */
  label?: OneOrMany<LanguageProperty>;

  /**
   * A list of short descriptive entries, given as pairs of human readable label and value to be displayed to the user.
   * The value should be either simple HTML, including links and text markup, or plain text, and the label should be
   * plain text. There are no semantics conveyed by this information, and clients should not use it for discovery or
   * other purposes. This list of descriptive pairs should be able to be displayed in a tabular form in the user
   * interface. Clients should have a way to display the information about manifests and canvases, and may have a way
   * to view the information about other resources. The client should display the pairs in the order provided by the
   * description. A pair might be used to convey the author of the work, information about its creation, a brief
   * physical description, or ownership information, amongst other use cases. The client is not expected to take any
   * action on this information beyond displaying the label and value. An example pair of label and value might be a
   * label of “Author” and a value of “Jehan Froissart”.
   *
   * - A {@link Collection} should have one or more metadata pairs associated with it.
   * - A {@link Manifest} should have one or more metadata pairs associated with it describing the object or work.
   * - Other resource types may have one or more metadata pairs.
   */
  metadata?: Array<{ label: OneOrMany<LanguageProperty>; value: OneOrMany<LanguageProperty> }>;

  /**
   * A longer-form prose description of the object or resource that the property is attached to, intended to be
   * conveyed to the user as a full text description, rather than a simple label and value. It may be in simple HTML
   * or plain text. It can duplicate any of the information from the metadata fields, along with additional information
   * required to understand what is being displayed. Clients should have a way to display the descriptions of manifests
   * and canvases, and may have a way to view the information about other resources.
   *
   * - A {@link Collection} should have one or more descriptions.
   * - A {@link Manifest} should have one or more descriptions.
   * - Other resource types may have one or more description.
   */
  description?: OneOrMany<LanguageProperty>;

  /**
   * A small image that depicts or pictorially represents the resource that the property is attached to, such as the
   * title page, a significant image or rendering of a canvas with multiple content resources associated with it. It
   * is recommended that a IIIF Image API service be available for this image for manipulations such as resizing.
   * If a resource has multiple thumbnails, then each of them should be different.
   *
   * - A {@link Collection} should have exactly one thumbnail image, and may have more than one.
   * - A {@link Manifest} should have exactly one thumbnail image, and may have more than one.
   * - A {@link Sequence} may have one or more thumbnails and should have at least one thumbnail if there are multiple sequences
   *   in a single manifest.
   * - A {@link Canvas} may have one or more thumbnails and should have at least one thumbnail if there are multiple images or
   *   resources that make up the representation.
   * - A {@link ContentResource} may have one or more thumbnails and should have at least one thumbnail if it is an option in
   *   a choice of resources.
   * - Other resource types may have one or more thumbnails.
   */
  thumbnail?: OneOrMany<string | ImageResourceSegment | ImageResourceSegmentWithService>;
};
