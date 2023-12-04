export declare type TechnicalProperties = {
  /**
   * The top level resource in the response must have the @context property, and it should appear as the very first
   * key/value pair of the JSON representation. This tells Linked Data processors how to interpret the information.
   * The IIIF Presentation API context, below, must occur exactly once per response, and be omitted from any embedded
   * resources. For example, when embedding a sequence within a manifest, the sequence must not have the @context field.
   *
   * ```
   *    {"@context": "http://iiif.io/api/presentation/2/context.json"}
   * ```
   *
   * Any additional fields beyond those defined in this specification should be mapped to RDF predicates using further
   * context documents. In this case, the enclosing object must have its own @context property, and it should be the
   * first key/value pair of that object. This is required for service links that embed any information beyond a
   * profile. These contexts should not redefine profile. As the top level resource must have the IIIF Presentation
   * API context, if there are any additional contexts needed, the value will become an array of URI strings:
   *
   * ```
   *    {
   *      "@context": [
   *        "http://iiif.io/api/presentation/2/context.json",
   *        "http://example.org/extension/context.json"
   *      ]
   *    }
   * ```
   */
  '@context'?: string | string[];

  /**
   * The URI that identifies the resource. It is recommended that an HTTP URI be used for all resources. Recommended
   * HTTP URI patterns for the different classes of resource are given below. URIs from any registered scheme may be
   * used, and implementers may find it convenient to use a UUID URN of the form: "urn:uuid:uuid-goes-here-1234".
   * Resources that do not require URIs may be assigned
   * {@link http://www.w3.org/TR/rdf11-concepts/#section-blank-nodes blank node identifiers}; this is the same as
   * omitting @id.
   *
   * - A {@link Collection} must have exactly one id, and it must be the http(s) URI at which it is published.
   * - A {@link Manifest} must have exactly one id, and it must be the http(s) URI at which it is published.
   * - A {@link Sequence} may have an id and must not have more than one.
   * - A {@link Canvas} must have exactly one id, and it must be an http(s) URI. The canvas’s JSON representation should be
   *   published at that URI.
   * - A {@link ContentResource} must have exactly one id unless it is embedded in the response, and it must be the http(s)
   *   URI at which the resource is published.
   * - A {@link Range} must have exactly one id, and it must be an http(s) URI.
   * - A {@link Layer} must have exactly one id, and it must be an http(s) URI.
   * - An {@link AnnotationList} must have exactly one id, and it must be the http(s) URI at which it is published.
   * - An {@link Annotation} should have exactly one id, must not have more than one, and the annotation’s representation
   *   should be published at that URI.
   */
  '@id': string;

  /**
   * The type of the resource. For the resource types defined by this specification, the value of @type will be
   * described in the sections below. For content resources, the type may be drawn from other vocabularies.
   * Recommendations for basic types such as image, text or audio are also given in the sections below.
   *
   * - All resource types must have at least one type specified.
   * - This requirement applies only to the types described in
   *   {@link https://iiif.io/api/presentation/2.1/#resource-type-overview Section 2}. Services, Thumbnails and
   *   other resources will have their own requirements.
   */
  '@type': string;

  /**
   * The specific media type (often called a MIME type) of a content resource, for example “image/jpeg”. This is
   * important for distinguishing text in XML from plain text, for example.
   *
   * - A {@link ContentResource} may have exactly one format, and if so, it must be the value of the Content-Type header
   *   returned when the resource is dereferenced.
   * - Other resource types must not have a format.
   *
   * This is different to the formats property in the {@link https://iiif.io/api/image/3.0/ Image API}, which gives
   * the extension to use within that API. It would be inappropriate to use in this case, as format can be used with
   * any content resource, not just images.
   */
  format?: string;

  /**
   * The height of a canvas or image resource. For images, the value is in pixels. For canvases, the value does not
   * have a unit. In combination with the width, it conveys an aspect ratio for the space in which content resources
   * are located.
   *
   * - A {@link Canvas} must have exactly one height.
   * - A {@link ContentResource} may have exactly one height, given in pixels, if appropriate.
   * - Other resource types must not have a height.
   */
  height: number;

  /**
   * The width of a {@link Canvas} or {@link ContentResource}. For images, the value is in pixels. For canvases, the value does not have
   * a unit. In combination with the height, it conveys an aspect ratio for the space in which {@link ContentResource}
   * are
   * located.
   * - A {@link Canvas} must have exactly one width.
   * - A {@link ContentResource} may have exactly one width, given in pixels, if appropriate.
   * - Other resource types must not have a width.
   */
  width: number;

  /**
   * The direction that a sequence of canvases should be displayed to the user. Possible values are specified in the table below.
   *
   * - A {@link Manifest} may have exactly one viewing direction, and if so, it applies to all of its sequences unless
   *   the sequence specifies its own viewing direction.
   * - A {@link Sequence} may have exactly one viewing direction.
   * - A {@link Range} or layer may have exactly one viewing direction.
   * - Other resource types must not have a viewing direction.
   *
   * Values.
   *
   * - **left-to-right** – The object is displayed from left to right. The default if not specified.
   * - **right-to-left** – The object is displayed from right to left.
   * - **top-to-bottom** – The object is displayed from the top to the bottom.
   * - **bottom-to-top** – The object is displayed from the bottom to the top.
   */
  viewingDirection?: 'left-to-right' | 'right-to-left' | 'top-to-bottom' | 'bottom-to-top';

  /**
   * A hint to the client as to the most appropriate method of displaying the resource. This specification defines the
   * values specified in the table below. Other values may be given, and if they are, they must be URIs.
   *
   * - Any resource type may have one or more viewing hints.
   *
   * Values
   *
   * - **individuals** - Valid on {@link Collection}, {@link Manifest}, sequence and range. When used as the viewingHint of a
   *   {@link Collection}, the client should treat each of the {@link Manifest}s as distinct individual objects. For {@link Manifest},
   *   sequence and range, the {@link Canvas canvases} referenced are all distinct individual views, and should not be presented
   *   in a page-turning interface. Examples include a gallery of paintings, a set of views of a 3 dimensional object,
   *   or a set of the front sides of photographs in a {@link Collection}.
   *
   * - **paged** - Valid on {@link Manifest}, sequence and range. Canvases with this viewingHint represent pages in a bound
   *   volume, and should be presented in a page-turning interface if one is available. The first canvas is a single
   *   view (the first recto) and thus the second canvas represents the back of the object in the first {@link Canvas}.
   *
   * - **continuous** -	Valid on {@link Manifest}, sequence and range. A {@link Canvas} with this viewingHint is a partial view and an
   *   appropriate rendering might display either the {@link Canvas canvases} individually, or all of the {@link Canvas canvases} virtually stitched
   *   together in the display. Examples when this would be appropriate include long scrolls, rolls, or objects
   *   designed to be displayed adjacent to each other. If this viewingHint is present, then the resource must also
   *   have a viewingDirection which will determine the arrangement of the {@link Canvas canvases}. Note that this does not allow for
   *   both sides of a scroll to be included in the same {@link Manifest} with this viewingHint. To accomplish that, the
   *   {@link Manifest} should be “individuals” and have two ranges, one for each side, which are “continuous”.
   *
   * - **multi-part** - Valid only for {@link Collection}s. Collections with this viewingHint consist of multiple {@link Manifest}s
   *   that each form part of a logical whole. Clients might render the {@link Collection} as a table of contents, rather
   *   than with thumbnails. Examples include multi-volume books or a set of journal issues or other serials.
   *
   * - **non-paged** - Valid only for {@link Canvas canvases}. Canvases with this viewingHint must not be presented in a page turning
   *   interface, and must be skipped over when determining the page sequence. This viewing hint must be ignored if
   *   the current sequence or {@link Manifest} does not have the ‘paged’ viewing hint.
   *
   * - **top** - Valid only for ranges. A {@link Range} with this viewingHint is the top-most node in a hierarchy of ranges
   *   that represents a structure to be rendered by the client to assist in navigation. For example, a table of
   *   contents within a paged object, major sections of a 3d object, the textual areas within a single scroll, and
   *   so forth. Other ranges that are descendants of the “top” range are the entries to be rendered in the navigation
   *   structure. There may be multiple {@link Range ranges} marked with this hint. If so, the client should display a choice of
   *   multiple structures to navigate through.
   *
   * - **facing-pages** - Valid only for {@link Canvas canvases}. Canvases with this viewingHint, in a sequence or {@link Manifest} with the
   *   “paged” viewing hint, must be displayed by themselves, as they depict both parts of the opening. If all of the
   *   canvases are like this, then page turning is not possible, so simply use “individuals” instead.
   */
  viewingHint?: 'individuals' | 'paged' | 'continuous' | 'multi-part' | 'non-paged' | 'top' | 'facing-pages';

  /**
   * A date that the client can use for navigation purposes when presenting the resource to the user in a time-based
   * user interface, such as a calendar or timeline. The value must be an xsd:dateTime literal in UTC, expressed in
   * the form “YYYY-MM-DDThh:mm:ssZ”. If the exact time is not known, then “00:00:00” should be used. Similarly,
   * the month or day should be 01 if not known. There must be at most one navDate associated with any given resource.
   * More descriptive date ranges, intended for display directly to the user, should be included in the metadata
   * property for human consumption.
   *
   * - A {@link Collection} or {@link Manifest} may have exactly one navigation date associated with it.
   * - Other resource types must not have navigation dates.
   */
  navDate?: string;

  /**
   * Non-standard property.
   */
  behavior?: string[];
};
