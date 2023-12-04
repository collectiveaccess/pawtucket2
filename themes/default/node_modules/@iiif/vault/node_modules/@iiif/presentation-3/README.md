# IIIF Presentation 3 types
A set of types that describe the format of the IIIF Presentation 3.0 specification as accurately as possible.

Installation:
```
$ npm i @iiif/presentation-3
```
Installation (yarn):
```
$ yarn add @iiif/presentation-3
```

Usage (Typescript):
```typescript
import { Manifest } from '@iiif/presentation-3';

const manifest = getManifestFromSomewhere() as Manifest;

function doSomethingWithManifest(manifest: Manifest) {
 // ...
}
```

Usage (Javascript):
```javascript
/**
 * @typedef { import("@iiif/presentation-3").Manifest } Manifest
 */

/**
 * @type {Manifest}
 */
const manifest = {};


/**
 * @param manifest {Manifest}
 */
function doSomethingWithManifest(manifest) {
    console.log(manifest.label);
}

// You can also inline the import:

/**
 * @type {import("@iiif/presentation-3").Manifest}
 */
const manifest2 = {};
```

This will enable types completions in VSCode and IDEA, along with inline documentation from the IIIF specification:
<img width="713" alt="Screenshot 2021-03-28 at 17 11 14" src="https://user-images.githubusercontent.com/8266711/112759081-4b651600-8fe9-11eb-83c6-9739d557716d.png" />

### Support

The following types are supported:

* Manifest
* Collection
* Canvas
* Annotation
* Annotation Collection
* Annotation Page
* Content Resource
* Provider
* Range
* Service 

With some other types that aim to cover common services:
* Auth service
* GeoJSON service
* Image service 
* Search service


### Full List of types

#### Basic types

Type | Description
--- | ---
**ResourceType** | String literals for the possible values of `type`
**InternationalString** | Common language property (`{ "none": ["..."] }`)
**Reference** | A reference to another resources (`{id: '..', type: '..'}`)
**JsonLDContext** | A partial of `{'@context': ... }`, extended by resources with contexts
**MetadataItem** | Label value pair used in the metadata field
**SpecificationBehaviors** | String literals for supported behaviors mentioned in the specification
**SpecificationTimeMode** | String literals for supported time modes mentioned in the specification
**ViewingDirection** | String literal for the 4 supported viewing directions

#### Resources

Type | Description
--- | ---
**Service** | Any service that can appear in services property. Union of generic and specific services.
**Manifest** | Types for a valid IIIF Manifest    
**Canvas** | Types for a valid IIIF Canvas
**ContentResource** | Types for a Content Resource - warning this can be many things!
**AnnotationPage** | Types for a valid Annotation page
**Annotation** | Types for a valid Annotation in the context of a IIIF manifest
**AnnotationW3C** | Types for a valid W3C annotation (different from above)
**Collection** | Types for a valid IIIF Collection
**Range** | Types for a valid IIIF Range
**AnnotationCollection** | Types for a valid Annotation collection 
**IIIFExternalWebResource** | Abstract type for an external web resource  
**ContentResourceString** | Alias for `string` 


#### Resource items (structural)

Type | Description
--- | ---
**CanvasItems** | Alias for Annotation Page
**CollectionItems** | Union of Manifest or Collection
**ManifestItems** | Alias for Canvas
**RangeItems** | Union of Range, Canvas or string

#### Services

Type | Description
--- | ---
**AuthAccessTokenServiceError** | [todo]
**AuthAccessTokenServiceResponse** | [todo]
**AuthAbstractService** | [todo]
**AuthAccessTokenService** | [todo]
**AuthExternalService** | [todo]
**AuthClickThroughService** | [todo]
**AuthKioskService** | [todo]
**AuthLoginService** | [todo]
**AuthLogoutService** | [todo]
**AuthService** | [todo]
**GeoJsonService** | [todo]
**ImageService** | [todo]
**ImageService2** | [todo]
**ImageServiceProfile** | [todo]
**ImageProfile** | [todo]
**ImageService3** | [todo]
**ImageSize** | [todo]
**ImageTile** | [todo]
**SearchService** | [todo]
**SearchServiceAutocomplete** | [todo]
**SearchServiceAutocompleteQueryParams** | [todo]
**SearchServiceAutocompleteResponse** | [todo]
**SearchServiceCommonHitSelectors** | [todo]
**SearchServiceCommonResources** | [todo]
**SearchServiceQueryParams** | [todo]
**SearchServiceSearchCommonSelectors** | [todo]
**SearchServiceSearchResponse** | [todo]

#### W3C Annotations

Most of these types are not exported, but internally follows the full W3C specification.

[W3C Model Specification](https://www.w3.org/TR/annotation-model)

Type | Description
--- | ---
**Agent** | [todo]
**AnnotationBody** | [todo]
**AnnotationTarget** | [todo]
**AnyMotivation** | [todo]
**Audience** | [todo]
**Body** | [todo]
**ChoiceBody** | [todo]
**ChoiceTarget** | [todo]
**Creator** | [todo]
**BasicState** | [todo]
**CssSelector** | [todo]
**DataPositionSelector** | [todo]
**FragmentSelector** | [todo]
**Selector** | [todo]
**RefinedBy** | [todo]
**RefinedByState** | [todo]
**EmbeddedResource** | [todo]
**ExternalResourceTypes** | [todo]
**ExternalWebResource** | [todo]
**RangeSelector** | [todo]
**RequestHeaderState** | [todo]
**SpecificResource** | [todo]
**State** | [todo]
**SvgSelector** | [todo]
**TextPositionSelector** | [todo]
**TextQuoteSelector** | [todo]
**TimeState** | [todo]
**XPathSelector** | [todo]
**Stylesheet** | [todo]
**Target** | [todo]
**TargetComposite** | [todo]
**TargetList** | [todo]
**TargetIndependents** | [todo]
**W3CAnnotationBody** | [todo]
**W3CAnnotationCollection** | [todo]
**W3CAnnotationPage** | [todo]
**W3CAnnotationTarget** | [todo]
**W3CMotivation** | [todo]
**LinkedResource** | [todo]
**ResourceBaseProperties** | [todo]
**OtherProperties** | [todo]

#### Normalized resources

This is map of all the resources normalized where the following modifications are assumed to have been made:

- Everything property exists either as null, or an empty array
- Nested resources are replaced with references (id/type)

The types do not have a tool to create these types, but may be useful for implementations.

Type | Description
--- | ---
**DescriptiveNormalized** | Normalized abstract with all descriptive properties
**LinkingNormalized** | Normalized abstract with all linking properties
**StructuralNormalized** | Normalized abstract with all structural properties
**OtherPropertiesNormalized** | Misc properties on W3C Annotations normalized
**AnnotationW3cNormalised** | Normalized W3C Annotation
**AnnotationCollectionNormalized** | Normalized Annotation Collection
**AnnotationNormalized** | Normalized Annotation as it appears in a IIIF Manifest
**AnnotationPageNormalized** | Normalized Annotation Page
**CanvasNormalized** | Normalized Canvas
**CollectionNormalized** | Normalized Collection
**CreatorNormalized** | Normalized Creator (from annotation)
**ManifestNormalized** | Normalized Manifest
**RangeNormalized** | Normalized Range
**ServiceNormalized** | Normalized Service - note: normalizing services is not recommend


#### Partial / Abstract types
These types are building blocks of other types.

Type | Description
--- | ---
**LinkingProperties** | The linking properties of IIIF in a map `LinkingProperties['seeAlso']`
**DescriptiveProperties** | The descriptive properties of IIIF in a map `DescriptiveProperties['label']`
**TechnicalProperties** | The technical properties of IIIF in a map `DescriptiveProperties['id']`
**StructuralProperties** | The structural properties of IIIF in a map `DescriptiveProperties['annotations']`

#### Helpers

Type | Description
--- | ---
**OmitProperties** | Helper for removing properties from another type
**IdOrAtId** | Helper for resources that can have either `id` or `@id`
**SomeRequired** | Helper for requiring some properties from another type
**Required** | Helper for requiring all properties from another type

