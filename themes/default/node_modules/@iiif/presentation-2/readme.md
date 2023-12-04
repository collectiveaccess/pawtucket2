# IIIF Presentation 2 types
A set of types that describe the format of the IIIF Presentation 2.1.1 specification as accurately as possible. Types
are also available for [IIIF Presentation 3](https://github.com/IIIF-Commons/presentation-3-types)

Installation:
```
$ npm i @iiif/presentation-2
```
Installation (yarn):
```
$ yarn add @iiif/presentation-2
```

Usage (Typescript):
```typescript
import { Manifest } from '@iiif/presentation-2';

const manifest = getManifestFromSomewhere() as Manifest;

function doSomethingWithManifest(manifest: Manifest) {
 // ...
}
```

Usage (Javascript):
```javascript
/**
 * @typedef { import("@iiif/presentation-2").Manifest } Manifest
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
 * @type {import("@iiif/presentation-2").Manifest}
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
* Annotation (Open Annotation)
* Annotation List  (Open Annotation)
* Layer
* Content Resource
* Provider
* Range
* Service

#### Partial / Abstract types
These types are building blocks of other types.

Type | Description
--- | ---
**TechnicalProperties** | The technical properties of IIIF in a map `TechnicalProperties['id']`
**DescriptiveProperties** | The descriptive properties of IIIF in a map `DescriptiveProperties['label']`
**LinkingProperties** | The linking properties of IIIF in a map `LinkingProperties['related']`
**PagingProperties** | The paging properties of IIIF in a map `PagingProperties['first']`
**RightsProperties** | The structural properties of IIIF in a map `RightsProperties['attribution']`
