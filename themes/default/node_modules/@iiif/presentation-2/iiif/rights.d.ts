import { LanguageProperty, OneOrMany } from '../utility';
import { ImageResourceSegment, ImageResourceSegmentWithService } from '../resources/content-resource';

/**
 * The following properties ensure that the interests of the owning or publishing institutions are conveyed regardless
 * of the viewing environment, and a client must make these properties clearly available to the user. Given the wide
 * variation of potential client user interfaces, it will not always be possible to display all or any of the properties
 * to the user in the client’s initial state. If initially hidden, the method of revealing them must be obvious, such
 * as a button or scroll bars.
 */
export declare type RightsProperties = {
  /**
   * Text that must be shown when the resource it is associated with is displayed or used. For example, this could be
   * used to present copyright or ownership statements, or simply an acknowledgement of the owning and/or publishing
   * institution. Clients should try to match the language preferred by the user, and if the preferred language is
   * unknown or unavailable, then the client may choose which value to display. If there are multiple values of the
   * same or unspecified language, then all of those values must be displayed.
   *
   * - Any resource type may have one or more attribution labels.
   */
  attribution?: OneOrMany<LanguageProperty>;

  /**
   * A link to an external resource that describes the license or rights statement under which the resource may be used.
   * The rationale for this being a URI and not a human readable label is that typically there is one license for many
   * resources, and the text is too long to be displayed to the user along with the object. If displaying the text is
   * a requirement, then it is recommended to include the information using the attribution property instead.
   *
   * - Any resource type may have one or more licenses associated with it.
   */
  license?: OneOrMany<string>;

  /**
   * A small image that represents an individual or organization associated with the resource it is attached to. This
   * could be the logo of the owning or hosting institution. The logo must be clearly rendered when the resource is
   * displayed or used, without cropping, rotating or otherwise distorting the image. It is recommended that a IIIF
   * Image API service be available for this image for manipulations such as resizing.
   *
   * - Any resource type may have one or more logos associated with it.
   */
  logo?: OneOrMany<string | ImageResourceSegment | ImageResourceSegmentWithService>;
};
