import { OmitProperties } from '../utility';
import { TechnicalProperties } from '../iiif/technical';
import { DescriptiveProperties } from '../iiif/descriptive';
import { Sequence } from './sequence';
import { LinkingProperties } from '../iiif/linking';
import { Range } from './range';
import { RightsProperties } from '../iiif/rights';

type ManifestOmittedTechnical = 'format' | 'height' | 'width';
type ManifestOmittedLinking = 'startCanvas';

type ManifestTechnical = OmitProperties<TechnicalProperties, ManifestOmittedTechnical>;
type ManifestStructural = {
  /**
   * The order of the views of the object. Multiple sequences are allowed to cover situations when there are multiple
   * equally valid orders through the content, such as when a manuscript’s pages are rebound or archival collections
   * are reordered.
   */
  sequences: Sequence[];
  structures?: Range[];
};
type ManifestLinking = OmitProperties<LinkingProperties, ManifestOmittedLinking>;

/**
 * The overall description of the structure and properties of the digital representation of an object. It carries
 * information needed for the viewer to present the digitized content to the user, such as a title and other
 * descriptive information about the object or the intellectual work that it conveys. Each manifest describes how to
 * present a single object such as a book, a photograph, or a statue.
 *
 * The manifest response contains sufficient information for the client to initialize itself and begin to display
 * something quickly to the user. The manifest resource represents a single object and any intellectual work or works
 * embodied within that object. In particular it includes the descriptive, rights and linking information for the
 * object. It then embeds the {@link Sequence sequence}(s) of {@link Canvas canvases} that should be rendered to the
 * user.
 *
 * The identifier in @id must always be able to be dereferenced to retrieve the JSON description of the manifest, and
 * thus must use the http(s) URI scheme.
 *
 * Along with the {@link DescriptiveProperties descriptive information}, there is a sequences section, which is a list
 * of JSON-LD objects. Each object describes a {@link Sequence Sequence}, discussed in the next section, that represents
 * the order of the parts of the work, each represented by a {@link Canvas}. The first such sequence must be included
 * within the manifest as well as optionally being available from its own URI. Subsequent sequences must only be
 * referenced with their identifier (@id), class (@type) and label and thus must be dereferenced by clients in order
 * to process them if the user selects to view that sequence.
 *
 * There may also be a structures section listing one or more {@link Range Ranges} which describe additional structure
 * of the content, such as might be rendered as a table of contents.
 *
 * The example below includes only the manifest-level information, however actual implementations must embed the first
 * sequence, canvas and content information. It includes examples in the descriptive metadata of how to associate
 * multiple entries with a single field and how to be explicit about the language of a particular entry.
 */
export interface Manifest
  extends ManifestTechnical,
    DescriptiveProperties,
    RightsProperties,
    ManifestStructural,
    Partial<ManifestLinking> {}
