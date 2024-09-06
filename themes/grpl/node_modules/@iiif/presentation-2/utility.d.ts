/**
 * Many of the properties in the API may be repeated. This is done by giving a list of values, using either of the
 * representations described above, rather than a single string.
 */
export declare type OneOrMany<T> = T | Array<T>;

/**
 * Resource descriptions should be embedded within higher-level descriptions, and may also be available via separate
 * requests from http(s) URIs linked in the responses. These URIs are in the @id property for the resource. Links to
 * resources may be either given as just the URI if there is no additional information associated with them, or as a
 * JSON object with the @id property. Other URI schemes may be used if the resource is not able to be retrieved via
 * HTTP. Both options provide the same URI, however the second pattern associates additional information with the
 * resource:
 * ```
 *    // Option A, plain string
 *    {"seeAlso": "http://example.org/descriptions/book1.xml"}
 * ```
 *
 * ```
 *    // Option B, object with @id property
 *    {"seeAlso": {"@id": "http://example.org/descriptions/book1.xml", "format": "text/xml"}}
 * ```
 *
 * Many of the properties in the API may be repeated. This is done by giving a list of values, using either of the
 * representations described above, rather than a single string.
 * ```
 *   {
 *    "seeAlso": [
 *      "http://example.org/descriptions/book1.md",
 *      "http://example.org/descriptions/book1.csv",
 *      {"@id": "http://example.org/descriptions/book1.xml", "format": "text/xml"}
 *    ]
 *  }
 * ```
 *
 */
export declare type URIRepresentation = string | { '@id': string; format?: string };

/**
 * Minimal HTML markup may be included in the description, attribution and metadata properties. It must not be used in
 * label or other properties. This is included to allow manifest creators to add links and simple formatting
 * instructions to blocks of text. The content must be well-formed XML and therefore must be wrapped in an element
 * such as p or span. There must not be whitespace on either side of the HTML string, and thus the first character in
 * the string must be a ‘<’ character and the last character must be ‘>’, allowing a consuming application to test
 * whether the value is HTML or plain text using these. To avoid a non-HTML string matching this, it is recommended
 * that an additional whitespace character be added to the end of the value.
 *
 * In order to avoid HTML or script injection attacks, clients must remove:
 *
 * - Tags such as script, style, object, form, input and similar.
 * - All attributes other than href on the a tag, src and alt on the img tag.
 * - CData sections.
 * - XML Comments.
 * - Processing instructions.
 * - Clients should allow only a, b, br, i, img, p, and span tags. Clients may choose to remove any and all tags,
 *   therefore it should not be assumed that the formatting will always be rendered.
 */
export declare type HTMLMarkup = string;

/**
 * Language may be associated with strings that are intended to be displayed to the user with the following pattern of
 * `@value` plus the RFC 5646 code in `@language`, instead of a plain string. For example:
 *
 * ```
 *   {"description": {"@value": "Here is a longer description of the object", "@language": "en"}}
 * ```
 *
 * This pattern may be used in label, description, attribution and the label and value fields of the metadata
 * construction.
 *
 * Note that RFC 5646 allows the script of the text to be included after a hyphen, such as ar-latn, and clients should
 * be aware of this possibility. This allows for full internationalization of the user interface components described
 * in the response, as the labels as well as values may be translated in this manner; examples are given below.
 *
 * In the case where multiple values are supplied, clients must use the following algorithm to determine which values
 * to display to the user.
 *
 * - If none of the values have a language associated with them, the client must display all of the values.
 * - Else, the client should try to determine the user’s language preferences, or failing that use some default
 *   language preferences. Then:
 *   - If any of the values have a language associated with them, the client must display all of the values associated
 *     with the language that best matches the language preference.
 *   - If all of the values have a language associated with them, and none match the language preference, the client
 *     must select a language and display all of the values associated with that language.
 *   - If some of the values have a language associated with them, but none match the language preference, the client
 *     must display all of the values that do not have a language associated with them.
 */
export declare type LanguageProperty = HTMLMarkup | string | { '@language': string; '@value': string };

export declare type Required<T> = T extends object ? { [P in keyof T]-?: NonNullable<T[P]> } : T;

export declare type OmitProperties<T, K extends keyof T> = Pick<T, Exclude<keyof T, K>>;

export declare type Snippet<T extends { '@id': string; '@type': string }> = {
  '@id': T['@id'];
  '@type': T['@type'];
  label?: OneOrMany<LanguageProperty>;
};
