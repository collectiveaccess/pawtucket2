import { ContentResource } from '../resources/content-resource';
import { OneOrMany } from '../utility';
import { Service } from '@iiif/presentation-3';
import { Canvas } from '../resources/canvas';
import { Layer } from '../resources/layer';

export declare type LinkingProperties = {
  /**
   * A link to an external resource intended to be displayed directly to the user, and is related to the resource that
   * has the related property. Examples might include a video or academic paper about the resource, a website, an HTML
   * description, and so forth. A label and the format of the related resource should be given to assist clients in
   * rendering the resource to the user.
   *
   * Any resource type may have one or more external resources related to it.
   */
  related?: OneOrMany<ContentResource>;

  /**
   * A link to an external resource intended for display or download by a human user. This property can be used to link
   * from a manifest, collection or other resource to the preferred viewing environment for that resource, such as a
   * viewer page on the publisher’s web site. Other uses include a rendering of a {@link Manifest} as a PDF or EPUB with the
   * images and text of the book, or a slide deck with images of the museum object. A label and the format of the
   * rendering resource must be supplied to allow clients to present the option to the user.
   *
   * - Any resource type may have one or more external rendering resources.
   */
  rendering?: OneOrMany<ContentResource>;

  /**
   * A link to a service that makes more functionality available for the resource, such as from an image to the base
   * URI of an associated IIIF Image API service. The service resource should have additional information associated
   * with it in order to allow the client to determine how to make appropriate use of it, such as a profile link to a
   * service description. It may also have relevant information copied from the service itself. This duplication is
   * permitted in order to increase the performance of rendering the object without necessitating additional HTTP
   * requests. Please see the Service Profiles document for known services.
   *
   * - Any resource type may have one or more links to an external service.
   */
  service?: OneOrMany<Service>;

  /**
   * A link to a machine readable document that semantically describes the resource with the seeAlso property, such as
   * an XML or RDF description. This document could be used for search and discovery or inferencing purposes, or just
   * to provide a longer description of the resource. The profile and format properties of the document should be given
   * to help the client to make appropriate use of the document.
   *
   * - Any resource type may have one or more external descriptions related to it.
   */
  seeAlso?: OneOrMany<ContentResource>;

  /**
   * A link to a resource that contains the current resource, such as annotation lists within a {@link Layer layer}.
   * This also allows linking upwards to {@link Collection collections} that allow browsing of the digitized objects
   * available.
   *
   * - {@link Collection Collections} or {@link AnnotationList annotation lists} that serve as pages must be within
   *   exactly one paged resource.
   * - Other resource types, including collections or annotation lists not serving as pages, may be within one or more
   *   containing resources.
   */
  within?: OneOrMany<ContentResource | string>;

  /**
   * A link from a {@link Sequence sequence} or {@link Range range} to a {@link Canvas canvas} that is contained within
   * the sequence. On seeing this relationship, a client should advance to the specified canvas when
   * beginning navigation through the sequence/range. This allows the client to begin with the first canvas that
   * contains interesting content rather than requiring the user to skip past blank or empty canvases manually.
   *
   * - A {@link Sequence sequence} or a {@link Range range} may have exactly one canvas as its start canvas.
   * - Other resource types must not have a start canvas.
   */
  startCanvas?: { '@id': string; type: 'sc:Canvas' } | string;

  /**
   * A link from a {@link Range range} to a {@link Layer layer} that includes the annotations of content resources for
   * that range. Clients might use this to present content to the user from a different canvas when interacting with
   * the range, or to jump to the next part of the range within the same {@link Canvas canvas}.
   *
   * - A {@link Range range} may have exactly one layer as its content layer.
   * - Other resource types must not have a content layer.
   */
  contentLayer?: string | Layer;
};
